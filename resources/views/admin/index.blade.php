@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
      <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a href="{{ action('AdminController@showRooms') }}">
          Rooms
          </a>
        </li>
        <li class="nav-item">
          <a href="{{action('AdminController@showUsers')}}">
          Users
          </a>
        </li>
      </ul>
  </div>
</div>
@endsection
