<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'description',
    'location',
    'user_id',
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
