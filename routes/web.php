<?php

use App\Http\Controllers\RegistrationTokenController;
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
    return view('main');
});

Route::get('/token', [RegistrationTokenController::class, 'getRegistrationToken']);
Route::get('/register', function(){
    return view('register');
})->name('register');
Route::get('/token', function(){
    return view('token');
})->name('token');
Route::get('/users', function(){
    return view('users');
})->name('users');
Route::get('/users/{id}', function($id){
    return view('user', ['id'=>$id]);
});
Route::get('/positions', function(){
    return view('positions');
})->name('positions');
