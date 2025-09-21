<?php
// 代码生成时间: 2025-09-21 10:06:46
// user_authentication.php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserAuthenticationController extends Controller
{
    // 用户登录方法
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // 验证用户凭据
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return 'Logged in successfully';
        }

        // 如果用户登录失败，则抛出异常
        return 'Login failed';
    }

    // 用户登出方法
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return 'Logged out successfully';
    }
}

// 定义路由
Route::post('/login', [UserAuthenticationController::class, 'login']);
Route::post('/logout', [UserAuthenticationController::class, 'logout']);