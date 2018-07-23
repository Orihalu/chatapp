<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function index() {
      return view('admin.index');
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
}
