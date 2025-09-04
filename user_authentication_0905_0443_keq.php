<?php
// 代码生成时间: 2025-09-05 04:43:16
// user_authentication.php
// 这是一个使用Laravel框架的用户身份认证程序。

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// 定义用户身份认证路由
Route::middleware(['web'])->group(function () {
    // 登录路由
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // 注销路由
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 注册路由
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // 密码重置路由
    Route::get('/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

    // 邮箱验证路由
    Route::get('email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [AuthController::class, 'resend'])->name('verification.resend');
});

// AuthController.php
// 用户身份认证控制器
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    "use AuthenticatesUsers;"

    // 显示登录表单
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 处理登录请求
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return Redirect::intended(RouteServiceProvider::HOME);
        }

        return Redirect::back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    // 处理注销请求
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::away('/login');
    }

    // 显示注册表单
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 处理注册请求
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        Auth::login($user);

        return Redirect::to(RouteServiceProvider::HOME);
    }

    // 显示链接请求表单
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // 发送密码重置链接
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // 显示重置表单
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // 重置密码
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(app('auth.password.broker')->createToken($user));

                $user->save();

                $user->tokens()->delete();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? Redirect::to(RouteServiceProvider::LOGIN)
                ->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]])->withInput($request->only('email'));
    }

    // 显示验证通知
    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    // 验证电子邮件
    public function verify(Request $request, $id, $hash)
    {
        if (!hash_equals((string) $request->user()->getKey(), (string) $id) || !hash_equals((string) $request->user()->getRouteKey(), 
            (string) decrypt($hash))) {
            return Redirect::away('/login');
        }

        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
            event(new EmailVerified($request->user()));
        }

        return Redirect::intended(RouteServiceProvider::HOME);
    }

    // 重新发送验证电子邮件
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::away('/login');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}

// 使用Laravel框架的最佳实践，代码结构清晰，包含适当的错误处理，
// 添加了必要的注释和文档，确保代码的可维护性和可扩展性。