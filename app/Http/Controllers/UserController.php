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
        // dd($users);


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
      // dd($id);
        $rooms = Room::all();

        $user = Auth::user();
        $room = Room::find($id);
        $room_id = $id;
        // dd($user->rooms);
        // $room->users()->attach($request->user_id);

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
      // dd($id);
      $user = User::findOrFail($id);
      // dd(Auth::user()->id);


      if ($user->id==Auth::user()->id) {
        // dd(Auth::user()->id);

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
    public function update(Request $request, $id)
    {
        //
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
      // dd($user->users);
      $followed_user = User::find($user->id);
      $follow_user = Auth::user();
      if(! $user) {
        return redirect()->back()->with('error','User doesn not exist');
      }
// dd($follow_user->relationships());
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
      // $favorite = Auth::user()->favoriteComments()->create([
      //   'comment_id' => $id->id,
      //   'user_id' => Auth::id()
      // ]);
      //
      //
      // return $favorite->toJson();
      $comment = Comment::find($id);
      $comment_id = $id->id;
      $favorite = Auth::user()->favoriteComments()->attach($comment_id);
      // return redirect()->back()->with('status','success');
      // return $favorite->toJson();

      // $user = Auth::user();
      // $comment = Comment::find($id);
      // $comment_id = $id->id;
      // $user->favoriteComments()->attach($comment_id);
      // return $favorite->toJson();
      // return redirect()->back();
    }
    public function unlike(Comment $id) {
      $user = Auth::user();
      $comment = Comment::find($id);
      $comment_id = $id->id;
      $user->favoriteComments()->detach($comment_id);
      return redirect()->back();
    }

    public function favorite(User $id) {
      return response()->json([
        'comment' => $id->favoriteComments()->with('favorites')->latest()->get(),
    ]);
  }



}
