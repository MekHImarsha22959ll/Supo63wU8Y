<?php
// 代码生成时间: 2025-09-20 22:49:27
// user_authentication.php
// 这个文件包含了用户身份认证的逻辑

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthenticationService extends Controller
{
    // 用户登录
    public function login(Request $request)
    {
        // 数据验证
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 尝试用户认证
        if (Auth::attempt($credentials)) {
            // 生成认证令牌
            $token = Auth::user()->createToken('token-name')->plainTextToken;

            // 返回成功的响应
            return response()->json([
                'message' => 'User authenticated successfully.',
                'token' => $token,
            ]);
        } else {
            // 认证失败，抛出验证异常
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }
    }

    // 用户注册
    public function register(Request $request)
    {
        // 数据验证
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // 创建新用户
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 生成认证令牌
        $token = $user->createToken('token-name')->plainTextToken;

        // 返回成功的响应
        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
        ]);
    }

    // 用户登出
    public function logout()
    {
        // 撤销当前用户的令牌
        Auth::user()->tokens()->delete();

        // 返回成功的响应
        return response()->json(['message' => 'User logged out successfully.']);
    }
}
