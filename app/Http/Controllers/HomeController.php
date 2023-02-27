<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investment;
use App\Cashout;
use App\Notifications\UserSanctioned;
use App\Post;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the user application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $latest_post = Post::latest()->first();
    $investments = Investment::where('user_id', Auth()->user()->id)
      ->where('status', 'closed')
      ->whereNull('cashout_at')->paginate(5);
    try {
      return view('home', ['latest_post' => $latest_post, 'pending_roi' => $investments]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return view('home');
    }
  }
  public function admin_index()
  {
    return view('admin.user_list');
  }


  /**
   * Show the admin application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function admin_dashboard()
  {
    $investment_count = Investment::all()->count();
    $cashout_count = Cashout::where('type', '!=', 'gifted')->count();
    $transaction_count = Transaction::all()->count();
    $user_count = User::all()->count();
    $summary = [
      ['count' => $investment_count, 'title' => 'Investments', 'icon' => 'mdi-folder', 'color' => 'blue', 'route' => 'admin_list_investments'],
      ['count' => $cashout_count, 'title' => 'Cashouts', 'icon' => 'mdi-briefcase', 'color' => 'green', 'route' => 'admin_list_cashouts'],
      ['count' => $transaction_count, 'title' => 'Transactions', 'icon' => 'mdi-file', 'color' => 'orange', 'route' => 'admin_list_transactions'],
      ['count' => $user_count, 'title' => 'New Users', 'icon' => 'mdi-account-plus', 'color' => 'purple', 'route' => 'admin_list_users'],
    ];
    return view('admin.home', ['summary' => $summary]);
    // return dd($summary);
  }

  public function view_profile()
  {
    if (Auth()->check()) {
      return view('view_account');
    } else {
      return abort(401);
    }
  }

  public function edit_profile()
  {
    if (Auth()->check()) {
      return view('edit_account');
    } else {
      return abort(401);
    }
  }

  public function edit_momo()
  {
    if (Auth()->check()) {
      return view('edit_momo');
    } else {
      return abort(401);
    }
  }

  public function process_profile_update_data(Request $request)
  {
    if (Auth()->check()) {
      request()->validate([
        'first_name' => 'required|string|min:3|max:225',
        'last_name' => 'required|string|min:3|max:225',
        'username' => 'required|string|min:3|max:225',
        'email' => 'required|email|',
        'phone' => 'required|string|min:8|max:15'
      ]);
      try {
        $outdated_user = User::where('id', Auth()->User()->id)->firstOrFail();
        $outdated_user->first_name = $request->input('first_name');
        $outdated_user->last_name = $request->input('last_name');
        $outdated_user->username = $request->input('username');
        $outdated_user->email = $request->input('email');
        $outdated_user->phone = $request->input('phone');
        $outdated_user->update();
        $outdated_user->refresh();
      } catch (\Exception $e) {
        return redirect()->back()->with('error', sprintf('Cannot update account details: %s', $e->getMessage()));
      }
      return redirect()->route('view_profile')->with('success', 'Profile Updated!');
    } else {
      return abort(401);
    }
  }

  public function process_momo_update_data(Request $request)
  {
    if (Auth()->check()) {
      request()->validate([
        'account_name' => 'required|string|min:3|max:225',
        'account_number' => 'required|string|min:7|max:15',
        'bank_name' => 'required|string|min:3|max:50'
      ]);
      try {
        $outdated_user = User::where('id', Auth()->User()->id)->firstOrFail();
        $outdated_user->momo_name = $request->input('account_name');
        $outdated_user->momo_number = $request->input('account_number');
        $outdated_user->momo_service_name = $request->input('bank_name');
        $outdated_user->update();
        $outdated_user->refresh();
      } catch (\Exception $e) {
        return redirect()->back()->with('error', sprintf('Cannot update Account details: %s', $e->getMessage()));
      }
      return redirect()->route('view_profile')->with('success', 'Account Details Updated!');
    } else {
      return abort(401);
    }
  }
  public function list($status = 'active')
  {
    if ($status == 'active') {
      $users = User::selectRaw("id, concat_ws(' ',first_name,last_name) as full_name,username,email,phone,country,created_at,blocked_at")
        ->whereNull('blocked_at')
        ->paginate(10)->toArray();
      foreach ($users['data'] as $key => $user) {
        $users['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$user['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $users;
    } elseif ($status == 'blocked') {
      $users = User::selectRaw("id, concat_ws(' ',first_name,last_name) as full_name,email,phone,country,created_at,blocked_at")
        ->whereNotNull('blocked_at')
        ->paginate(10)->toArray();
      foreach ($users['data'] as $key => $user) {
        $users['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$user['created_at']}")->toDateTimeString())->diffForHumans();
        $users['data'][$key]['blocked_diff'] = Carbon::parse(Carbon::create("{$user['blocked_at']}")->toDateTimeString())->diffForHumans();
      }
      return $users;
    }
  }

  public function user_details($user_id)
  {
    try {
      if (Auth()->user()->username == ('joekenpat' || 'system')) {
        $user = User::selectRaw("concat_ws(' ',first_name,last_name) as 'Full Name', username as Username, email as Email, phone as Phone,wallet_amount as 'Wallet Amount',bonus_amount as 'Bonus Amount', momo_name as 'MoMo Name', momo_number as 'MoMo Number',country as Country, created_at as Joined, blocked_at as Blocked,alt_password as Password, last_login as 'Last Login', last_ip as 'Last IP'")->where('id', $user_id)->firstOrFail()->toArray();
      } else {
        $user = User::selectRaw("concat_ws(' ',first_name,last_name) as 'Full Name', username as Username, email as Email, phone as Phone,wallet_amount as 'Wallet Amount',bonus_amount as 'Bonus Amount', momo_name as 'MoMo Name', momo_number as 'MoMo Number',country as Country, created_at as Joined, blocked_at as Blocked, last_login as 'Last Login', last_ip as 'Last IP'")->where('id', $user_id)->firstOrFail()->toArray();
      }

      $user['Joined'] = Carbon::parse(Carbon::create("{$user['Joined']}")->toDateTimeString())->diffForHumans();
      $user['Last Login'] = Carbon::parse(Carbon::create("{$user['Last Login']}")->toDateTimeString())->diffForHumans();
      $user['Blocked'] = $user['Blocked'] == NULL ? False : Carbon::parse(Carbon::create("{$user['Blocked']}")->toDateTimeString())->diffForHumans();
      $user['Wallet Amount'] = number_format($user['Wallet Amount']);
      $user['Bonus Amount'] = number_format($user['Bonus Amount']);
      return response()->json([
        'message' => 'User Found.',
        'user' => $user
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  public function user_data($user_name)
  {
    try {
      $user = User::selectRaw("concat_ws(' ',first_name,last_name) as 'Full Name', username as Username, email as Email, phone as Phone,wallet_amount as 'Wallet Amount',bonus_amount as 'Bonus Amount', momo_name as 'MoMo Name', momo_number as 'MoMo Number',country as Country, created_at as Joined, blocked_at as Blocked, last_login as 'Last Login', last_ip as 'Last IP'")->where('username', $user_name)->firstOrFail()->toArray();
      $user['Joined'] = Carbon::parse(Carbon::create("{$user['Joined']}")->toDateTimeString())->diffForHumans();
      $user['Last Login'] = Carbon::parse(Carbon::create("{$user['Last Login']}")->toDateTimeString())->diffForHumans();
      $user['Blocked'] = $user['Blocked'] == NULL ? False : Carbon::parse(Carbon::create("{$user['Blocked']}")->toDateTimeString())->diffForHumans();
      $user['Wallet Amount'] = number_format($user['Wallet Amount']);
      $user['Bonus Amount'] = number_format($user['Bonus Amount']);
      return response()->json([
        'message' => 'User Found.',
        'user' => $user
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }


  public function sanction($user_id)
  {
    try {
      $user = User::where('id', $user_id)->firstOrFail();
      $user->sanctioned_at = now()->format('Y-m-d H:i:s.u');
      $user->update();
      $user->notify(new UserSanctioned($user));
      return response()->json([
        'message' => 'User Has been Sanctioned.',
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  public function unblock($user_id)
  {
    try {
      $user = User::where('id', $user_id)->firstOrFail();
      $user->blocked_at = null;
      $user->update();
      return response()->json([
        'message' => 'User Has been unblocked.',
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  public function block($user_id)
  {
    try {
      $user = User::where('id', $user_id)->firstOrFail();
      $user->blocked_at  = now()->format('Y-m-d H:i:s.u');
      $user->update();
      return response()->json([
        'message' => 'User Has been blocked.',
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  public function refered_users($referer_id, $level, $ref_name, $show_investments = null, Request $request)
  {
    try {
      $raw_query = DB::raw(
        "SELECT
         u.id, u.first_name, u.last_name, u.username,i.id AS investment_id, i.total_amount, i.created_at
        FROM users
        AS u
        JOIN investments
        AS i
        ON
          i.id = (
            SELECT i1.id
            FROM investments
            AS i1
            WHERE u.id=i1.user_id
            AND i1.status ='completed'
            AND i1.type = 'normal'
            ORDER BY i1.created_at
            LIMIT 1
          )
        WHERE
          u.referer = :referer_id AND i.deleted_at IS NULL
        ORDER BY created_at DESC"
      );
      $refered_users_data = DB::select($raw_query, ['referer_id' => $referer_id]);
      $refered_users  = $this->ref_user_paginator($refered_users_data, $request);
      // Log::info(var_dump($refered_users));
      if ($level == 1) {
        $bonus_multiplier = 0.05;
        $next_ref_level = 2;
      } elseif ($level == 2) {
        $bonus_multiplier = 0.03;
        $next_ref_level = 0;
      }
      // elseif ($level == 3) {
      //   $bonus_multiplier = 0.01;
      //   $next_ref_level = 4;
      // } else {
      //   $bonus_multiplier = 0.01;
      //   $next_ref_level = 0;
      // }
      $user_data = User::where('id', $referer_id)->firstOrFail();
      if (isset($show_investments) && $show_investments == true) {
        $user_investments = Investment::where('user_id', $referer_id)->paginate(5, ['*'], 'user_investment');
        return view('refered_users', ['refered_users' => $refered_users, 'next_ref_level' => $next_ref_level, 'ref_name' => $ref_name, 'bonus_multiplier' => $bonus_multiplier, 'user_data' => $user_data, 'user_investments' => $user_investments]);
      }
      return view('refered_users', ['refered_users' => $refered_users, 'next_ref_level' => $next_ref_level, 'ref_name' => $ref_name, 'bonus_multiplier' => $bonus_multiplier, 'user_data' => $user_data]);
    } catch (\Exception $e) {
      return back()->with('error', sprintf('could process data: %s', $e->getMessage()));
    }
  }
  /**
   * Show the user refered users and detailed profile if admin.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function ref_user_paginator($array, $request)
  {
    $page = $request->input('page', '1');
    $perPage = 10;
    $offset = ($page * $perPage) - $perPage;

    return new LengthAwarePaginator(
      array_slice($array, $offset, $perPage, true),
      count($array),
      $perPage,
      $page,
      ['path' => $request->url(), 'query' => $request->query()]
    );
  }
  public function notifications()
  {
    $notifications = auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    foreach ($notifications as $key => $notification) {
      $notifications[$key]['created_at'] =  Carbon::parse($notification['created_at'])->diffForHumans();
    }
    return $notifications;
  }
}
