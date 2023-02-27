<?php

namespace App;

use App\Transaction;
use App\User;
use App\Cashout;
use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
  use UuidForKey, SoftDeletes, SoftCascadeTrait;
  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;
  protected $softCascade = ['transactions'];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'type',
    'total_amount',
    'sent_amount',
    'sending_amount',
    'status',
    'user_id',
    'cashout_id',
    'collected_at',
  ];

  protected $hidden = [
    'deleted_at',
  ];
  protected $dateFormat = 'Y-m-d H:i:s.u';
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class, 'investment_id');
  }
  public function cashouts()
  {
    return $this->belongsTo(Cashout::class, 'cashout_id');
  }
}
