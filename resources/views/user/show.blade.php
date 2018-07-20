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
      <ul class="nav nav-tabs nav-justified">
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
    </div>


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

            @empty
            Nothing to show...
              </div>
            </div>

            @endforelse
      </div>
      <div id="tab3" class="tab-pane">
            @forelse($user->rooms as $room)
            <div class="card">
              <div class="card-body">
            <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
            {{ csrf_field() }}
              @if(Auth::user()->rooms->contains($room))
              <form method="post" action="{{ action('UserController@leave',$room) }}">
               {{ csrf_field() }}
               <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
               <div class="form-group">
                   <button type="submit" style="float:right;" class="btn btn-danger">leave</button>
               </div>
             </form>
             @break
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
              </div>
            </div>
            @endforelse
      </div>
  　</div>
</div>

@endsection
