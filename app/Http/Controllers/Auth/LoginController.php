<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/home';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'username';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
        $this->middleware('guest:teacher')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('student')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ],$request->get('remember'))) {
            return redirect()->intended('student');
        }
        if (Auth::guard('teacher')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ],$request->get('remember'))) {
            return redirect()->intended('teacher');
        }
        if (Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ],$request->get('remember'))) {
            return redirect()->intended('admin');
        }
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ],$request->get('remember'))) {
            return redirect()->intended('home');
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }
}
