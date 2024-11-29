<?php

// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public routes

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/welcome', function () {
    return 'welcome';
});

// Routes that require authentication
Route::middleware(['auth:api'])->group(function () {  // Change to auth:api for Passport
    Route::post('/logout', [AuthController::class, 'logout']);

    // Wallet routes
    Route::prefix('wallet')->group(function () {
        Route::get('/balance', [WalletController::class, 'balance'])->name('wallet.balance');
        Route::post('/fund', [WalletController::class, 'fund'])->name('wallet.fund');
    });

    // Purchase routes
    Route::prefix('purchase')->group(function () {
        Route::post('/airtime', [PurchaseController::class, 'purchase'])->name('purchase.airtime');
    });

    // Bill routes
    Route::prefix('bills')->group(function () {
        Route::post('/', [BillController::class, 'store'])->name('bills.store');
    });

    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    });
});
