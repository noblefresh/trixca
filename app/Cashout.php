<?php

namespace App;

use App\Transaction;
use App\User;
use App\Investment;
use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashout extends Model
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
    'recieved_amount',
    'recieving_amount',
    'status',
    'user_id',
    'investment_id',
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
  public function investment()
  {
    return $this->belongsTo(Investment::class, 'investment_id');
  }
  public function transactions()
  {
    return $this->hasMany(Transaction::class, 'cashout_id');
  }
}
