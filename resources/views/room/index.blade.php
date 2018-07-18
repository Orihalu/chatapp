@extends('layouts.app')

@section('content')



<div class="container">
  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @endif
    <div class="row justify-content-center">

        <div class="col-md-8">
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
          </div>
      </div>
  </div>


@endsection