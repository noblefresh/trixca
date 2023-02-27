<?php

namespace App\Http\Controllers;

use App\Cashout;
use App\Investment;
use App\Notifications\CashoutCompleted;
use App\Notifications\InvestmentCompleted;
use App\Notifications\MergedToPay;
use App\Notifications\MergedToRecieve;
use App\Notifications\RecievedTransactionPOP;
use App\Notifications\TransactionConfirmed;
use App\Notifications\TransactionTimeExtended;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }
  public function admin_index()
  {
    return view('admin.TransactionList');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate([
      'investment_id' => 'required|uuid|exists:investments,id',
      'cashout_id' => 'required|uuid|exists:cashouts,id',
      'transaction_amount' => 'required|numeric|between:1,1000000'
    ]);
    try {
      $investment = Investment::where('id', $request->input('investment_id'))->firstOrFail();
      $total_inv_amt = $investment->total_amount;
      $sent_inv_amt = $investment->sent_amount;
      $sending_inv_amt = $investment->sending_amount;
      $transactable_inv_amt = $total_inv_amt - ($sent_inv_amt + $sending_inv_amt);
      $trans_amt = $request->input('transaction_amount');
      if ($trans_amt <= $transactable_inv_amt) {
        $cashout = Cashout::where('id', $request->input('cashout_id'))->firstOrFail();
        $total_csh_amt = $cashout->total_amount;
        $recieved_csh_amt = $cashout->sent_amount;
        $recieving_csh_amt = $cashout->sending_amount;
        $transactable_csh_amt = $total_csh_amt - ($recieved_csh_amt + $recieving_csh_amt);
        if ($trans_amt <= $transactable_csh_amt) {
          $new_transaction = new Transaction();
          $new_transaction->amount = $trans_amt;
          $new_transaction->status = 'pending';
          $new_transaction->investment_id = $investment->id;
          $new_transaction->cashout_id = $cashout->id;
          $new_transaction->pop = NULL;
          $new_transaction->extended_by = 0;
          $new_transaction->save();
          $investment->sending_amount += $trans_amt;
          $investment->status = $transactable_inv_amt == $trans_amt ? 'locked' : 'open';
          $investment->save();
          $cashout->recieving_amount += $trans_amt;
          $cashout->status = $transactable_csh_amt == $trans_amt ? 'locked' : 'open';
          $cashout->save();

          try {
            $reciever = User::where('id', $cashout->user_id)->firstOrFail();
          } catch (ModelNotFoundException $e) {
            return response()->json([
              'message' => 'Reciever Does not exist!',
            ], Response::HTTP_NOT_FOUND);
          }
          try {
            $sender = User::where('id', $investment->user_id)->firstOrFail();
          } catch (ModelNotFoundException $e) {
            return response()->json([
              'message' => 'Sender Does not exist!',
            ], Response::HTTP_NOT_FOUND);
          }
          $sender->notify(new MergedToPay($sender, $new_transaction));
          $reciever->notify(new MergedToRecieve($reciever, $new_transaction));
          return response()->json([
            'message' => 'Transaction Created.',
            'transaction' => $new_transaction
          ], Response::HTTP_CREATED);
        } else {
          return response()->json([
            'message' => "Transaction amount: {$trans_amt} is larger the remaining Cashout amount {$transactable_csh_amt}."
          ], Response::HTTP_BAD_REQUEST);
        }
      } else {
        return response()->json([
          'message' => "Transaction amount: {$trans_amt} is larger the available investment amount {$transactable_inv_amt}."
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Resource not found'
      ], Response::HTTP_NOT_FOUND);
    }
  }


  /**
   * Store a newly pop in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function upload_pop(Request $request)
  {
    request()->validate([
      'user_id' => 'required|uuid|exists:users,id',
      'transaction_id' => 'required|uuid|exists:transactions,id',
      'pop' => 'image|mimes:jpg,png,jpeg|max:2048'
    ]);
    try {
      $editable_transaction = Transaction::where('id', $request->input('transaction_id'))->firstOrFail();
      if ($request->hasFile('pop')) {
        $pop = $request->file('pop');
        $destination_path = public_path("image/pop");
        if (!File::isDirectory($destination_path)) {
          File::makeDirectory($destination_path);
        }
        $image_name = $editable_transaction->id . "." . $pop->getClientOriginalExtension();
        $pop->move($destination_path, $image_name);
        $editable_transaction->pop = $image_name;
      }
      $editable_transaction->update();
      try {
        $cashout = Cashout::where('id', $editable_transaction->cashout_id)->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'message' => 'Cashout Does not exist!',
        ], Response::HTTP_NOT_FOUND);
      }
      try {
        $reciever = User::where('id', $cashout->user_id)->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'message' => 'Reciever Does not exist!',
        ], Response::HTTP_NOT_FOUND);
      }
      $reciever->notify(new RecievedTransactionPOP($reciever, $editable_transaction));
      return response()->json([
        'message' => 'POP Uploaded.',
        'pop' => $editable_transaction
      ], Response::HTTP_OK);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'One or more Internal Server Error occurred',
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * load user pending transaction
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function cashout_list($user_id)
  {

    $cashout_transactions = Transaction::whereHas('cashout', function ($q) {
      $q->where('user_id', Auth()->user()->id);
    })->where('status', 'pending')->paginate(5);
    foreach ($cashout_transactions as $key => $tranx) {
      $extensible = ($cashout_transactions[$key]->extended_by ?: 0) + 24;
      $cashout_transactions[$key]->count_down = Carbon::parse("{$tranx->created_at} +{$extensible} hours")->format('Y-m-d\TH:i:sP');
    }
    return response()->json([
      'message' => 'Transaction loaded.',
      'transactions' => $cashout_transactions,
    ], Response::HTTP_OK);
    // return view('home', ['paginated_transactions' => $paginated_transactions]);
    // return dd($paginated_transactions);
  }

  public function investment_list($user_id)
  {

    $investment_transactions = Transaction::whereHas('investment', function ($q) {
      $q->where('user_id', Auth()->user()->id);
    })->where('status', 'pending')->paginate(5);

    foreach ($investment_transactions as $key => $tranx) {
      $extensible = ($investment_transactions[$key]->extended_by ?: 0) + 24;
      $investment_transactions[$key]->count_down = Carbon::parse("{$tranx->created_at} +{$extensible} hours")->format('Y-m-d\TH:i:sP');
    }
    return response()->json([
      'message' => 'Transaction loaded.',
      'transactions' => $investment_transactions,
    ], Response::HTTP_OK);
    // return view('home', ['paginated_transactions' => $paginated_transactions]);
    // return dd($paginated_transactions);
  }

  /**
   * load all transaction
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function admin_list($status = 'pending')
  {
    try {
      if ($status == 'pending') {
        $transactions = Transaction::selectRaw("id, amount,
     (SELECT username FROM users WHERE id IN (SELECT user_id FROM investments WHERE id = transactions.investment_id) LIMIT 1) as sender,
     (SELECT username FROM users WHERE id IN (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id) LIMIT 1) as reciever,
     status, pop, extended_by, created_at, updated_at")->where('status', 'pending')->paginate(10)->toArray();
        foreach ($transactions['data'] as $key => $tranx) {
          // $extensible = ($tranx['extended_by'] ?: 0) + 24;
          $transactions['data'][$key]['time_diff'] = Carbon::parse("{$tranx['created_at']}")->diffForHumans();
        }
        return response()->json([
          'message' => 'Transaction loaded.',
          'transactions' => $transactions
        ], Response::HTTP_OK);
      } elseif ($status == 'confirmed') {
        $transactions = Transaction::selectRaw("id, amount,
        (SELECT username FROM users WHERE id = (SELECT user_id FROM investments WHERE id = transactions.investment_id)) as sender,
        (SELECT username FROM users WHERE id = (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id))
        as reciever,status, pop, extended_by, created_at, updated_at")->where('status', 'confirmed')->paginate(10)->toArray();
        foreach ($transactions["data"] as $key => $tranx) {
          // $extensible = ($tranx["extended_by"] ?: 0) + 24;
          $transactions['data'][$key]["time_diff"] = Carbon::parse("{$tranx['created_at']}")->diffForHumans();
          $transactions['data'][$key]['completed_diff'] = Carbon::parse("{$tranx['updated_at']}")->diffForHumans();
        }
        return response()->json([
          'message' => 'Transaction loaded.',
          'transactions' => $transactions
        ], Response::HTTP_OK);
      } elseif ($status == 'failed') {
        $transactions = Transaction::selectRaw("id, amount,
      (SELECT username FROM users WHERE id = (SELECT user_id FROM investments WHERE id = transactions.investment_id)) as sender,
      (SELECT username FROM users WHERE id = (SELECT user_id FROM cashouts WHERE id = transactions.cashout_id))
      as reciever,status, pop, extended_by, created_at, updated_at")->where('status', 'failed')->paginate(10)->toArray();
        foreach ($transactions["data"] as $key => $tranx) {
          // $extensible = ($tranx["extended_by"] ?: 0) + 24;
          $transactions['data'][$key]["time_diff"] = Carbon::parse("{$tranx['created_at']}")->diffForHumans();
          $transactions['data'][$key]['completed_diff'] = Carbon::parse("{$tranx['updated_at']}")->diffForHumans();
        }
        return response()->json([
          'message' => 'Transaction loaded.',
          'transactions' => $transactions
        ], Response::HTTP_OK);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => sprintf('%s %s', $e->getMessage(), $e->getLine()),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * load transaction sender
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function view_sender($transaction_id)
  {
    try {
      $transaction = Transaction::select('investment_id', 'amount')->where('id', $transaction_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Transaction Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $investment = Investment::select('user_id')->where('id', $transaction->investment_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Investment Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $sender = User::selectRaw("concat_ws(' ',first_name,last_name) as 'Full Name', phone as Phone, ? as 'Amount'", [$transaction->amount])->where('id', $investment->user_id)->firstOrFail();
      return response()->json([
        'message' => 'Sender Found.',
        'sender' => $sender
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Sender Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  /**
   * load transaction reciever
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function view_reciever($transaction_id)
  {
    try {
      $transaction = Transaction::select('cashout_id', 'amount')->where('id', $transaction_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Transaction Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $cashout = Cashout::select('user_id')->where('id', $transaction->cashout_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Cashout Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $reciever = User::selectRaw("concat_ws(' ',first_name,last_name) as 'Full Name', phone as Phone, momo_service_name as 'Bank Name', momo_name as 'Account Name', momo_number as 'Account Number', ? as 'Amount'", [$transaction->amount])->where('id', $cashout->user_id)->firstOrFail();
      return response()->json([
        'message' => 'Reciever Found.',
        'reciever' => $reciever
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Reciever Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  /**
   * confirm transactions.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function confirm($transaction_id)
  {

    try {
      $transaction = Transaction::where('id', $transaction_id)->firstOrFail();
      if ($transaction->status == 'confirmed') {
        return response()->json([
          'message' => 'Transaction has previously been confirmed!',
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Transaction Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $cashout = Cashout::where('id', $transaction->cashout_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Cashout Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $investment = Investment::where('id', $transaction->investment_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Investment Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $reciever = User::where('id', $cashout->user_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Reciever Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $sender = User::where('id', $investment->user_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Sender Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $trans_amt = $transaction->amount;
      $total_inv_amt = $investment->total_amount;
      $sent_inv_amt = $investment->sent_amount;
      $sending_inv_amt = $investment->sending_amount;
      //check if transaction amount is valid for investment model
      if ((($sending_inv_amt - $trans_amt) >= 0) && (($sent_inv_amt + $trans_amt) <= $total_inv_amt)) {
        $total_csh_amt = $cashout->total_amount;
        $recieved_csh_amt = $cashout->recieved_amount;
        $recieving_csh_amt = $cashout->recieving_amount;
        //check if transaction amount is valid for cashout peaked amount
        if ((($recieving_csh_amt - $trans_amt) >=  0) && (($recieved_csh_amt + $trans_amt) <= $total_csh_amt)) {
          //mark transaction as completed
          $transaction->status = 'confirmed';
          $transaction->update();
          //update investment status via  the values provided
          $investment->status = ($sent_inv_amt + $trans_amt) == $total_inv_amt ? 'closed' : 'open';
          $investment->sending_amount -= $trans_amt;
          $investment->sent_amount += $trans_amt;
          $investment->update();
          //update cashout status via  the values provided
          $cashout->status = ($recieved_csh_amt + $trans_amt) == $total_csh_amt ? 'closed' : 'open';
          $cashout->recieved_amount += $trans_amt;
          $cashout->recieving_amount -= $trans_amt;
          $cashout->update();
          // update the reciever wallet to reflect the money recieved
          $reciever->wallet_amount -= $trans_amt;
          $reciever->update();
          $reciever->refresh();
          if ($cashout->recieved_amount == $total_csh_amt) {
            $reciever->notify(new CashoutCompleted($reciever, $cashout));
            $cashout->cashout_at = now()->format('Y-m-d H:i:s.u');
            $cashout->update();
            $cashout->refresh();
            try {
              $completed_investment = Investment::where('id', $cashout->investment_id)->firstOrFail();
              $completed_investment->cashout_at = now()->format('Y-m-d H:i:s.u');
              $completed_investment->update();
            } catch (ModelNotFoundException $e) {
              Log::error(sprintf("Unable mark investment with id: %s as cashed-out by cashout id: %s", $completed_investment->id, $cashout->id));
            }
          }
          //if investment is amount is at peaked amount
          if ($investment->sent_amount  == $total_inv_amt) {
            if ($sender->activated_at == null) {
              //mark investor as activated
              $sender->activated_at = now()->format('Y-m-d H:i:s.u');
              $sender->update();
              // give out the bonus to referer for first time investment
              try {
                /* level 1 ref bonus */
                if (User::where('id', $sender->referer)->exists()) {
                  $lv1_sponsor = User::where('id', $sender->referer)->firstOrFail();
                  $lv1_sponsor->bonus_amount += ($total_inv_amt * 0.05);
                  $lv1_sponsor->update();
                }
              } catch (ModelNotFoundException $e) {
                Log::error(sprintf("Unable to give out Level 1 bonus: couldn't find  a referer user with id: %s", $sender->referer));
              }
              // try {
              //   /* level 2 ref bonus */
              //   if (User::where('id', $lv1_sponsor->referer)->exists()) {
              //     $lv2_sponsor = User::where('id', $lv1_sponsor->referer)->firstOrFail();
              //     $lv2_sponsor->bonus_amount += ($total_inv_amt * 0.03);
              //     $lv2_sponsor->update();
              //   }
              // } catch (ModelNotFoundException $e) {
              //   Log::error(sprintf("Unable to give out Level 2 bonus: couldn't find  a referer user with id: %s", $lv1_sponsor->referer));
              // }
            }
            try {
              // give the corresponding cashout to the amount invested

              $new_ttl_amt = ($total_inv_amt);
              if ($sender->sanctioned_at == null) {
                $cashout_amount = ($new_ttl_amt * 1.3);
              } else {
                $cashout_amount =  ($new_ttl_amt * 1.3) - (($total_inv_amt * 0.3) * 0.05);
              }
              $new_cashout = new Cashout();
              $new_cashout->total_amount = $cashout_amount;
              $new_cashout->recieved_amount = 0;
              $new_cashout->type = $investment->type;
              $new_cashout->recieving_amount = 0;
              $new_cashout->status = 'open';
              $new_cashout->user_id = $sender->id;
              $new_cashout->investment_id = $investment->id;
              $new_cashout->save();

              // updated sender wallet to reflect the corresponding cashout to the amount invested
              $sender->refresh();
              $sender->wallet_amount += $new_cashout->total_amount;
              if ($sender->sanctioned_at != null) {
                $sender->sanctioned_at = null;
              }
              $sender->update();
              //update investment with corresponding cashout id
              $investment->cashout_id = $new_cashout->id;
              $investment->update();
              $investment->refresh();
            } catch (\Exception $e) {
              return response()->json([
                'message' => $e->getMessage()
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            $sender->notify(new InvestmentCompleted($sender, $investment));
          }
          $sender->notify(new TransactionConfirmed($sender, $transaction));
          return response()->json([
            'message' => 'Transaction Confirmed',
            'transaction' => $transaction
          ], Response::HTTP_CREATED);
        } else {
          return response()->json([
            'message' => "Transaction amount: {$trans_amt} is invalid for Cashout."
          ], Response::HTTP_BAD_REQUEST);
        }
      } else {
        return response()->json([
          'message' => "Transaction amount: {$trans_amt} is invalid for Investment."
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function delete($transaction_id)
  {
    try {
      $transaction = Transaction::where('id', $transaction_id)->firstOrFail();
      if ($transaction->status == 'completed') {
        return response()->json([
          'message' => 'Cannot revoke completed Transaction!',
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Transaction Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $cashout = Cashout::where('id', $transaction->cashout_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Cashout Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $investment = Investment::where('id', $transaction->investment_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Investment Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $sender = User::where('id', $investment->user_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Sender Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $trans_amt = $transaction->amount;
      $sent_inv_amt = $investment->sent_amount;
      $sending_inv_amt = $investment->sending_amount;
      //check if transaction amount is valid for investment peaked amount
      if (($sending_inv_amt - $trans_amt) >= 0) {
        $recieved_csh_amt = $cashout->recieved_amount;
        $recieving_csh_amt = $cashout->recieving_amount;
        //check if transaction amount is valid for cashout peaked amount
        if (($recieving_csh_amt - $trans_amt)  >= 0) {
          //update investment status via  the values provided
          $investment->status = 'open';
          $investment->sending_amount -= $trans_amt;
          $investment->update();
          //update cashout status via  the values provided
          $cashout->status = 'open';
          $cashout->recieving_amount -= $trans_amt;
          $cashout->update();
          //mark transaction as failed then delete
          $transaction->status = 'deleted';
          $transaction->update();
          $transaction->delete();
          return response()->json([
            'message' => 'Transaction Deleted',
            'transaction' => $transaction
          ], Response::HTTP_CREATED);
        } else {
          return response()->json([
            'message' => sprintf("Transaction amount: %s is invalid for Cashout", $trans_amt)
          ], Response::HTTP_BAD_REQUEST);
        }
      } else {
        return response()->json([
          'message' => "Transaction amount: {$trans_amt} is invalid for Investment."
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function revoke($transaction_id)
  {
    try {
      $transaction = Transaction::where('id', $transaction_id)->firstOrFail();
      if ($transaction->status == 'completed') {
        return response()->json([
          'message' => 'Cannot revoke completed Transaction!',
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Transaction Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $cashout = Cashout::where('id', $transaction->cashout_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Cashout Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $investment = Investment::where('id', $transaction->investment_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Investment Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $sender = User::where('id', $investment->user_id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'message' => 'Sender Does not exist!',
      ], Response::HTTP_NOT_FOUND);
    }
    try {
      $trans_amt = $transaction->amount;
      $sent_inv_amt = $investment->sent_amount;
      $sending_inv_amt = $investment->sending_amount;
      //check if transaction amount is valid for investment peaked amount
      if (($sending_inv_amt - $trans_amt) >= 0) {
        $recieved_csh_amt = $cashout->recieved_amount;
        $recieving_csh_amt = $cashout->recieving_amount;
        //check if transaction amount is valid for cashout peaked amount
        if (($recieving_csh_amt - $trans_amt)  >= 0) {
          //update investment status via  the values provided
          $investment->status = 'disabled';
          $investment->sending_amount -= $trans_amt;
          $investment->update();
          //update cashout status via  the values provided
          $cashout->status = 'open';
          $cashout->recieving_amount -= $trans_amt;
          $cashout->update();
          //mark transaction as failed then delete
          $transaction->status = 'failed';
          $transaction->update();
          $transaction->delete();
          $sender->blocked_at = now()->format('Y-m-d H:i:s.u');
          $sender->update();
          return response()->json([
            'message' => 'Transaction Revoked',
            'transaction' => $transaction
          ], Response::HTTP_CREATED);
        } else {
          return response()->json([
            'message' => sprintf("Transaction amount: %s is invalid for Cashout", $trans_amt)
          ], Response::HTTP_BAD_REQUEST);
        }
      } else {
        return response()->json([
          'message' => "Transaction amount: {$trans_amt} is invalid for Investment."
        ], Response::HTTP_BAD_REQUEST);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * confirm transactions.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function extend_time($transaction_id, $hours)
  {
    if (!in_array($hours, range(1, 24))) {
      return response()->json([
        'message' => 'Invalid Number of Hours Selected!',
      ], Response::HTTP_BAD_REQUEST);
    }
    $transaction = Transaction::where('id', $transaction_id)->firstOrFail();
    if ($transaction->extended_by == (null||0)) {
      $transaction->extended_by = $hours;
      $transaction->update();
      try {
        $investment = Investment::where('id', $transaction->investment_id)->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'message' => 'Investment Does not exist!',
        ], Response::HTTP_NOT_FOUND);
      }
      try {
        $sender = User::where('id', $investment->user_id)->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'message' => 'Sender Does not exist!',
        ], Response::HTTP_NOT_FOUND);
      }
      $sender->notify(new TransactionTimeExtended($sender, $transaction));
      return response()->json([
        'message' => 'Transaction Time Extended!',
      ], Response::HTTP_OK);
    } else {
      return response()->json([
        'message' => 'Transaction has already been extended!',
      ], Response::HTTP_BAD_REQUEST);
    }
  }



  public function create_transaction()
  {
//     if (Auth()->user()->is_admin() && in_array(Auth()->user()->username, ['joekenpat', 'system_account','system'])) {
      return view('admin.create_transaction');
//     } else {
//       return back()->with('error', 'Not enough Priviledge');
//     }
  }
}
