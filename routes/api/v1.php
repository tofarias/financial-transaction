<?php

declare(strict_types=1);

use Domain\Users\V1\Http\Controllers\ListUsersController;
use Domain\Wallets\V1\Http\Controllers\ListWalletsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['ping pong']);
});

Route::get('/users', ListUsersController::class);
Route::get('/wallets', ListWalletsController::class);
