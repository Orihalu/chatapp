@extends ('layouts.app')
@section('content')
<div class="container" v-cloak >

<v-loading :show="show"></v-loading>

<div class="container">

  <div class="card-header">
    <ul class="nav nav-tabs nav-justified">
      <li class="nav-item">
        <a href="{{ url('/rooms') }}"  class="nav-link">Rooms</a>
      </li>
      <li class="nav-item">
        <a  href="{{ url('/users') }}" class="nav-link">Users</a>
      </li>
    </ul>
  </div>

  <div class="container" style="text-align:center;">
    <h1>{{$room->name}}</h1>
  </div>

<comment-component v-bind:room="{{ $room }}"></comment-component>

</div>

@endsection
