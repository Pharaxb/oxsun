<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('web')->user();

            if ($admin->is_ban) {
                Auth::guard('web')->logout();
                $request->session()->flash('error', $admin->ban_reason);
                return false;
            }

            return true;
        }

        return false;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->session()->has('error')) {
            return redirect()->back()->withErrors(['email' => $request->session()->get('error')]);
        }

        return redirect()->back()->withErrors([
            'email' => trans('auth.failed'),
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
