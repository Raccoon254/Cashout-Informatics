<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getWinningItem', function () {
    // Implement your logic to calculate the winning item index and duration here.
    // For example, you can use a random number generator or any other method to determine the winning item.

    // For demonstration purposes, let's assume the winning item index and duration are calculated as follows:
    $winningItemIndex = rand(0, 2); // Randomly select an index between 0 and 2 (assuming 3 items in the wheel).
    $duration = 4000; // Spin animation duration in milliseconds.

    return response()->json([
        'winningItemIndex' => $winningItemIndex,
        'duration' => $duration,
    ]);
});
