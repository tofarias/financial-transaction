<?php

declare(strict_types=1);

use Domain\Transaction\V1\Http\Controllers\CreateTransactionController;
use Domain\Transaction\V1\Http\Controllers\ListTransactionsController;
use Domain\Users\V1\Http\Controllers\ListUsersController;
use Domain\Wallets\V1\Http\Controllers\ListWalletsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['ping pong']);
});

Route::get('/users', ListUsersController::class)->name('users.index');
Route::get('/wallets', ListWalletsController::class)->name('wallets.index');
Route::get('/transactions', ListTransactionsController::class)->name('transactions.index');
Route::post('/transfer', CreateTransactionController::class);
