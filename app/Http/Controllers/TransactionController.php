<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Models\Mpesa;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\AccountActivated;
use App\Notifications\AccountActivatedAdmin;
use App\Notifications\EarningSavedNotification;
use App\Notifications\ReferralBonusNotification;
use App\Notifications\WithdrawalRequested;
use App\Notifications\WithdrawalRequestedAdmin;
use http\Env;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class TransactionController extends Controller
{
    public function sendMoney(Request $request): RedirectResponse
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

        //add transaction fee of 0.15%
        $transaction_fee = $request->amount * 0.055;
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

        //get id for tomsteve@gmail.com
        $steve_id = User::where('email', 'tomsteve187@gmail.com')->first()->id;

        //Record the transaction to the Earnings table
        $earning = Earning::create([
            'user_id' => $steve_id,
            'from' => $sender->id,
            'amount' => $transaction_fee,
            'total_amount' => Earning::where('user_id', $steve_id)->sum('amount') + 100,
            'description' => 'Earnings from transaction fee',
            'type' => 'transaction_fee',
        ]);

        $tomSteveUser = User::where('email', 'tomsteve187@gmail.com')->first();
        if ($tomSteveUser) {
            $tomSteveUser->notify(new EarningSavedNotification());
        }

        return back()->with('success', 'Money sent successfully to ' . $recipient->name);
    }

    //

    public function mpesaDeposit(Request $request): RedirectResponse
    {
        $request->validate([
            'deposit' => 'required|numeric|min:5',
        ]);

        $user = Auth::user();
        $amount = $request->deposit;
        $phone = $user->contact;

        //replace 0 at the beginning with 254
        if (str_starts_with($phone, "0")) {
            $phone = preg_replace('/^0/', '254', $phone);
        }

        //remove + at the beginning
        if (str_starts_with($phone, "+")) {
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
            return back()->with('error', 'There was a server Error. Please Contact Our Customer Care.');
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
    public function activate(Request $request): RedirectResponse
    {

        $email = $request->email;
        $activaton_fee = ENV('ACTIVATION_FEE');

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

        //deduct from the current auth user balance
        $sender = Auth::user();

        // Check if user has enough balance
        if($sender->balance < $activaton_fee) {
            return back()->with('error', 'You do not have enough balance to activate this account, please deposit '.$activaton_fee.' to your account and try again.');
        }

        // Update sender balances
        $sender->balance -= $activaton_fee;
        $sender->save();



        // Check if the user has a referrer
        if (!$user->referred_by==null) {
            $referrer_code = $user->referred_by;

            $referrer = User::where('referral_code', $referrer_code)->first();

            $activationAmount = $activaton_fee;
            $referralAmount = 0.7 * $activationAmount;

            // Update the referrer's balance
            $referrer->balance += $referralAmount;
            $referrer->save();

            // Create a transaction for the referral bonus
            Transaction::create([
                'user_id' => $referrer->id,
                'transaction_type' => 'REFERRAL_BONUS',
                'from' => $user->id,
                'to' => $referrer->id,
                'amount' => $referralAmount,
                'date' => Carbon::now(),
            ]);

            //notify the referrer
            $referrer->notify(new ReferralBonusNotification($referrer, $user));

            //create a transaction from user to cashout kenya

            Transaction::create([
                'user_id' => $sender->id,
                'transaction_type' => 'ACTIVATION',
                'from' => $sender->id,
                'to' => 'cashout kenya',
                'amount' => 0.3 * $activationAmount,
                'date' => Carbon::now(),
            ]);

            //get id for tomsteve@gmail.com
            $steve_id = User::where('email', 'tomsteve187@gmail.com')->first()->id;

            //Record the transaction to the Earnings table
            $earning = Earning::create([
                'user_id' => $steve_id,
                'from' => $user->id,
                'amount' => 0.3 * $activationAmount,
                'total_amount' => Earning::where('user_id', $steve_id)->sum('amount') + (0.3 * $activationAmount),
                'description' => 'Earnings from '.$user->name.' activation',
                'type' => 'Activation_with_referral',
            ]);

            $tomSteveUser = User::where('email', 'tomsteve187@gmail.com')->first();
            if ($tomSteveUser) {
                $tomSteveUser->notify(new EarningSavedNotification());
            }


        }else{

            //create a transaction from user to cashout kenya
            Transaction::create([
                'user_id' => $sender->id,
                'transaction_type' => 'ACTIVATION',
                'from' => $sender->id,
                'to' => 'cashout kenya',
                'amount' => $activaton_fee,
                'date' => Carbon::now(),
            ]);

            //get id for tomsteve@gmail.com
            $steve_id = User::where('email', 'tomsteve187@gmail.com')->first()->id;

            //Record the transaction to the Earnings table
            $earning = Earning::create([
                'user_id' => $steve_id,
                'from' => $user->id,
                'amount' => $activaton_fee,
                'total_amount' => Earning::where('user_id', $steve_id)->sum('amount') + $activaton_fee,
                'description' => 'Earnings from '.$user->name.' activation',
                'type' => 'Activation_no_referral',
            ]);

            $tomSteveUser = User::where('email', 'tomsteve187@gmail.com')->first();
            if ($tomSteveUser) {
                $tomSteveUser->notify(new EarningSavedNotification());
            }
        }

        //message to the user and admin here
        $user->notify(new AccountActivated($user));
        $user->status = "active";
        $user->save();
        // Send notification to all admin users
        $admins = User::where('type', 'admin')->get();
        //if there are admins
        if ($admins) {
            foreach ($admins as $admin) {
                $admin->notify(new AccountActivatedAdmin($user));
            }
        }

        //return back with username and message of success
        return back()->with('success', 'Account activated for '.$user->name.' successfully');

    }

    //withdraw money
    public function withdraw(Request $request): RedirectResponse
    {
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

        // Check if the amount is greater 200
        if ($amount < 200) {
            return back()->with('error', 'You cannot withdraw less than KSH 200');
        }

        // Calculate the fee as .55% of the amount
        $fee = 0.055 * $amount;

        // Deduct the withdrawal amount and fee from the user's balance
        $user->balance -= ($amount + $fee);

        //get id for tomsteve@gmail.com
        $steve_id = User::where('email', 'tomsteve187@gmail.com')->first()->id;

        //Record the transaction to the Earnings table
        $earning = Earning::create([
            'user_id' => $steve_id,
            'from' => $user->id,
            'amount' => $fee,
            'total_amount' => Earning::where('user_id', $steve_id)->sum('amount') + $fee,
            'description' => 'Earnings from withdrawal transaction',
            'type' => 'Transaction_fee',
        ]);

        $user->save();

        // Create the withdrawal request
        $withdrawal = new Withdrawal([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
            'contact' => $user->contact,
            'fee' => $fee,
        ]);

        $tomSteveUser = User::where('email', 'tomsteve187@gmail.com')->first();
        if ($tomSteveUser) {
            $tomSteveUser->notify(new EarningSavedNotification());
        }

        $withdrawal->save();

        // Send notification to the user
        $user->notify(new WithdrawalRequested($withdrawal));
        //notify the admin
        $admins = User::where('type', 'admin')->get();
        Notification::send($admins, new WithdrawalRequestedAdmin($withdrawal, $user));

        return back()->with('success', 'Withdrawal request submitted successfully');
    }



}

