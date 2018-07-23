@extends('layouts.app')

@section('content')
<div class="container">

  <table class="table table-striped" style="background-color:white;">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NAME</th>
      <th scope="col">Email</th>
      <th scope="col">Created_at</th>
      <th scope="col">Follow</th>
      <th scope="col">Follower</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <th scope="row">{{$user->id}}</th>
      <td><a href="{{ action('UserController@show',$user)}}">{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->created_at}}</td>
      <td>{{$user->following->count()}}</td>
      <td>{{$user->followers->count()}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>




@endsection
