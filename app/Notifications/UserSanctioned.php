<?php

namespace App\Notifications;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSanctioned extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user)
  {
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
      'title' => 'You Have been sanction!',
      'icon' => 'mdi-alert',
      'color' => 'red',
      'message' => sprintf(
        'Hello! %s %s you have been sanctioned for defaulting the operating policy of the system, as a result 5 percent will be decucted from your next cashout earning.',
        $this->user->last_name,
        $this->user->first_name,
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
