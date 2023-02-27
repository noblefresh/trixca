<?php

namespace App\Notifications;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MergedToRecieve extends Notification
{

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
      'title' => 'Time To Recieve!',
      'icon' => 'mdi-arrow-down',
      'color'=> 'green',
      'message' => sprintf('Hurry! %s %s you have been merge to receive a payment of %s. you can view the sender details and reach out if need be. Once you recieve the payments please do well to confirm ASAP.',
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
