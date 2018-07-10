<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
      'room_id','id','user_id','name'
    ];


    public function users() {
      return $this->belongsToMany('App\User');
    }
}
