<?php
// 代码生成时间: 2025-08-05 06:55:17
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

// 定义路由和中间件来控制访问权限
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// 使用Laravel内置的Gates和Policies来控制权限
// 假设有一个名为Post的模型和一个名为PostPolicy的策略类
Gate::define('edit-post', [App\Policies\PostPolicy::class, 'update']);

// 路由中使用can方法检查权限
Route::get('/posts/{post}/edit', function ($post) {
    if (Auth::user()->can('edit-post', $post)) {
        // 用户有权限，继续处理
    } else {
        // 用户没有权限，返回错误信息
        abort(403, 'Unauthorized action.');
    }
})->name('post.edit');

// 定义HomeController，包含示例方法
class HomeController extends Controller
{
    // 显示仪表板视图
    public function showDashboard()
    {
        if (Auth::check()) {
            // 用户已登录，显示仪表板
            return view('dashboard');
        } else {
            // 用户未登录，重定向到登录页面
            return redirect()->route('login');
        }
    }

    // 编辑帖子的示例方法
    public function editPost($post)
    {
        if (auth()->user()->can('edit-post', $post)) {
            // 用户有权限，显示编辑表单
            return view('post.edit', compact('post'));
        } else {
            // 用户没有权限，返回错误信息
            abort(403, 'Unauthorized action.');
        }
    }
}

/*
 * 权限控制的代码结束
 */
