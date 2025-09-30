<?php
// 代码生成时间: 2025-10-01 01:42:31
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class UserAuthentication extends Controller
{
    // 用户登录方法
    public function login()
    {
        // 验证请求数据
        $credentials = Request::validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // 尝试使用提供的凭据进行认证
            if (Auth::attempt($credentials)) {
                // 认证成功，生成令牌
                $user = Auth::user();
                $token = $user->createToken('Auth Token');
                return response()->json(['message' => 'Login successful', 'access_token' => $token->plainTextToken], 200);
            } else {
                // 认证失败
                throw ValidationException::withMessages(['email' => ['The provided credentials do not match our records.']]);
            }
        } catch (AuthenticationException $e) {
            // 捕获认证异常
            return response()->json(['message' => 'Authentication failed'], 401);
        }
    }

    // 用户注册方法
    public function register()
    {
        // 验证请求数据
        $validatedData = Request::validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // 用户信息
        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            // 创建新用户
            $user = User::create($validatedData);
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            // 捕获异常
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }

    // 用户注销方法
    public function logout()
    {
        try {
            // 用户注销，删除令牌
            Auth::user()->tokens()->delete();
            return response()->json(['message' => 'Logout successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Logout failed', 'error' => $e->getMessage()], 500);
        }
    }
}
