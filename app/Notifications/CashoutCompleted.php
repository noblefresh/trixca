<?php

namespace App\Notifications;

use App\Cashout;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CashoutCompleted extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $cashout;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, Cashout $cashout)
  {
    $this->cashout = $cashout;
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
   * Get the database representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toDatabase($notifiable)
  {
    return [
      'action' => '#',
      'title' => 'Cashout Completed!',
      'icon' => 'mdi-check-all',
      'color'=> 'green',
      'message' => sprintf('Hurray! %s %s your cashout of %s has been completed, Reinvest to earn more.',
      $this->user->last_name, $this->user->first_name, ($this->cashout->total_amount))
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
    //
    //   ]
  }
}
