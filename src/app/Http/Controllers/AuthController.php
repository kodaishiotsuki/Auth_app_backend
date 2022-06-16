<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //ログイン
    public function Login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
        return response([
            'message' => 'Invalid Email Or Password',
        ], 401);
    }

    //新規登録
    public function Register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('app')->accessToken; //トークン発行

            return response([
                'message' => 'Registration successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
