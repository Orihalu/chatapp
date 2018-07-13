<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\User;
use DB;

class Room extends Model
{
    protected $fillable = [
      'id','user_id','name'
    ];


    public function users() {
      return $this->belongsToMany('App\User');
    }

    public function comments() {
      return $this->hasMany('App\Comment');
    }


}
