<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
      'body', 'user_id', 'room_id'
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function room() {
      return $this->belongsTo('App\Room');
    }
    public function favorites() {
      return $this->belongsToMany('App\User','favorites','comment_id','user_id');
    }

    // public function getFavoritesCountsAttribute() {
    //   return $this->favorites()->count();
    // }
}
