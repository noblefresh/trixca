<?php

namespace App\Http\Controllers;

use App\Cashout;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CashoutController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user_cashout =
      Cashout::select('id', 'total_amount', 'recieved_amount', 'recieving_amount', 'status', 'type', 'created_at')
      ->where('user_id', Auth()->user()->id)->whereIn('status', ['open', 'locked', 'closed'])
      ->orderBy('created_at', 'asc')->paginate(10);
    return view('cashout.index', ['cashouts' => $user_cashout]);
  }
  public function admin_index()
  {
    return view('admin.cashout_list');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.gift');
  }

  /**
   * Store a newly created resource in storage.f
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!in_array($request->input('amount'), [25000, 50000, 100000, 200000, 250000, 500000, 1000000])) {
      return back()->withErrors(['amount.invalid', 'Invalid Amount selected']);
    } else {
      request()->validate([
        'amount' => 'required|numeric|between:25000,1000000',
        'username' => 'required|string|exists:users,username'
      ]);
      try {
        $reciever = User::where('username', $request->input('username'))->firstOrFail();
        $gift_cashout = new Cashout();
        $gift_cashout->total_amount = $request->input('amount');
        $gift_cashout->status = 'open';
        $gift_cashout->investment_id = NULL;
        $gift_cashout->type = 'gift';
        $gift_cashout->user_id = $reciever->id;
        $gift_cashout->recieved_amount = 0;
        $gift_cashout->recieving_amount = 0;
        $gift_cashout->save();
        $reciever->wallet_amount += $gift_cashout->total_amount;
        $reciever->update();
        return redirect()->route('admin_dashboard')->with('success', 'Cashout Gifted Succesfully');
      } catch (ModelNotFoundException $m) {
        Log::info(sprintf('Gift Cashout: %s', $m->getMessage()));
        return back()->with('error', 'Could not gift Cashout: Reciever Username is Invalid');
      } catch (\Exception $e) {
        Log::info(sprintf('Gift Cashout: %s', $e->getMessage()));
        return back()->with('error', 'Could not gift Cashout');
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Cashout  $cashout
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      if (Auth::user()->is_admin()) {
        $user_cashout = Cashout::with('user:id,username,country,phone,email,first_name,last_name,created_at')
          ->where('id', $id)
          ->firstOrFail();
        $cashout_transactions = Transaction::selectRaw("id, amount,
        (SELECT username FROM users WHERE id IN (SELECT user_id FROM investments WHERE id = transactions.investment_id) LIMIT 1) as sender,
        (SELECT username FROM users WHERE id IN (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id) LIMIT 1) as reciever,
        status, pop_url, extended_by, created_at, updated_at")->where('cashout_id', $id)->paginate(10);
        foreach ($cashout_transactions as $key => $tranx) {
          // $extensible = ($tranx['extended_by'] ?: 0) + 24;
          $cashout_transactions[$key]->time_diff = Carbon::parse("{$tranx->created_at}")->diffForHumans();
        }
        // $cashout_transactions = Transaction::where('cashout_id', $id)->orderBy('created_at', 'asc')->get();
        // return dd($cashout_transactions);
        return view('cashout.show', ['cashout' => $user_cashout, 'cashout_transactions' => $cashout_transactions]);
      } elseif (!Auth::user()->is_admin()) {
        $user_cashout =
          Cashout::where('id', $id)
          ->firstOrFail();
        $cashout_transactions = Transaction::selectRaw("id, amount,
          (SELECT username FROM users WHERE id IN (SELECT user_id FROM investments WHERE id = transactions.investment_id) LIMIT 1) as sender,
          (SELECT username FROM users WHERE id IN (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id) LIMIT 1) as reciever,
          status, pop_url, extended_by, created_at, updated_at")->where('cashout_id', $id)->paginate(10);
        foreach ($cashout_transactions->data as $key => $tranx) {
          // $extensible = ($tranx['extended_by'] ?: 0) + 24;
          $cashout_transactions->data[$key]->time_diff = Carbon::parse("{$tranx->created_at}")->diffForHumans();
        }
        // $cashout_transactions = Transaction::where('cashout_id', $id)->orderBy('created_at', 'asc')->get();
        // return dd($cashout_transactions);
        return view('cashout.show', ['cashout' => $user_cashout, 'cashout_transactions' => $cashout_transactions]);
      }
    } catch (\Exception $e) {
      return redirect()->back()->with('error', sprintf('Cannot show investment: %s', $e->getMessage()));
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
      $cashouts =
        Cashout::selectRaw('id, total_amount,recieved_amount,recieving_amount, (SELECT username FROM users WHERE cashouts.user_id = users.id LIMIT 1) as reciever,status,type, created_at')
        ->whereRaw("floor(recieved_amount+recieving_amount) < total_amount")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($cashouts['data'] as $key => $cashout) {
        $cashouts['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$cashout['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $cashouts;
    } elseif ($status == 'completed') {
      $cashouts =
        Cashout::selectRaw('id, total_amount,recieved_amount,recieving_amount, (SELECT username FROM users WHERE cashouts.user_id = users.id LIMIT 1) as reciever,status,type, created_at,updated_at')
        ->where("status", "completed")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($cashouts['data'] as $key => $cashout) {
        $cashouts['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$cashout['updated_at']}")->toDateTimeString())->diffForHumans();
      }
      return $cashouts;
    } elseif ($status == 'gifted') {
      $cashouts =
        Cashout::selectRaw('id, total_amount,recieved_amount,recieving_amount, (SELECT username FROM users WHERE cashouts.user_id = users.id LIMIT 1) as reciever,status,type, created_at')
        ->where("type", "gift")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($cashouts['data'] as $key => $cashout) {
        $cashouts['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$cashout['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $cashouts;
    } elseif ($status == 'expired') {
      $cashouts =
        Cashout::selectRaw('id, total_amount,recieved_amount,recieving_amount, (SELECT username FROM users WHERE cashouts.user_id = users.id LIMIT 1) as reciever,status,type, created_at')
        ->where("status", "expired")
        ->orderBy('created_at', 'asc')->paginate(10)->toArray();
      foreach ($cashouts['data'] as $key => $cashout) {
        $cashouts['data'][$key]['time_diff'] = Carbon::parse(Carbon::create("{$cashout['created_at']}")->toDateTimeString())->diffForHumans();
      }
      return $cashouts;
    }
  }

  public function cashout_bonus()
  {
    if (Auth()->user()->bonus_amount >= 100000) {
      return view('cashout.cashout_bonus');
    } else {
      return back()->with('error', sprintf('Your accumulated bonus is not upto 100,000, you have earn more CFA %s more', (100000 - Auth()->user()->bonus_amount)));
    }
  }

  public function process_cashout_bonus(Request $request)
  {
    request()->validate([
      'price' => 'required|numeric|between:100000,10000000',
    ]);
    try {
      if ($request->input('price') > (Auth()->user()->bonus_amount - (Auth()->user()->bonus_amount % 100000))) {
        return redirect()->back()->with('error', 'Cannot cashout bonus: invalid amount');
      } elseif ($request->input('price') % 100000 != 0) {
        return redirect()->back()->with('error', 'Cannot cashout bonus: invalid amount');
      }
      $earner = User::where('id', Auth()->user()->id)->firstOrFail();
      $new_cashout = new Cashout();
      $new_cashout->type = 'bonus';
      $new_cashout->status = 'open';
      $new_cashout->user_id = $earner->id;
      $new_cashout->recieved_amount = 0;
      $new_cashout->recieving_amount = 0;
      $new_cashout->investment_id = NULL;
      $new_cashout->total_amount = $request->input('price');
      $new_cashout->save();
      $earner->bonus_amount -= $request->input('price');
      $earner->wallet_amount += $request->input('price');
      $earner->update();
      return redirect()->route('user_dashboard', ['id' => $new_cashout->id])->with('success', 'Bonus cashout request sent to the server successfully!');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', sprintf('Cannot cashout bonus: %s', $e->getMessage()));
    }
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Cashout  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $cashout = Cashout::where('id', $id)->where('type', 'gift')->firstOrFail();
      $reciever = User::where('id', $cashout->user_id)->firstOrFail();
      $reciever->wallet_amount -= $cashout->total_amount;
      $reciever->update();
      $cashout->delete();
      if ($cashout->trashed()) {
        return response()->json([
          'message' => 'Cashout Deleted',
        ], Response::HTTP_OK);
      }
    } catch (ModelNotFoundException $mnf) {
      return response()->json([
        'message' => "Cashout Not found."
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
