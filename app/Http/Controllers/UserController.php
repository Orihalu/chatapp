<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Comment;
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
      return redirect('/home')->with('status','さんかしました');
    }


    public function leave(Room $id) {
      $user = Auth::user();
      $room = Room::find($id);
      $room_id = $id;
      $user->rooms()->detach($room_id);
      return redirect()->back()->with('status','leave the group');
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
      // dd($user);
        return view('user.show')->with('user', $user);
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
}
