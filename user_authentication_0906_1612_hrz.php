<?php
// 代码生成时间: 2025-09-06 16:12:56
// user_authentication.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserAuthenticationController extends Controller
{
    // 处理用户登录请求
    public function login(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 如果验证失败，返回错误响应
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 尝试用户登录
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // 用户登录成功，返回成功响应
            $user = Auth::user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            // 用户登录失败，返回错误响应
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    // 用户注销
    public function logout()
    {
        // 清除当前用户的认证令牌
        Auth::logout();
        // 返回成功响应
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
