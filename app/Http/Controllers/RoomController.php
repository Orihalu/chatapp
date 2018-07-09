<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Auth;
use App\User;

class RoomController extends Controller
{
    public function show($id) {
      $room = Room::findOrFail($id);
      return view('room.show')->withRoom($room);
    }

    public function create() {
      return view('room.create');
    }

    public function store(Request $request) {
      $room = new Room();
      // dd($request->user_id);
      // $room->room_id = $request->id;
      $user = new User();
      $room->user_id = $request->user_id;
      $room->name = $request->name;
      $room->save();
      $room->users()->attach($request->users);
      // $user->rooms->add($room);

      return redirect('/home');
    }
}
