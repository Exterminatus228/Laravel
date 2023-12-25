<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('user')->group(static function () {
    Route::get('confirm/{id}', [UserController::class, 'confirm'])
        ->whereNumber(['id'])
        ->name('user.confirm');
    Route::post('signup', [UserController::class, 'signUp'])->name('signUp');
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::middleware(['auth:sanctum', 'auth.confirmed'])->group(static function () {
        Route::put('update', [UserController::class, 'update'])->name('user.update');
        Route::middleware('auth.admin')->group(static function () {
            Route::post('create', [UserController::class, 'create'])->name('user.create');
            Route::delete('delete/{id}', [UserController::class, 'delete'])
                ->whereNumber(['id'])
                ->name('user.delete');
        });
    });
});
