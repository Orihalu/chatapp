@extends('layouts.app')

@section('content')

<div class="container">
  <a href="{{ url('/home')}}" class="row justify-content-center">TOPPAGE</a>
  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @elseif (session('danger'))
      <div class="alert alert-danger" role="alert">
          {{ session('danger') }}
      </div>
  @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
          <form method="post">
            {{ csrf_field() }}
            <input type="text" name="name"  placeholder="user検索">
            <button class="btn btn-success">検索</button>
          </form>
          @forelse ($users as $user)
          {{$user->comments}}

              @if($user->id == Auth::user()->id)
              @continue

              @elseif(Auth::user()->following->contains($user->id))
              <div class="card">
                <div class="card-body">
                    <a href="{{ action('UserController@show',$user) }}" >{{$user->name}}</a>
                    {{$user->following}}
                    <form method="post" action="{{ action('UserController@unfollow',$user) }}">
                      {{ csrf_field() }}
                      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                      <div class="form-group">
                        <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
                      </div>
                    </form>
                </div>
              </div>

              @elseif($user->following->isEmpty())
              <div class="card">
                <div class="card-body">
                    <a href="{{ action('UserController@show',$user) }}" >{{$user->name}}</a>
                    {{$user->following}}

                    <form method="post" action="{{ action('UserController@follow',$user) }}">
                      {{ csrf_field() }}
                      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                      <div class="form-group">
                        <button type="submit" style="float:right;" class="btn btn-success">follow</button>
                      </div>
                    </form>
                </div>
              </div>

              @else
              <div class="card">
                <div class="card-body">
                    <a href="{{ action('UserController@show',$user) }}" >{{$user->name}}</a>
                    {{$user->following}}

                    <form method="post" action="{{ action('UserController@follow',$user) }}">
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
              <li>Nothing to show</li>
            </div>
          </div>
          @endforelse
        </div>
    </div>
</div>


@endsection
