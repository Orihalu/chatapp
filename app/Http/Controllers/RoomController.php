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
    // $rooms = Room::paginate(5);
    // dd($rooms->toArray());
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

    public function store(Request $request) {
      $room = new Room();
      // dd($request->id);
      // $room->room_id = $request->id;
      $user = new User();
      $room->user_id = $request->user_id;
      $room->name = $request->name;
      $room->save();

      $room->users()->attach($request->user_id);


      // return redirect('/home');



    }


    public function search(Request $request) {
      // dd($request->name);
      $keyword = $request->name;

      $query = Room::query();
// dd($query->latest());
      if(!empty($keyword)) {
          $query->where('name','like','%'.$keyword.'%');
      }
      // dd($query);
      $rooms = $query->latest()->paginate(10);
      // $rooms = Room::paginate(5);
      // dd(Room::paginate(5));
      return view('room.index')->with('rooms', $rooms)->with('keyword', $keyword);

      // dd($rooms);

    }

    public function getRoom() {
      $rooms = Room::latest()->get();
      // dd($room);
      return response()->json($rooms);
    }

    public function __construct() {
      $this->middleware('auth');
    }
}
