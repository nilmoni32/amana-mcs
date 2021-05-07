<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BMController;
use App\Http\Controllers\GMController;
use App\Http\Controllers\MOController;
use App\Http\Controllers\ASMController;
use App\Http\Controllers\DGMController;
use App\Http\Controllers\RSMController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BMNomineeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MONomineeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

	Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //Default settings 
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    // Branch list
    Route::group(['prefix' => 'branch'], function(){
        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('/create', [BranchController::class, 'create'])->name('branch.create');
        Route::post('/store', [BranchController::class, 'store'])->name('branch.store');
        Route::get('/edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
        Route::post('/update', [BranchController::class, 'update'])->name('branch.update');
        Route::get('/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
    });
    // MO Chain Code Entry
    Route::group(['prefix' => 'chaincode/mo'], function(){
        Route::get('/', [MOController::class, 'index'])->name('MOcode.index');
        ## Ajax Route: Ajax datatable for pagination, search and sort. 
        Route::get('/getmodata', [MOController::class, "getmodata"])->name('MOcode.getmodata');
        Route::get('/create', [MOController::class, 'create'])->name('MOcode.create');
        Route::post('/store', [MOController::class, 'store'])->name('MOcode.store');
        Route::get('/show/{id}', [MOController::class, 'show'])->name('MOcode.show'); 
        Route::get('/edit/{id}', [MOController::class, 'edit'])->name('MOcode.edit');
        Route::post('/update', [MOController::class, 'update'])->name('MOcode.update');
        Route::get('/delete/{id}', [MOController::class, 'delete'])->name('MOcode.delete');
    });

    // Nominee: MO Chain Code 
    Route::group(['prefix' => 'chaincode/mo/nominee'], function(){
        Route::get('/{id}', [MONomineeController::class, 'index'])->name('MOcode.nominee.index');        
        Route::get('/create/{id}', [MONomineeController::class, 'create'])->name('MOcode.nominee.create');
        Route::post('/store', [MONomineeController::class, 'store'])->name('MOcode.nominee.store');
        Route::get('/show/{id}', [MONomineeController::class, 'show'])->name('MOcode.nominee.show'); 
        Route::get('/edit/{id}', [MONomineeController::class, 'edit'])->name('MOcode.nominee.edit');
        Route::post('/update', [MONomineeController::class, 'update'])->name('MOcode.nominee.update');
        Route::get('/delete/{id}', [MONomineeController::class, 'delete'])->name('MOcode.nominee.delete');   
    });

    // BM Chain Code Entry
    Route::group(['prefix' => 'chaincode/bm'], function(){
        Route::get('/', [BMController::class, 'index'])->name('BMcode.index');
        ## Ajax Route: Ajax datatable for pagination, search and sort. 
        Route::get('/getbmdata', [BMController::class, "getbmdata"])->name('BMcode.getbmdata');
        Route::get('/create', [BMController::class, 'create'])->name('BMcode.create');
        Route::post('/store', [BMController::class, 'store'])->name('BMcode.store');
        Route::get('/show/{id}', [BMController::class, 'show'])->name('BMcode.show'); 
        Route::get('/edit/{id}', [BMController::class, 'edit'])->name('BMcode.edit');
        Route::post('/update', [BMController::class, 'update'])->name('BMcode.update');
        Route::get('/delete/{id}', [BMController::class, 'delete'])->name('BMcode.delete');        
    });

    // Nominee: BM Chain Code 
    Route::group(['prefix' => 'chaincode/bm/nominee'], function(){
        Route::get('/{id}', [BMNomineeController::class, 'index'])->name('BMcode.nominee.index');        
        Route::get('/create/{id}', [BMNomineeController::class, 'create'])->name('BMcode.nominee.create');
        Route::post('/store', [BMNomineeController::class, 'store'])->name('BMcode.nominee.store');
        Route::get('/show/{id}', [BMNomineeController::class, 'show'])->name('BMcode.nominee.show'); 
        Route::get('/edit/{id}', [BMNomineeController::class, 'edit'])->name('BMcode.nominee.edit');
        Route::post('/update', [BMNomineeController::class, 'update'])->name('BMcode.nominee.update');
        Route::get('/delete/{id}', [BMNomineeController::class, 'delete'])->name('BMcode.nominee.delete');   
    });

    // ASM Chain Code Entry
    Route::group(['prefix' => 'chaincode/asm'], function(){
        Route::get('/', [ASMController::class, 'index'])->name('ASMcode.index');
        Route::get('/create', [ASMController::class, 'create'])->name('ASMcode.create');
        Route::post('/store', [ASMController::class, 'store'])->name('ASMcode.store');
        Route::get('/edit/{id}', [ASMController::class, 'edit'])->name('ASMcode.edit');
        Route::post('/update', [ASMController::class, 'update'])->name('ASMcode.update');
        Route::get('/delete/{id}', [ASMController::class, 'delete'])->name('ASMcode.delete');
    });

    // RSM Chain Code Entry
    Route::group(['prefix' => 'chaincode/rsm'], function(){
        Route::get('/', [RSMController::class, 'index'])->name('RSMcode.index');
        Route::get('/create', [RSMController::class, 'create'])->name('RSMcode.create');
        Route::post('/store', [RSMController::class, 'store'])->name('RSMcode.store');
        Route::get('/edit/{id}', [RSMController::class, 'edit'])->name('RSMcode.edit');
        Route::post('/update', [RSMController::class, 'update'])->name('RSMcode.update');
        Route::get('/delete/{id}', [RSMController::class, 'delete'])->name('RSMcode.delete');
    });

    //  DGM Chain Code Entry
    Route::group(['prefix' => 'chaincode/dgm'], function(){
        Route::get('/', [DGMController::class, 'index'])->name('DGMcode.index');
        Route::get('/create', [DGMController::class, 'create'])->name('DGMcode.create');
        Route::post('/store', [DGMController::class, 'store'])->name('DGMcode.store');
        Route::get('/edit/{id}', [DGMController::class, 'edit'])->name('DGMcode.edit');
        Route::post('/update', [DGMController::class, 'update'])->name('DGMcode.update');
        Route::get('/delete/{id}', [DGMController::class, 'delete'])->name('DGMcode.delete');
    });

    //  GM Chain Code Entry
    Route::group(['prefix' => 'chaincode/gm'], function(){
        Route::get('/', [GMController::class, 'index'])->name('GMcode.index');
        Route::get('/create', [GMController::class, 'create'])->name('GMcode.create');
        Route::post('/store', [GMController::class, 'store'])->name('GMcode.store');
        Route::get('/edit/{id}', [GMController::class, 'edit'])->name('GMcode.edit');
        Route::post('/update', [GMController::class, 'update'])->name('GMcode.update');
        Route::get('/delete/{id}', [GMController::class, 'delete'])->name('GMcode.delete');
    });

    // To register user
    //Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    //Route::post('register', [RegisterController::class, 'register']);




});