@extends('layouts.app')

@section('content')
<a href="{{ url('/home')}}" class="row justify-content-center">TOPPAGE</a>
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @elseif (session('danger'))
        <div class="alert alert-danger" role="alert">
            {{ session('danger') }}
        </div>
    @endif
    <div class="card">
      <div class="card-body">
        {{$user->following}}
        <h1>{{ $user->name }}</h1>
        @if(Auth::user()->following->contains($user->id))
        <form method="post" action="{{ action('UserController@unfollow',$user) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
          </div>
        </form>
        @else(Auth::user()->following->contains($user->id))
        <form method="post" action="{{ action('UserController@follow',$user) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-success">follow</button>
          </div>
        </form>
        @endif
      </div>
    </div>
    @forelse($user->following as $following)
    @if($following->id == Auth::user()->id)
    @continue
    @elseif(Auth::user()->following->contains($following->id))
        <div class="card">
          <div class="card-body">
        <a href="{{ action('UserController@show', $following) }}">{{$following->name}}</a>
        <form method="post" action="{{ action('UserController@unfollow',$following) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
          </div>
        </form>
          </div>
        </div>
    @else
        <div class="card">
          <div class="card-body">
            <a href="{{ action('UserController@show', $following) }}">{{$following->name}}</a>
            <form method="post" action="{{ action('UserController@follow',$following) }}">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="form-group">
              <button type="submit" style="float:right;" class="btn btn-success">follow</button>
            </div>
            </form>
          </div>
        </div>
    @endif
    @empty
      <div class="card">
        <div class="card-body">
      <li>daremoinai</li>
        </div>
      </div>
    @endforelse
</div>

@endsection
