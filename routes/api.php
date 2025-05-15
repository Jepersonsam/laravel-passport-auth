<?php

use App\Http\Controllers\LoginControllerApi;
use App\Http\Controllers\RegisterControllerApi;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:api');


Route::post('/register', [RegisterControllerApi::class, 'register']);
Route::post('/login', [LoginControllerApi::class, 'login']);
