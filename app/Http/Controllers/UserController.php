<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Comment;
use App\Relationship;
use Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::latest()->get();

        return view('user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request,Room $id)
    {
        $rooms = Room::all();

        $user = Auth::user();
        $room = Room::find($id);
        $room_id = $id;
        $user->rooms()->attach($room_id);
      return redirect()->back()->with('status','さんかしました');
    }


    public function leave(Room $id) {
      $user = Auth::user();
      $room = Room::find($id);
      $room_id = $id;
      $user->rooms()->detach($room_id);

      return redirect()->back()->with('danger','leave the group');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::findOrFail($id);

      if ($user->id==Auth::user()->id) {

          return view('user.profil')->with('user',$user);
        }
      else{
        return view('user.show')->with('user', $user);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->save;
      return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function search(Request $request) {
      $keyword = $request->name;

      $query = User::query();

      if(!empty($keyword)) {
        $query->where('name','like','%'.$keyword.'%');
      }
      $users = $query->latest()->paginate(10);

      return view('user.index')->with([
        'users' => $users,
        'keyword' => $keyword,
      ]);
    }


    public function follow(User $user) {
      $followed_user = User::find($user->id);
      $follow_user = Auth::user();
      if(! $user) {
        return redirect()->back()->with('error','User doesn not exist');
      }
      $follow_user->following()->attach($followed_user->id);
      return redirect()->back()->with('status','followshitayo');
    }



    public function unfollow (User $user) {
      $followed_user = User::find($user->id);
      $follow_user = Auth::user();
      if(! $user) {
        return redirect()->back()->with('status','unfollow');
      }
      $follow_user->following()->detach($followed_user->id);
      return redirect()->back()->with('danger','unfollllowsitayo');
    }


    public function like(Comment $id) {

      $comment = Comment::find($id);
      $comment_id = $id->id;
      $favorite = Auth::user()->favoriteComments()->attach($comment_id);
    }
    public function unlike(Comment $id) {
      $user = Auth::user();
      $comment = Comment::find($id);
      $comment_id = $id->id;
      $user->favoriteComments()->detach($comment_id);
      return redirect()->back();
    }

    public function favorite(User $id) {
      $user = $id;
      $favorite_comments = $user->favoriteComments;
      foreach($favorite_comments as $favorite_comment) {
        $favorite_comment['my_favorite'] = $user->isFavoritesComment($favorite_comment->id);
      }
      return response()->json($favorite_comments);
  }

    public function getAuthUser() {
      $user = Auth::user();
      return response()->json($user);
    }






}
