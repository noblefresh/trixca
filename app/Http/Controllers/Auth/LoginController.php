<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function redirectTo()
    {
        if(Auth::user()->role == 'admin'){
            return '/admin/dashboard';
        }
        return '/user/dashboard';
    }

    protected function authenticated(Request $request, $user)
{
    $user->update([
        'last_login' => Carbon::now()->format('Y-m-d H:i:s.u'),
        'last_ip' => $request->getClientIp(),
        ]);
        Auth::User()->createToken('tricash')->accessToken;
}
}
