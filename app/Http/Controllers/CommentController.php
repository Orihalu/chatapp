<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use Auth;
use App\Comment;
use App\Events\NewComment;
use Log;

class CommentController extends Controller
{


    public function index(Room $id) {
      $user = Auth::user();
      $room_model = $id; // ややこしいので
      \Debugbar::info($id->comments);

        $comment_models = $id->comments()->with('user')->get();
        foreach($comment_models as $comment) {
          $comment['my_favorite'] = $user->isFavoritesComment($comment->id);
          // $comment['favorite_counter'] = $comment->favoriteCount();
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
      // event(new NewComment($comment));

      //自コメントが二重に描画されるのを防ぐ
      broadcast(new NewComment($comment))->toOthers();
      Log::debug($comment);

      return $comment->toJson();

    }

    public function isFavoritesComment(Comment $id) {
      $comment_id = $comment->id;
      $check = Auth::user()->favoriteComments->pluck('id');
      return $check->contains($comment_id);
    }

    public function getFavoriteComment() {
      $user = Auth::user();
      $favorite_comments = $user->favoriteComments;

      foreach($favorite_comments as $favorite_comment) {
        $favorite_comment['my_favorite'] = $user->isFavoritesComment($favorite_comment->id);
        $favorite_comment['favorite_counter'] = $favorite_comment->favoriteCount();
        $favorite_comment['comment_user'] = $favorite_comment->User::find($favorite_comment->user_id);
      }

      return response()->json($favorite_comments);
    }

}
