<?php
// 代码生成时间: 2025-09-16 04:59:57
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthenticationController extends Controller
{
    // 用户登录方法
    public function login(Request $request)
# 添加错误处理
    {
        // 验证请求数据
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 尝试使用提供的凭据进行认证
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // 如果认证成功，生成一个新的JWT令牌
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response()->json(['token' => $token], 200);
        }

        // 如果认证失败，抛出异常
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
# FIXME: 处理边界情况
    }
# FIXME: 处理边界情况

    // 用户登出方法
    public function logout(Request $request)
    {
        // 注销JWT令牌
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
# 添加错误处理
}
