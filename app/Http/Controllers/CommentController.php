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
      $room_model = $id; // ややこしいので

      // ユーザがfavariteしてるcomment_idの配列を取得
      // $have_favarite_comment_ids = $room_model->join('comments', 'comments.room_id', 'rooms.id')
      //   ->join('favarites', function ($join) {
      //     $join->on('favorites.comment_id', '=', 'comments.id')
      //         ->where('favarites.user_id', '=', Auth::id());
      //   }->pluck('comments.id');

        // commentを見たときに上の配列にidが含まれているかどうか
        // CommentResource::collection($comment_model, $have_favarite_comment_ids);
        $comment_models = $id->comments()->with('user')->latest()->get();
        // $user = User::find(3);
        // $user = User::find(3);
        // dd($user);
        foreach($comment_models as $comment) {
          $comment['my_favorite'] = $user->isFavoritesComment($comment->id);
          $comment['favorite_counter'] = $comment->favoriteCount();
        }
        // dd($comment_models->find(4));


      return response()->json($comment_models);
        // 'comment' => $id->comments()->with('user','favorites')->latest()->get()
      // ]);
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
