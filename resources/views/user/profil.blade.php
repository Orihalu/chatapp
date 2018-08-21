@extends('layouts.app')

@section('content')

{{--dd($user->favorites)--}}
<v-loading v-show="show"></v-loading>

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
          <a href="#tab"  class="nav-link" data-toggle="tab">Follow users![{{$user->following->count()}}]</a>
        </li>
        <li class="nav-item">
          <a  href="#tab2" class="nav-link" data-toggle="tab">Followers![{{$user->followers->count()}}]</a>
        </li>
        <li class="nav-item">
          <a href="#tab3" class="nav-link" data-toggle="tab">Joined Rooms[{{$user->rooms->count()}}]</a>
        </li>
        <li class="nav-item">
          <a href="#tab4" class="nav-link" data-toggle="tab">Favorite comments[{{$user->favoriteComments->count()}}]</a>
        </li>
      </ul>
    </div>


    <div class="card" style="margin-bottom:20px;">
      <div class="card-body">
        <h1>Name<br/>{{ $user->name }}</h1>
        @if(Auth::user()->following->contains($user->id))
        <form method="post" action="{{ action('UserController@unfollow',$user) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
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

              @if($followers->id == Auth::user()->id)
              <div class="card">
                <div class="card-body">
              <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
              {{ csrf_field() }}
              <div style="float:right;">you followed</div>
                </div>
              </div>

              @continue

              @elseif(Auth::user()->following->contains($followers))
              <div class="card">
                <div class="card-body">
                  <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
                  {{ csrf_field() }}
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
                  <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
                  {{ csrf_field() }}
                  <form method="post" action="{{ action('UserController@follow',$following) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                      <button type="submit" style="float:right;" class="btn btn-primary">follow</button>
                    </div>
                  </form>
                </div>
              </div>
              @endif

            @empty
            <div class="card">
              <div class="card-body">
                  Nothing to show...
              </div>
            </div>
            @endforelse
          </div>

      <div id="tab3" class="tab-pane">
            @forelse($user->rooms as $room)
               @if(Auth::user()->rooms->contains($room))
               <div class="card">
                 <div class="card-body">
               <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
               {{ csrf_field() }}
                <form method="post" action="{{ action('UserController@leave',$room) }}">
                 {{ csrf_field() }}
                 <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                 <div class="form-group">
                     <button type="submit" style="float:right;" class="btn btn-danger">leave</button>
                 </div>
                </form>
              </div>
            </div>
               @continue
               @else
               <div class="card">
                 <div class="card-body">
               <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
               {{ csrf_field() }}
                 <form method="post" action="{{ action('UserController@join',$room) }}">
                   {{ csrf_field() }}
                   <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                   <div class="form-group">
                     <button type="submit" style="float:right;" class="btn btn-primary">join</button>
                   </div>
                 </form>
               </div>
             </div>

               @endif

             @empty
              No room user joined...

             @endforelse
      </div>

      <div id="tab4" class="tab-pane">
          <favorite-comments v-bind:user="{{Auth::user()}}"></favorite-comments>
      </div>


  　</div>
</div>


@endsection
