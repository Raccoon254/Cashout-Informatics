<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\AccountActivated;
use http\Env;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;


class TransactionController extends Controller
{
    public function sendMoney(Request $request): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:0.01',
        ]);

        //check if the user exists
        $user = User::where('email', $request->email)->first();

        $sender = Auth::user();
        $recipient = User::where('email', $request->email)->first();

        // Check if recipient exists
        if(!$recipient) {
            return back()->with('error', 'Recipient does not exist');
        }

        // Check if recipient is the same as sender
        if($sender->id === $recipient->id) {
            return back()->with('error', 'You cannot send money to yourself');
        }

        // Check if sender has enough balance
        if($sender->balance < $request->amount) {
            return back()->with('error', 'You do not have enough balance');
        }

        //check if the amount is more than 10,000
        if($request->amount > 10000) {
            return back()->with('error', 'You cannot send more than KSh. 10,000');
        }

        //add transaction fee of 5%

        $transaction_fee = $request->amount * 0.05;
        $transaction_fee = round($transaction_fee, 2);

        //add transaction fee to the transaction
        $sender->balance -= $transaction_fee;
        $sender->save();

        //check if the amount is less than 50
        if($request->amount < 50) {
            return back()->with('error', 'You cannot send less than KSh. 50');
        }

        // Create a transaction
        $transaction = Transaction::create([
            'user_id' => $sender->id,
            'transaction_type' => 'send',
            'from' => $sender->id,
            'to' => $recipient->id,
            'amount' => $request->amount,
            'date' => now(),
        ]);

        // Update sender and recipient balances
        $sender->balance -= $request->amount;
        $sender->save();

        $recipient->balance += $request->amount;
        $recipient->save();

        return back()->with('success', 'Money sent successfully to ' . $recipient->name);
    }

    //

    public function mpesaDeposit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'deposit' => 'required|numeric|min:0.01',
        ]);

        $user = Auth::user();
        $amount = $request->deposit;
        $phone = $user->contact;

        //replace 0 at the beginning with 254
        if (substr($phone, 0, 1) == "0") {
            $phone = preg_replace('/^0/', '254', $phone);
        }

        //remove + at the beginning
        if (substr($phone, 0, 1) == "+") {
            $phone = preg_replace('/^+/', '', $phone);
        }

        $businessShortCode = 6437090;
        $passKey = ENV('LIVE_MPESA_PASSKEY');
        $timestamp = Carbon::rawParse('now')->format('YmdHms');

        $password = base64_encode($businessShortCode.$passKey.$timestamp);

        $url = ENV('LIVE_MPESA_URL');
        $curl_post_data = [
            'BusinessShortCode'=> ENV('LIVE_SHORT_CODE'),
            'Password'=> $password,
            'Timestamp'=> Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType'=> 'CustomerBuyGoodsOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => ENV('TILL_NUMBER'),
            'PhoneNumber' => $phone,
            'CallBackURL' => ENV('CALLBACK_URL'),
            'AccountReference' => 'CASHOUT KENYA',
            'TransactionDesc' => "Deposit of KSh. {$amount}"
        ];

        $access_token = $this->generateAccessToken();
        //if the access token is null or empty
        if(!$access_token) {
            return back()->with('error', 'There was a server Error. Please Contacts Our Customer Care.');
        }

        $data_string = json_encode($curl_post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $access_token,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Handle the response from M-Pesa here

        // Decode the response from JSON to PHP array
        $response_data = json_decode($response, true);
        //dd($response_data);

        //check the if the response code exists in the response data
        if(!array_key_exists('ResponseCode', $response_data)) {
            return back()->with('error', 'There was a server Error. Please Contacts Our Customer Care.');
        }

        // Check if the response is successful
        if($response_data['ResponseCode'] == "0") {

            //record the transaction
            Mpesa::create([
                'merchant_request_id' => $response_data['MerchantRequestID'],
                'checkout_request_id' => $response_data['CheckoutRequestID'],
                'response_code' => $response_data['ResponseCode'],
                'response_description' => $response_data['ResponseDescription'],
                'customer_message' => $response_data['CustomerMessage'],
                'status' => 'pending',
            ]);

            //return back with success message
            return back()->with('success', 'Deposit initiated. Please enter your M-pesa pin to complete the transaction.');
        } else {
            // If not successful, return an error message
            return back()->with('error', 'There was an error with your request. Please try again.');
        }
    }

    public function generateAccessToken()
    {
        $consumer_key = ENV('LIVE_MPESA_CONSUMER_KEY');
        $consumer_secret = ENV('LIVE_MPESA_CONSUMER_SECRET');
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);

        $url = ENV('LIVE_TOKEN_URL');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;

        curl_close($curl);

        return $access_token;
    }

    //activate account
    public function activate(Request $request): \Illuminate\Http\RedirectResponse
    {

        $email = $request->email;

        if (!$email) {
            return back()->with('error', 'Please enter your email');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User does not exist');
        }

        //if the user is already active
        if($user->status == "active") {
            return back()->with('error', 'Your account is already active');
        }

        //deduct 100 from the current auth user balance
        $sender = Auth::user();

        // Check if sender has enough balance
        if($sender->balance < 100) {
            return back()->with('error', 'You do not have enough balance');
        }

        // Update sender and recipient balances
        $sender->balance -= 100;
        $sender->save();

        //create a transaction from user to cashout kenya

        Transaction::create([
            'user_id' => $sender->id,
            'transaction_type' => 'ACTIVATION',
            'from' => $sender->id,
            'to' => 'cashout kenya',
            'amount' => 100,
            'date' => Carbon::now(),
        ]);

        //message to the user and admin here
        $user->notify(new AccountActivated($user));

        // Send notification to all admin users
        $admins = User::where('type', 'admin')->get();
        Notification::send($admins, new AccountActivated($user));

        $user->status = "active";
        $user->save();

        //return back with username and message of success
        return back()->with('success', 'Account activated for '.$user->name.' successfully');

    }

    //withdraw money
    public function withdraw(Request $request) {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        // Get the amount
        $amount = $request->amount;

        // Get the current user
        $user = Auth::user();

        // Check if the user has enough balance
        if ($user->balance < $amount) {
            return back()->with('error', 'You do not have enough balance');
        }

        // Check if the amount is greater than or equal to 100
//        if ($amount < 100) {
//            return back()->with('error', 'You cannot withdraw less than KSh. 100');
//        }

        // Get the phone number
        $phone = $user->contact;

        //generate the access token
        $access_token = $this->generateAccessToken();
        //if the access token is null or empty
        if(!$access_token) {
            return back()->with('error', 'There was a server Error. Please Contacts Our Customer Care.');
        }

        // Prepare the request data
        $requestData = [
            "InitiatorName" => "",
            "SecurityCredential" => "H71V913jx2nNVaK2d1x7B3zzA5NsNtMz/LC6EZJ1gv84tPOelLJRY6lXQ9RhKyx32ea2yEw7+kNMPKE/gnhVlInh8BwP0s/XBDEvB2kSijtS8YoWlfgVOmIqwkNyVsNYmE6o0ocnxhRS85b6uEFt09wOxfSD+5oWN3/6CQ+LcstqScpg2wuJtNzNQOkGYTfdu19afHlV1dptR4oR7XsfXT5qEsipYxuF2wQIG8bvbFc8JOq8OJgE60m9ZQyeRtTL9OcJEJfJQ6RnMogFYWjao2r1zz7xBiCHg7Ixo2NPZfcIbVoCea8EyB7/Z8FUqGDdRNFdpb3GEeqJ3XcFUs/ghQ==",
            "CommandID" => "BusinessPayment",
            "Amount" => $amount,
            "PartyA" => 3038675,
            "PartyB" => $phone,
            "Remarks" => "Test remarks",
            "QueueTimeOutURL" => "https://mydomain.com/b2c/queue",
            "ResultURL" => "https://mydomain.com/b2c/result",
            "Occasion" => "",
        ];

        $ch = curl_init('https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData)); // Encode data as JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        //dd($response);
        echo $response;
    }

}

