<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\ResetRequest;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function ResetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        //1件のみ値を取得する
        $emailCheck = DB::table('password_resets')->where('email', $email)->first();
        $pinCheck = DB::table('password_resets')->where('token', $token)->first();

        //バリデーション
        if (!$emailCheck) {
            return response([
                'message' => 'Email not found',
            ], 401);
        }
        if (!$pinCheck) {
            return response([
                'message' => 'Pin Code Invalid',
            ], 401);
        }

        //usersテーブルに新しいパスワードを更新
        DB::table('users')->where('email', $email)->update(['password' => $password]);
        //password_resetsテーブルの値を削除
        DB::table('password_resets')->where('email', $email)->delete();

        return response([
            'message' => 'Password Change successful'
        ], 200);
    }
}
