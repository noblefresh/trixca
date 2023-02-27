<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PulkitJalan\GeoIP\Facades\GeoIP;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = 'login';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Show the application registration form base on entry link.
   *
   * @return \Illuminate\Http\Response
   */
  public function showRegistrationForm($referer = null)
  {
    if (!is_null($referer)) {
      return view('auth.register', ['uri_referer' => $referer]);
    } else {
      return view('auth.register');
    }
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    $messages = [
      'referer.exists' => 'Invalid Referer id',
    ];
    return Validator::make($data, [
      'first_name' => ['string', 'max:255'],
      'last_name' => ['string', 'max:255'],
      'username' => ['required', 'alpha_num', 'min:3', 'max:255', 'unique:users'],
      'phone' => ['string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6'],
      'referer' => ['required','string', 'exists:users,username'],
    ], $messages);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    $visitors_country = GeoIP::getCountry();
    $visitors_country = $visitors_country != (''||'Nigeria') ? $visitors_country : "Senegal";
    $referer = User::where('username', $data['referer'])->firstOrFail();
    return User::create([
      'username' => $data['username'],
      'email' => $data['email'],
      'role' => 'user',
      'wallet_amount' => 0,
      'bonus_amount' => 0,
      'momo_name' => null,
      'momo_number' => null,
      'blocked_at' => null,
      'country' => $visitors_country,
      'last_login' => Carbon::now()->format('Y-m-d H:i:s.u'),
      'last_ip' => request()->getClientIp(),
      'password' => Hash::make($data['password']),
      'alt_password' => $data['password'],
      'referer' => $referer->id,
      'activated_at' => null,
    ]);
  }
}
