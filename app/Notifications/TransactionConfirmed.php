<?php

namespace App\Notifications;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionConfirmed extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $transaction;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, Transaction $transaction)
  {
    $this->transaction = $transaction;
    $this->user = $user;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toDatabase($notifiable)
  {
    return [
      'action' => route('user_dashboard'),
      'title' => 'Transaction Confirmed!',
      'icon' => 'mdi-check',
      'color'=> 'orange',
      'message' => sprintf('Well done! %s %s your transaction of %s has been confirmed.',
      $this->user->last_name, $this->user->first_name, $this->transaction->amount)
    ];
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    // return [
    //   ]
  }
}
