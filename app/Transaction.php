<?php

namespace App;

use App\Investment;
use App\Cashout;
use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use UuidForKey, SoftDeletes;
    /**
    * Indicates if the IDs are auto-incrementing.
    *
    * @var bool
    */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'status',
        'investment_id',
        'extended_by_',
        'cashout_id',
        'pop'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.u';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     'deleted_at',
  ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
    public function cashout()
    {
        return $this->belongsTo(Cashout::class);
    }
}
