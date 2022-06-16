<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// login Routes
Route::post('/login', [AuthController::class, 'Login']);

//Register Routes
Route::post('/register', [AuthController::class, 'Register']);

//forget password Route
Route::post('/forgetpassword', [ForgetController::class, 'ForgetPassword']);
