<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;

class AdminController extends Controller
{
    public function index() {
      return view('admin.index');
    }

    public function showRooms() {
      $rooms = Room::latest()->get();
      // return response()->json($rooms);
      return view('admin.rooms')->with('rooms',$rooms);
    }
    public function showIndexOfRooms() {
      $rooms = Room::latest()->get();
      return response()->json($rooms);
      // return view('admin.rooms')->with('rooms',$rooms);
    }



    public function showUsers() {
      $users = User::latest()->get();
      return view('admin.users')->with('users',$users);
    }

    public function edit(User $user) {
        //後でmiddlewareで認証
        // dd($user);
        return view('admin.edit')->with('user',$user);
    }

    public function update(Request $request,User $user) {
      // dd($request->name);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->save;
      return response()->json($user);
    }
}
