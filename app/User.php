<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rooms() {
      return $this->belongsToMany('App\Room')->withPivot('room_id');
    }

    public function comments() {
      return $this->hasMany('App\Comment');
    }

    public function users() {
      return $this->hasManyThrough('App\User','App\Relationship');
    }


    public function following() {
      return $this->belongsToMany('App\User','relationships','follow_id','follower_id')->withPivot('follow_id','follower_id');
    }
    public function followers() {
      return $this->belongsToMany('App\User','relationships','follower_id', 'follow_id');
    }

    public function favoriteComments() {
      return $this->belongsToMany('App\Comment','favorites','user_id','comment_id');
    }
    public function isFavoritesComment($comment_id) {

      $check = $this->favoriteComments->pluck('id');
      return $check->contains($comment_id);
    }


}
