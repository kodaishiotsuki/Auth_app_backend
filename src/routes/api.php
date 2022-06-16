<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// login Routes
Route::post('/login', [AuthController::class, 'Login']);

//Register routes
Route::post('/register', [AuthController::class, 'Register']);
