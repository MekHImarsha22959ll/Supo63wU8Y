<?php
// 代码生成时间: 2025-08-31 17:07:09
// UserLoginSystem.php
// 这个类负责处理用户登录验证

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserLoginSystem
{
    // 用户登录方法
    public function login(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 尝试登录用户
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // 登录成功后，返回用户信息和token
            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user,
                'token' => $user->createToken('accessToken')->accessToken,
            ]);
        } else {
            // 登录失败，抛出异常
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }
    }

    // 用户登出方法
    public function logout(Request $request)
    {
        // 撤销用户token
        $request->user()->token()->revoke();
        // 返回成功消息
        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
