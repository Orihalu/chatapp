<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use Auth;
use App\Comment;
class CommentController extends Controller
{
    public function store(Request $request,Room $id) {


      $comment = new Comment();
      $comment->body = $request->body;
      $comment->user_id = $request->user()->id;
      // dd($request->user());
      $comment->room_id = $id->id;
      // dd($comment);
      $comment->save();
      return redirect()->action('RoomController@show',$id);
      // dd($id);
      // $room = new Room($id);
      // dd($room);
      // $comment = $room->comments()->create([
      //   'body' => $request->body,
      //   'user_id' => Auth::id(),
      //   'room_id' => $id->id
      // ]);

      // dd($comment);
    }
    public function __construct() {
      $this->middleware('auth');
    }
}
