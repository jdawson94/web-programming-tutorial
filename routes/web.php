<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;


Route::get('/', [WelcomeController::class, 'index']);

Route::resource('/visitors', VisitorController::class);

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

Route::get('/logout',[LogoutController::class, 'logout']);
    
Route::get('/users',[UserController::class, 'create']);
Route::post('/users',[UserController::class, 'store']);


