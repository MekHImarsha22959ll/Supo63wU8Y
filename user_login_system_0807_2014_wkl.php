<?php
// 代码生成时间: 2025-08-07 20:14:18
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    """
    * Where to redirect users after login.
    *"""
    protected $redirectTo = '/home';

    use AuthenticatesUsers, ThrottlesLogins;

    """
    * Create a new controller instance.
    *
    * @return void
    *"""
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    """
    * Show the application's login form.
    *
    * @return \Illuminate\Http\Response
    *"""
    public function showLoginForm()
    {
        return view('auth.login');
    }

    """
    * Validate the user login request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    *"""
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    """
    * Attempt to log the user into the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return bool
    *"""
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
           $this->credentials($request), $request->filled('remember')
        );
    }

    """
    * Get the needed authorization credentials from the request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    *"""
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    """
    * Send the response after the user was authenticated.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse\Illuminate\Routing\Redirector
    *"""
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    """
    * Get the failed login response instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Symfony\Component\HttpFoundation\Response
    *"""
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    """
    * Get the login username to be used by the controller.
    *
    * @return string
    *"""
    public function username()
    {
        return 'email';
    }
}
