<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('user')->group(static function () {
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->group(static function () {
        Route::middleware('auth.admin')->group(static function () {
            Route::post('create', [UserController::class, 'create']);
        });
    });
});
