<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use Auth;
use App\Comment;
class CommentController extends Controller
{


    public function index(Room $id) {
      // dd($id);
      return response()->json($id->comments()->with('user','favorites')->latest()->get());
    }

    public function store(Request $request,Room $id) {

// dd($id->comments);
      // $comment = new Comment();
      // $comment->body = $request->body;
      // $comment->user_id = $request->user()->id;
      // // dd($request->user());
      // $comment->room_id = $id->id;

      $comment = $id->comments()->create([
        'body' => $request->body,
        'user_id' => Auth::id(),
        'room_id' => $id->id
      ]);
      // dd($comment);

      $comment = Comment::where('id',$comment->id)->with('user')->first();
      // dd($comment);

      return $comment->toJson();

    }
    // public function __construct() {
    //   $this->middleware('auth');
    // }


}
