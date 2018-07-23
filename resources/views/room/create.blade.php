@extends('layouts.app')

@section('content')

<div class="container">
  <h1>
    Create New Room
    <a href="{{url('/home')}}">Back</a>
  </h1>

<form method="post" action="{{ url('/room/store') }}">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="room_title">Room Name</label>
      <input type="text" class="form-control" rows="8" name="name"  placeholder="room name">
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
  </div>

  <div class="form-group">
      <button type="submit" class="btn btn-primary btn-lg">送信</button>
  </div>
</form>
</div>
@endsection
