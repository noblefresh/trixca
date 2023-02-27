<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
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
    'title',
    'content',
    'user_id',
    'image'
  ];
  protected $dateFormat = 'Y-m-d H:i:s.u';
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
