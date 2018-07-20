@extends('layouts.app')

@section('content')

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

<a href="{{ url('/home')}}" class="row justify-content-center">TOPPAGE</a>
<div class="card">
<!-- tab -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a href="#tab"  class="nav-link" data-toggle="tab">follow users![{{$user->following->count()}}]</a>
  </li>
  <li class="nav-item">
    <a  href="#tab2" class="nav-link" data-toggle="tab">followers![{{$user->followers->count()}}]</a>
  </li>
  <li class="nav-item">
    <a href="#tab3" class="nav-link" data-toggle="tab">Joined Rooms[{{$user->rooms->count()}}]</a>
  </li>
</ul>
<!-- endtab -->
</div>
<!-- name body -->
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

<!-- tab contents -->
<div class="tab-content">
  <div id="tab" class="tab-pane active">

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
  <div id="tab2" class="tab-pane">
<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/photo1.jpg" alt="" class="img-fluid">

        @forelse($user->followers as $followers)
        <div class="card">
          <div class="card-body">
        <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
        {{ csrf_field() }}
          @if($followers->id == Auth::user()->id)
          <div style="float:right;">you followed</div>
          @break

          @elseif(Auth::user()->following->contains($followers))
          <form method="post" action="{{ action('UserController@unfollow',$following) }}">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="form-group">
              <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
            </div>
          </form>
          @endif
          </div>
        </div>
        @empty
        Nothing to show...
        @endforelse
  </div>
</div>
</div>

  <div id="tab3" class="tab-pane">
    <div class="card">
      <div class="card-body">
        @forelse($user->rooms as $room)
        <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
          @if(Auth::user()->rooms->contains($room))
          <form method="post" action="{{ action('UserController@leave',$room) }}">
           {{ csrf_field() }}
           <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
           <div class="form-group">
               <button type="submit" style="float:right;" class="btn btn-danger">leave</button>
           </div>
         </form>
         @else
         <form method="post" action="{{ action('UserController@join',$room) }}">
           {{ csrf_field() }}
           <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
           <div class="form-group">
             <button type="submit" style="float:right;" class="btn btn-primary">join</button>
           </div>
         </form>
         @endif
        @empty
        No room user joined...
        @endforelse
    </div>
  </div>
  </div>
</div>








{{--
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
    --}}
</div>

@endsection
