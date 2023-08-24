<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
class MpesaController extends Controller
{
    public function handleCallback(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        Storage::disk('local')->append('data.txt', 'Received data: '.json_encode($data));

        if (isset($data['Body']['stkCallback']['ResultCode'])) {

            $merchantRequestId = $data['Body']['stkCallback']['MerchantRequestID'];
            $checkoutRequestId = $data['Body']['stkCallback']['CheckoutRequestID'];

            // Check if the transaction exists in our database
            $mpesaTransaction = Mpesa::where('merchant_request_id', $merchantRequestId)->first();

            if ($mpesaTransaction) {
                $previous_status = $mpesaTransaction->status;

                $metadataItems = $data['Body']['stkCallback']['CallbackMetadata']['Item'];

                $metadata = [];
                foreach ($metadataItems as $item) {
                    $metadata[$item['Name']] = $item['Value'] ?? null;
                }

                // Update the transaction in our database
                $mpesaTransaction->update([
                    'result_code' => $data['Body']['stkCallback']['ResultCode'],
                    'result_desc' => $data['Body']['stkCallback']['ResultDesc'],
                    'mpesa_receipt_number' => $metadata['MpesaReceiptNumber'] ?? null,
                    'transaction_date' => $metadata['TransactionDate'] ?? null,
                    'phone_number' => $metadata['PhoneNumber'] ?? null,
                    'amount' => $metadata['Amount'] ?? null,
                    'status' => $data['Body']['stkCallback']['ResultCode'] == 0 ? 'successful' : 'failed'
                ]);

                // If the transaction status changed to 'successful', update user's balance
                if ($previous_status !== 'successful' && $mpesaTransaction->status === 'successful') {
                    // Find the user by phone number
                    $user = User::where('contact', $mpesaTransaction->phone_number)->first();

                    // If the user exists, update their balance
                    if ($user) {

                        $user->balance += $mpesaTransaction->amount;
                        $user->save();

                        //create a new transaction
                        $transaction = Transaction::create([
                            'user_id' => $user->id,
                            'transaction_type' => 'DEPOSIT',
                            'from' => $user->id,
                            'to' => 'account',
                            'amount' => $mpesaTransaction->amount,
                            'date' => Carbon::now(),
                        ]);

                        if (!$transaction) {
                            // Log the error when a new transaction cannot be created
                            Storage::disk('local')->append('error.txt', 'Failed to create new transaction');
                            return response()->json(['status' => 'error', 'message' => 'Failed to create new transaction'], 500);
                        }

                    } else {
                        // Log the error when the user does not exist in our database
                        Storage::disk('local')->append('error.txt', 'User not found: PhoneNumber='.$mpesaTransaction->phone_number);
                        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
                    }
                }

                return response()->json(['status' => '200 OK :: success. The data is saved successfully']);
            }

            // Log the error when the transaction does not exist in our database
            Storage::disk('local')->append('error.txt', 'Transaction not found: MerchantRequestID='.$merchantRequestId);
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        // If data is not as expected, append error message to error.txt
        Storage::disk('local')->append('error.txt', 'Received unexpected data: '.json_encode($data));
        // Return entire request data in response
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected data received',
            'received_request_data' => $data
        ], 400);
    }

    public function handleQueueTimeout(Request $request)
    {
        // Log the incoming data to a TXT file for queue timeout
        $logData = json_encode($request->all());
        $logFileName = 'mpesa_queue_timeout_' . date('Y-m-d_H-i-s') . '.txt';
        $logFilePath = storage_path('logs/mpesa/') . $logFileName;

        File::put($logFilePath, $logData);

        // Your processing logic for Mpesa queue timeout goes here

        // Return a response if needed
        return response('Queue timeout callback received and logged.', 200);
    }

    public function handleResult(Request $request)
    {
        // Log the incoming data to a TXT file for result
        $logData = json_encode($request->all());
        $logFileName = 'mpesa_result_' . date('Y-m-d_H-i-s') . '.txt';
        $logFilePath = storage_path('logs/mpesa/') . $logFileName;

        File::put($logFilePath, $logData);

        // Your processing logic for Mpesa result goes here

        // Return a response if needed
        return response('Result callback received and logged.', 200);
    }
}
