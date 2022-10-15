<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\VisitorController;


Route::get('/', [WelcomeController::class, 'index']);

Route::resource('/visitors', VisitorController::class);
    
    
