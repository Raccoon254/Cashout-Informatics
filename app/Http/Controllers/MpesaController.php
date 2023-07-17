<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{
    public function handleCallback(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all(); // get all the request data

        if (isset($data['Body']['stkCallback']['ResultCode'])) {
            // determine the filename based on the ResultCode
            $filename = $data['Body']['stkCallback']['ResultCode'] == 0 ? 'successful.txt' : 'failed.txt';

            // append the data to the file
            Storage::disk('local')->append($filename, json_encode($data));

            return response()->json(['status' => 'success']);
        }

        // If data is not as expected, you might want to log this as well
        Storage::disk('local')->append('error.txt', 'Received unexpected data: '.json_encode($data));
        return response()->json(['status' => 'error', 'message' => 'Unexpected data received'], 400);
    }
}
