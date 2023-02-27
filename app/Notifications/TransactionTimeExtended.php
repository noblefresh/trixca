<?php

namespace App\Notifications;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionTimeExtended extends Notification implements ShouldQueue
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
      'action' => '#',
      'title' => 'More Time Recieved!',
      'icon' => 'mdi-clock',
      'color' => 'orange',
      'message' => sprintf(
        'Hello! %s %s you have been granted %s more hours to make the payment of %s. Please do so ASAP as no more time will be awarded.',
        $this->user->last_name,
        $this->user->first_name,
        $this->transaction->extended_by,
        $this->transaction->amount
      )
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
