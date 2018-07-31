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
      // var_dump($id);
      $user = Auth::user();

      // $comments = $id->comments();
      // foreach ($comments as $comment) {
      // //attributeで出来た項目にisfavoritecommetsの結果を入れる
      // $comment = $user->isFavoritesComment($comment->id);
      // }
// exit;
      return response()->json([
        'comment' => $id->comments()->with('user','favorites')->latest()->get(),
      ]);
      // return $id->comments()->with('user','favorites')->latest()->get()->toJson();
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

    public function isFavoritesComment(Comment $id) {
      $comment_id = $comment->id;
      $check = Auth::user()->favoriteComments->pluck('id');
      return $check->contains($comment_id);
    }

}
