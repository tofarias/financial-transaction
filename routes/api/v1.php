<?php

declare(strict_types=1);

use Domain\Users\V1\Http\Controllers\ListUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['ping pong']);
});

Route::get('/users', ListUsersController::class);
