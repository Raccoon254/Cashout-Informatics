<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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

    public function mpesaDeposit(Request $request)
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

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl_post_data = [
            'BusinessShortCode'=> 174379,
            'Password'=> 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMwNzExMTY0MjI3',
            'Timestamp'=> '20230711164227',
            'TransactionType'=> 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone, // Assuming the user's phone number is stored in the 'phone' field of the User model
            'PartyB' => 174379,
            'PhoneNumber' => $phone,
            'CallBackURL' => 'https://mydomain.com/path',
            'AccountReference' => 'CompanyXLTD',
            'TransactionDesc' => "Deposit of KSh. {$amount}"
        ];

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
            'Authorization:Bearer ' . $this->generateAccessToken(),
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Handle the response from M-Pesa here

        // Decode the response from JSON to PHP array
        $response_data = json_decode($response, true);

        // Check if the response is successful
        if($response_data['ResponseCode'] == "0") {
            return back()->with('success', 'Deposit initiated. Please check your phone to complete the transaction');
        } else {
            // If not successful, return an error message
            return back()->with('error', 'There was an error with your request. Please try again.');
        }
    }

    public function generateAccessToken()
    {
        $consumer_key = 'qj4zu8Ihp9sTAZKTzvKiNXQC6K7RL3Oj';
        $consumer_secret = '6MmGWDdXQmGH8o0z';
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
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
    public function activate(Request $request){

        $email = $request->email;

        if (!$email) {
            return back()->with('error', 'Please enter your email');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User does not exist');
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

        $user->status = "active";
        $user->save();

        //return back with username and message of success
        return back()->with('success', 'Account activated for '.$user->name.' successfully');

    }


}

