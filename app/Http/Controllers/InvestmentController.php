<?php

namespace App\Http\Controllers;

use App\Cashout;
use App\Investment;
use App\Notifications\InvestmentFeeRequired;
use App\Notifications\UpdateProfileData;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user_investment =
      Investment::select('id', 'total_amount', 'sent_amount', 'sending_amount', 'status', 'type', 'created_at')
      ->where('user_id', Auth()->user()->id)
      ->where('type', '!=', 'fee')
      ->orderBy('created_at', 'asc')->paginate(10);
    return view('investment.index', ['investments' => $user_investment]);
  }
  public function admin_index()
  {
    return view('admin.investment_list');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (!isset(Auth::User()->first_name, Auth::User()->last_name, Auth::User()->username, Auth::User()->phone, Auth::User()->email, Auth::User()->momo_name, Auth::User()->momo_number)) {
      Auth::user()->notify(new UpdateProfileData(Auth::user()));
      return redirect()->back()->with('error', 'Missing Profile Data: edit your profile/MoMo details and update the missing records');
    }
    $last_investment = Investment::where('user_id', Auth::user()->id)->where('type', 'normal')->latest()->first();
    return view('investment.create', ['last_investment' => $last_investment]);
  }

  /**
   * Store a newly created resource in storage
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate([
      'amount' => 'required|numeric|in:5000,10000, 20000, 30000, 50000, 100000'
    ]);
    if (!in_array($request->input('amount'), [5000, 10000, 20000, 30000, 50000, 100000])) {
      return back()->withErrors(['amount.invalid', 'Invalid Amount selected']);
    }
    try {
      //create the new investment
      $new_investment = new Investment();
      $new_investment->total_amount = $request->input('amount');
      $new_investment->sent_amount = 0;
      $new_investment->sending_amount = 0;
      $new_investment->status = 'open';
      $new_investment->cashout_id = NULL;
      $new_investment->type = 'normal';
      $new_investment->user_id = Auth()->user()->id;
      $new_investment->save();
      return redirect()->route('user_dashboard')->with('success', 'Investment Created Succesfully.');
    } catch (\Exception $e) {
      return back()->with('error', sprintf('Could not create Investment: %s', $e->getMessage()));
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Investment  $investment
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      if (Auth::user()->role == 'admin') {
        $user_investment = Investment::with('user:id,username,country,phone,email,first_name,last_name,created_at')
          ->where('id', $id)
          ->firstOrFail();
        $investment_transactions = Transaction::selectRaw("id, amount,
        (SELECT username FROM users WHERE id IN (SELECT user_id FROM investments WHERE id = transactions.investment_id) LIMIT 1) as sender,
        (SELECT username FROM users WHERE id IN (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id) LIMIT 1) as reciever,
        status, pop_url, extended_by, created_at, updated_at")->where('investment_id', $id)->paginate(10);
        foreach ($investment_transactions as $key => $tranx) {
          // $extensible = ($tranx['extended_by'] ?: 0) + 24;
          $investment_transactions[$key]->time_diff = Carbon::parse("{$tranx->created_at}")->diffForHumans();
        }
        // $investment_transactions = Transaction::where('investment_id', $id)->orderBy('created_at', 'asc')->get();
        // return dd($investment_transactions);
        return view('investment.show', ['investment' => $user_investment, 'investment_transactions' => $investment_transactions]);
      } elseif (Auth::user()->role == 'user') {
        $user_investment =
          Investment::where('id', $id)
          ->firstOrFail();
        $investment_transactions = Transaction::selectRaw("id, amount,
          (SELECT username FROM users WHERE id IN (SELECT user_id FROM investments WHERE id = transactions.investment_id) LIMIT 1) as sender,
          (SELECT username FROM users WHERE id IN (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id) LIMIT 1) as reciever,
          status, pop_url, extended_by, created_at, updated_at")->where('investment_id', $id)->paginate(10);
        foreach ($investment_transactions->data as $key => $tranx) {
          // $extensible = ($tranx['extended_by'] ?: 0) + 24;
          $investment_transactions->data[$key]->time_diff = Carbon::parse("{$tranx->created_at}")->diffForHumans();
        }
        // $investment_transactions = Transaction::where('investment_id', $id)->orderBy('created_at', 'asc')->get();
        // return dd($investment_transactions);
        return view('investment.show', ['investment' => $user_investment, 'investment_transactions' => $investment_transactions]);
      }
    } catch (\Exception $e) {
      return redirect()->back()->with('error', sprintf('Cannot show investment: %s', $e->getMessage()));
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Investment  $investment
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $investment = Investment::where('id', $id)->firstOrFail();
      $investment->delete();
      if ($investment->trashed()) {
        return response()->json([
          'message' => 'Investment Deleted',
        ], Response::HTTP_OK);
      }
    } catch (ModelNotFoundException $mnf) {
      return response()->json([
        'message' => "Investment Not found."
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function restore($id)
  {
    try {
      $investment = Investment::onlyTrashed()->where('id', $id)->firstOrFail();
      $investment->restore();
      if (!$investment->trashed()) {
        return response()->json([
          'message' => 'Investment Restored',
        ], Response::HTTP_OK);
      }
    } catch (ModelNotFoundException $mnf) {
      return response()->json([
        'message' => "Investment Not found."
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Api Routes Actions
   *
   *
   */
  public function list($status = 'open')
  {
    if ($status == 'open') {
      $investments =
        Investment::selectRaw('id, total_amount, sent_amount, sending_amount, (SELECT username FROM users WHERE investments.user_id = users.id LIMIT 1)as sender, status, type, created_at')
        ->where("status", "open")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($investments['data'] as $key => $investment) {
        $investments['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$investment['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $investments;
    } elseif ($status == 'closed') {
      $investments =
        Investment::selectRaw('id, total_amount, sent_amount, sending_amount, (SELECT username FROM users WHERE investments.user_id = users.id LIMIT 1)as sender, status, type, created_at')
        ->where("status", "closed")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($investments['data'] as $key => $investment) {
        $investments['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$investment['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $investments;
    } elseif ($status == 'expired') {
      $investments =
        Investment::selectRaw('id, total_amount, sent_amount, sending_amount, (SELECT username FROM users WHERE investments.user_id = users.id LIMIT 1)as sender, status, type, created_at')
        ->where("status", "expired")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($investments['data'] as $key => $investment) {
        $investments['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$investment['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $investments;
    }
  }
}
