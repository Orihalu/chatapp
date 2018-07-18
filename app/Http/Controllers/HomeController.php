<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use Auth;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // dd($room);
      // dd(Auth::user());
      // $rooms = Room::findOrFail(Auth::user()->id)->get();
      $rooms = Room::all();
      // $room = Room::find(1);
      // $user_id = Auth::user()->id;
      // $collection = collect(DB::table('room_user')->where('user_id','=',Auth::user()->id)->get());
      // dd($collection);
      // $collection = collect($user);
      // $sorted = $collection->sortByDesc('room_id');
      // $collection = $collection->each(function($item) {
        // var_dump($item->room_id);
        // $room_id = $item->room_id;
        // $rooms = Room::find($room_id);
        // var_dump($rooms->name);
        // return view('home')->with('rooms',$rooms);



      // $users = User::find();
      // dd($collection);
      // $collection_array = $collection->toArray();
      // dd($collection_array);
      // $rooms = Room::find($)
      // dd($collection_array);

        return view('home')->with('rooms',$rooms);
    }

    // public function getRoom() {
    //   $rooms = DB::table('room_user')->where('user_id','=',Auth::user()->id)->get();
    //   return $rooms;
    // }
}
