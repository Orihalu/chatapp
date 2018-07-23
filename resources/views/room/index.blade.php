@extends('layouts.app')

@section('content')



<div class="container">
  <a href="{{ url('/home')}}" class="row justify-content-center">TOPPAGE</a>

  {{-- <div class="row justify-content-center">


        <div class="col-md-8">--}}
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @elseif (session('danger'))
              <div class="alert alert-danger" role="alert">
                  {{ session('danger') }}
              </div>
          @endif

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


          {{--検索--}}
          <form method="post" >
            {{ csrf_field() }}

              <input type="text" name="name" placeholder="Roomname">

            <button class="btn btn-success">検索</button>
          </form>

          {{--検索エンド--}}


            <div class="card">
              @forelse ($rooms as $room)
              <div class="card">
                <div class="card-body">
                    <a href="{{ action('RoomController@show',$room) }}" >{{$room->name}}</a>

{{$room->users}}
{{Auth::user()->id}}
                        @if(empty($room->users->toArray()))
                            <form method="post" action="{{ action('UserController@join',$room) }}">
                              {{ csrf_field() }}
                              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            gggg
                            <div class="form-group">
                                <button type="submit" style="float:right;" class="btn btn-primary btn-lg">sanka</button>
                            </div>
                            </form>
                        @elseif($room->users->contains('id',Auth::user()->id))
                            <form method="post" action="{{ action('UserController@leave',$room) }}">
                             {{ csrf_field() }}
                             <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                             <div class="form-group">
                                 <button type="submit" style="float:right;" class="btn btn-danger btn-lg">leave</button>
                             </div>
                           </form>
                         @else

                             <form method="post" action="{{ action('UserController@join',$room) }}">
                               {{ csrf_field() }}
                             <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                         gggg
                             <div class="form-group">
                                 <button type="submit" style="float:right;" class="btn btn-primary btn-lg">sanka</button>
                             </div>
                             </form>

                             </form>
                         @endif

                  </div>
                </div>
                @empty
                <div class="card">
                  <div class="card-body">
                    <li>Nothing to show</li>
                  </div>
                </div>
                @endforelse
              </div>
          {{--</div>
      </div>--}}
  </div>


@endsection
