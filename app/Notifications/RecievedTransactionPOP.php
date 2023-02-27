<?php

namespace App\Notifications;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecievedTransactionPOP extends Notification implements ShouldQueue
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
      'title' => 'POP Received!',
      'icon' => 'mdi-check',
      'color'=> 'orange',
      'message' => sprintf('Hello! %s %s your transaction of %s has recieved a Proof Of Payment. Do well to review the Proof.',
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
