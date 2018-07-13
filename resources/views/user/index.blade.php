@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <form method="post">
            {{ csrf_field() }}
            <input type="text" name="name"  placeholder="user検索">
            <button class="btn btn-success">検索</button>
          </form>

          @forelse ($users as $user)
          <div class="card">
            <div class="card-body">
                <a href="{{ action('UserController@show',$user) }}" >{{$user->name}}</a>

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


@endsection
