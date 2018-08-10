<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Comment;
use Auth;
use App\User;
use Log;
use DB;

class RoomController extends Controller
{
    public function index() {
    $rooms = Room::latest()->get();
    return view('room.index')->with('rooms',$rooms);
  }



    public function show(Room $room) {
      // $room = Room::findOrFail($id);
      // dd($room);
      if($room->users->contains('id',Auth::user()->id)) {
        return view('room.show')->withRoom($room);
      }
      else {
        return redirect()->back()->with('status', 'sankasitene');
      }

    }

    public function create() {
      return view('room.create');
    }


    public function destroy(Room $id) {
      $room = Room::find($id->id);
      $room->users()->detach();
      $room->delete();
    }



    public function store(Request $request) {
      $room = new Room();
      $user = new User();
      $room->user_id = $request->user_id;
      $room->name = $request->name;
      $room->save();

      $room->users()->attach($request->user_id);
      return response()->json($room);


    }


    public function search(Request $request) {
      $keyword = $request->name;

      $query = Room::query();
      if(!empty($keyword)) {
          $query->where('name','like','%'.$keyword.'%');
      }
      $rooms = $query->latest()->paginate(10);

      return view('room.index')->with('rooms', $rooms)->with('keyword', $keyword);
    }

    public function getRoom() {
      $rooms = Room::latest()->get();
      return response()->json($rooms);
    }

    public function __construct() {
      $this->middleware('auth');
    }
}
