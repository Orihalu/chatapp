@extends('layouts.app')

@section('content')
{{--
@foreach ($collection_array as $room)

{{var_dump($room->room_id)}}


@endforeach
--}}


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/room/create') }}">＋ルーム作成</a>

                </div>
              </div>
              @forelse ($rooms as $room)
                @if($room->users->contains('id',Auth::user()->id))
                <div class="card">
                  <div class="card-body">
                      <a href="{{ action('RoomController@show',$room) }}" >{{$room->name}}</a>
                      <form method="post" action="{{ action('UserController@leave',$room) }}">
                       {{ csrf_field() }}
                       <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                       <div class="form-group">
                           <button type="submit" style="float:right;" class="btn btn-danger btn-lg">leave</button>
                       </div>
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
</div>
@endsection
