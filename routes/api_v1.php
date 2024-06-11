<?php

use App\Http\Controllers\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationTokenController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/token', [RegistrationTokenController::class, 'getRegistrationToken'])->name('api.v1.token');

Route::get('/positions', [PositionController::class, 'show'])->name('api.v1.positions');

Route::controller(UserController::class)->group(function () {
    Route::get('/users/{id}', [UserController::class, 'getUser'])->name('api.v1.getUser');
    Route::get('/users', [UserController::class, 'showUsers'])->name('api.v1.users');
    Route::post('/users', [UserController::class, 'register'])->name('api.v1.register');
});

