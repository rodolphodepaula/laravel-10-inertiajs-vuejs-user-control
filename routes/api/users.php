<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('users', UserController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);

    Route::get('/api/users', [UserController::class, '@index'])->name('api.users.index');
});
