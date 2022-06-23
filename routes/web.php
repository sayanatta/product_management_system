<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/check-email', 'check_email')->name('check_email');
    Route::post('/register-user', 'register_user')->name('register_user');

    Route::get('/login', 'login')->name('login');
    Route::post('/login-user', 'login_user')->name('login_user');

    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware('AuthCheckController')->group(function(){
    Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('dashboard');
    Route::resource('/products', ProductController::class);
});

