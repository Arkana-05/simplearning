<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = null;

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

    public function login(Request $request)
    {
        $data = [
            'email.required' => 'Email Harus di isi',
            'password.required' => 'Password Harus di isi'
        ];

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], $data );

        if (auth()->attempt($credentials)) {
            return redirect('backend/dashboard')->with('success', 'Berhasil Login!');;
        }else{
            return redirect()->to('login')->with('error', 'Password atau username Salah');
        }
    }
}
