<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Illuminate\Http\Request;
use App\Models\User;

use Auth;
use DB;
use Mail;
use Illuminate\Support\Facades\Hash;


class ForgetController extends Controller
{
    public function ForgetPassword(ForgetRequest $request)
    {
        $email = $request->email;
        //generate Random Token
        $token = rand(10, 100000); //乱数生成

        //DBにemailが存在しない場合
        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Email Invalid',
            ], 401);
        }

        try {
            //password_resetsテーブルに保存
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);
            //ユーザーのメールアドレスへ送信
            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'message' => 'Reset Password Mail send on your email',
            ], 200);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
