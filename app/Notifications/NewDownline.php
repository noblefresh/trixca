<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDownline extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $downline_username;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, $downline_username)
  {
    $this->user = $user;
    $this->downline_username = $downline_username;
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
      'title' => 'New Downline',
      'icon' => 'mdi-account-supervisor',
      'color' => 'green',
      'message' => sprintf(
        'Hurry! %s %s we noticed, %s just registered using your refereral link or name.',
        $this->user->last_name,
        $this->user->first_name,
        ($this->downline_username)
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
