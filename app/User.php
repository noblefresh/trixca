<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\UuidForKey;
use App\Investment;
use App\Cashout;
use App\Notifications\NewDownline;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use Notifiable, HasApiTokens, UuidForKey, SoftDeletes, SoftCascadeTrait;
  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;
  protected $softCascade = ['investments@update', 'posts@update', 'cashouts@update'];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'username',
    'phone',
    'country',
    'referer',
    'role',
    'wallet_amount',
    'bonus_amount',
    'momo_service_name',
    'momo_name',
    'momo_number',
    'email',
    'password',
    'alt_password',
    'activated_at',
    'blocked_at',
    'last_ip',
    'last_login'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'deleted_at', 'last_ip', 'alt_password',
  ];
  protected $dateFormat = 'Y-m-d H:i:s.u';
  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'activated_at' => 'datetime',
    'blocked_at' => 'datetime',
  ];

  /**
   * Get the comments for the blog post.
   */
  public function investments()
  {
    return $this->hasMany(Investment::class, 'user_id');
  }
  public function cashouts()
  {
    return $this->hasMany(Cashout::class, 'user_id');
  }
  // public function investment_transactions()
  // {
  //     return $this->investments()->with(Investment::class, 'user_id');
  // }
  // public function cashout_transactions()
  // {
  //     return $this->cashouts()->with(Cashout::class, 'user_id');
  // }
  public function posts()
  {
    return $this->hasMany(Post::class, 'user_id');
  }
  public function is_admin()
  {
    return (Auth::check() && $this->role == 'admin');
  }
  public function is_superadmin()
  {
    return (Auth::check() && $this->role == 'superadmin');
  }
  public function is_guardian()
  {
    return (Auth::check() && $this->role == 'guardian');
  }
  public function is_user()
  {
    return (Auth::check() && $this->role == 'user');
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function (User $model) {
      if (isset($model->referer)) {
        $referer = User::whereId($model->referer)->first();
        $referer->notify(new NewDownline($referer, $model->username));
      }
    });
  }
}
