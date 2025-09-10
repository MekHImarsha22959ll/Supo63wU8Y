<?php
// 代码生成时间: 2025-09-10 12:46:33
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

"""
 * 用户身份认证功能
 *
 * 此文件包含用户登录和登出的路由定义
 * 以及相应的控制器方法
 *
 * @author 你的姓名
 * @version 1.0
 * @since 2023-04-01
 *"""

// 定义用户登录路由
Route::post('/login', [UserController::class, 'login']);

// 定义用户登出路由
Route::post('/logout', [UserController::class, 'logout']);

class UserController extends Controller
{
    """
     * 用户登录方法
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *"""
    public function login(Request $request)
    {
        // 验证请求数据
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // 尝试用户认证
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                // 发送成功响应
                return response()->json(['message' => 'User logged in successfully', 'user' => $user]);
            } else {
                // 发送失败响应
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            // 处理异常
            return response()->json(['message' => 'Error logging in', 'error' => $e->getMessage()], 500);
        }
    }

    """
     * 用户登出方法
     *
     * @return \Illuminate\Http\RedirectResponse
     *"""
    public function logout()
    {
        // 用户登出
        Auth::logout();

        // 发送成功响应
        return response()->json(['message' => 'User logged out successfully']);
    }
}
