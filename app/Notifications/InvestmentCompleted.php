<?php

namespace App\Notifications;

use App\Investment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentCompleted extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $investment;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, Investment $investment)
  {
    $this->investment = $investment;
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
      'action' => route('show_investment', ['id' => $this->investment->id]),
      'title' => 'Investment Completed!',
      'icon' => 'mdi-check-all',
      'color'=> 'green',
      'message' => sprintf('Hurray! %s %s your investment of %s has been completed. Your time has started counting.',
      $this->user->last_name, $this->user->first_name, ($this->investment->total_amount))
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
