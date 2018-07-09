<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use Auth;


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
      // dd($rooms);


        return view('home')->with('rooms',$rooms);
    }
}
