<?php

namespace App\Console\commands;

use Illuminate\Console\Command;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class markTransactionAsFailed extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'transaction:mark_expired';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Set Transactions as expired';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    Log::info('Mark failed transaction job Started');
    $transactions = Transaction::where('status', 'pending')->get();
    foreach ($transactions as $transaction) {
      $last_created_at = $transaction->created_at;
      $extended_time = ($transaction->extended_by !== null ? $transaction->extended_by : 0) + 24;
      $last_created_time_plus_extended = Carbon::parse("{$last_created_at}")->addHours($extended_time);
      if (now()->greaterThanOrEqualTo($last_created_time_plus_extended)) {
        try {
          $failed_transaction = Transaction::where('id', $transaction->id)->firstOrFail();
          $failed_transaction->status = 'failed';
          $failed_transaction->update();
          Log::info(sprintf('Transaction with id: %s  failed!' , $failed_transaction->id));
          Log::info(sprintf('Created at: %s failed at: %s  Marked at: %s' , Carbon::parse($transaction->created_at)->format('Y-md H:i:s'), $last_created_time_plus_extended->format('Y-md H:i:s'), Carbon::now()->format('Y-md H:i:s')));
        } catch (\Exception $e) {
          Log::info(sprintf('Unable to fail transaction with id: %s ' , $failed_transaction->id));
        }
      }
    }
    Log::info('Mark failed transaction job Ended');
  }
}
