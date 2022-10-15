<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\LoginController;


Route::get('/', [WelcomeController::class, 'index']);

Route::resource('/visitors', VisitorController::class);

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
    
    
