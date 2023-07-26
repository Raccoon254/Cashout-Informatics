<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback']);
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only([
        'index', 'edit', 'update', 'destroy'
    ]);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account', [AccountController::class, 'account'])->name('account.index');
    Route::post('/send-money', [TransactionController::class, 'sendMoney'])->name('send.money');
    Route::post('/deposit', [App\Http\Controllers\TransactionController::class, 'mpesaDeposit'])->name('deposit');
    Route::post('/activate', [App\Http\Controllers\TransactionController::class, 'activate'])->name('activate');
});

require __DIR__.'/auth.php';
