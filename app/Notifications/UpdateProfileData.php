<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class UpdateProfileData extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  protected $user;
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
      'action' => route('edit_profile'),
      'title' => 'Edit Profile Data',
      'icon' => 'mdi-account',
      'color'=>'yellow',
      'message' => sprintf('Hi! %s, you cannot create an investment without a complete profile data click on me to edit profile', $this->user->username,)
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
    // ];
  }
}
