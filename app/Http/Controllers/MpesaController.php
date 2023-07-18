<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{
    public function handleCallback(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        if (isset($data['Body']['stkCallback']['ResultCode'])) {

            $merchantRequestId = $data['Body']['stkCallback']['MerchantRequestID'];
            $checkoutRequestId = $data['Body']['stkCallback']['CheckoutRequestID'];

            // Check if the transaction exists in our database
            $mpesaTransaction = Mpesa::where('merchant_request_id', $merchantRequestId)
                ->where('checkout_request_id', $checkoutRequestId)
                ->first();

            if ($mpesaTransaction) {
                $previous_status = $mpesaTransaction->status;

                // Update the transaction in our database
                $mpesaTransaction->update([
                    'result_code' => $data['Body']['stkCallback']['ResultCode'],
                    'result_desc' => $data['Body']['stkCallback']['ResultDesc'],
                    'mpesa_receipt_number' => $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'],
                    'transaction_date' => $data['Body']['stkCallback']['CallbackMetadata']['Item'][2]['Value'],
                    'phone_number' => $data['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'],
                    'amount' => $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'],
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
                    } else {
                        // Log the error when the user does not exist in our database
                        Storage::disk('local')->append('error.txt', 'User not found: PhoneNumber='.$mpesaTransaction->phone_number);
                        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
                    }
                }

                return response()->json(['status' => '200 OK :: success. The data is saved successfully']);
            }

            // Log the error when the transaction does not exist in our database
            Storage::disk('local')->append('error.txt', 'Transaction not found: MerchantRequestID='.$merchantRequestId.', CheckoutRequestID='.$checkoutRequestId);
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
}
