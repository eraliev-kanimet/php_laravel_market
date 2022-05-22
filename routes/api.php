<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('oauth/register', [AuthController::class, 'register'])->name('register');
Route::post('oauth/login', [AuthController::class, 'login'])->name('login');