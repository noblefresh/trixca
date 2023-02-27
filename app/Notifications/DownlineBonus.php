<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DownlineBonus extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $downline_username;
  protected $bonus_amount;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, $downline_username, $bonus_amount)
  {
    $this->user = $user;
    $this->downline_username = $downline_username;
    $this->bonus_amount = $bonus_amount;
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
      'action' => route('refered_users',['referer_id'=> $this->user->id,'level'=>1,'ref_name'=>'Your']),
      'title' => 'Bonus recieved!',
      'icon' => 'mdi-gift',
      'color'=> 'purple',
      'message' => sprintf('Hi! %s %s you just earned: %s bonus from your downline: %s. Keep refering to earn more.',
      $this->user->last_name, $this->user->first_name, $this->bonus_amount, $this->downline_username)
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
