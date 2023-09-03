<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
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

Route::get('/welcome', function () {
    return redirect('/');
});

// Inside web.php

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback']);
Route::post('/mpesa/queue', [MpesaController::class, 'handleQueueTimeout'])
    ->name('mpesa.queue');

Route::post('/mpesa/result', [MpesaController::class, 'handleResult'])
    ->name('mpesa.result');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::middleware(['auth','verified'])->group(function () {

    Route::resource('users', UserController::class)->only([
        'index', 'edit', 'update', 'destroy'
    ]);

    //spin to win
    Route::get('/spin', [DashboardController::class, 'spin'])->name('spin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account', [AccountController::class, 'account'])->name('account.index');
    Route::post('/send-money', [TransactionController::class, 'sendMoney'])->name('send.money');

    Route::post('/deposit', [TransactionController::class, 'mpesaDeposit'])->name('deposit');
    Route::post('/activate', [TransactionController::class, 'activate'])->name('activate');

    //withdraw
    Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');

    Route::resource('withdrawals', WithdrawController::class);
    Route::get('/user-withdrawals', [WithdrawController::class, 'userWithdrawals'])->name('user.withdrawals');

    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');
});

require __DIR__.'/auth.php';
require __DIR__.'/notifications.php';
