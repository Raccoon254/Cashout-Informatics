<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Inside web.php

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account', [AccountController::class, 'account'])->name('account.index');
    Route::post('/send-money', [TransactionController::class, 'sendMoney'])->name('send.money');
    Route::post('/deposit', [App\Http\Controllers\TransactionController::class, 'mpesaDeposit'])->name('deposit');
    Route::post('/activate', [App\Http\Controllers\TransactionController::class, 'activate'])->name('activate');
});

require __DIR__.'/auth.php';
