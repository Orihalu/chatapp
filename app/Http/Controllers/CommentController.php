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
      $user = Auth::user();
      $room_model = $id; // ややこしいので
      \Debugbar::info($id->comments);

        $comment_models = $id->comments()->with('user')->get();
        foreach($comment_models as $comment) {
          $comment['my_favorite'] = $user->isFavoritesComment($comment->id);
          $comment['favorite_counter'] = $comment->favoriteCount();
        }
      return response()->json($comment_models);
    }

    public function store(Request $request,Room $id) {
      $user = Auth::user();

      $comment = $id->comments()->create([
        'body' => $request->body,
        'user_id' => Auth::id(),
        'room_id' => $id->id,
      ]);
      //上の$commentとは別
      $comment = Comment::where('id',$comment->id)->with('user')->first();
      $comment['my_favorite'] = $user->isFavoritesComment($comment->id);
      $comment['favorite_counter'] = $comment->favoriteCount();


      return $comment->toJson();

    }

    public function isFavoritesComment(Comment $id) {
      $comment_id = $comment->id;
      $check = Auth::user()->favoriteComments->pluck('id');
      return $check->contains($comment_id);
    }

}
