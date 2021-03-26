<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

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

// to enter MCS operation we need to login first
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

/* 
* laravel ui bootstrap scaffolding.....[authentication]
*/
// User login request
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User password reset form display and email send
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// User password reset
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

/* 
* End of laravel ui bootstrap scaffolding.....[authentication]
*/

   
// Protecting the dashboard route, so only authenticated user can view dashboard. 
Route::group(['middleware' => ['auth']], function () {

	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // To register user
    //Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    //Route::post('register', [RegisterController::class, 'register']);

});