@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
      <ul class="nav nav-tabs nav-justified">
        <li class="nav-item" class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);">
          <a href="{{ action('AdminController@showRooms') }}" class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);">
          Rooms
          </a>
        </li>
        <li class="nav-item">
          <a href="{{action('AdminController@showUsers')}}" class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);">
          Users
          </a>
        </li>
      </ul>
  </div>
</div>
@endsection
