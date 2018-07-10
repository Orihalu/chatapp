<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Auth;
use App\User;
use Log;


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
      // $room->users()->attach($request->users);
      // $user->rooms->add($room);
      // Log::debug($room->users()->attach($request->users));
      // dd($room->where('user_id', 2)->get('name'));
      // $users = $room->users();
      // dd($user->rooms);
      $room->users()->attach($request->user_id);
      // $user->rooms()->attach($request->room_id);
      // $room->save();
      // dd(Auth::user()->rooms->where('id',55));
      //
      // $aaa = Auth::user()->rooms->find(55)->name;
      // dd($aaa);


      //
      // foreach ($aaa as $a) {
      //   dd($a->name);
      // }
      // $user_id = Auth::user()->id;
      // $room_names = Room::where('user_id', $user_id)->get('name');
      // dd($room_names);
      // dd($user->room_id);


      return redirect('/home');
    }
}
