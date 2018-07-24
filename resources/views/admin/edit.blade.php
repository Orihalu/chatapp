@extends('layouts.app')


@section('content')

<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="form-group">
    <form method="post" action="{{ action('AdminController@update',$user) }}">
      {{ csrf_field() }}
      {{ method_field('patch') }}
    <p>
      <input class="form-control" type="text" name="name" placeholder="enter name" value="{{old('name', $user->name)}}">
      @if ($errors->has('name'))
      <span class="error">{{ $errors->first('name')}}</span>
      @endif
    </p>
    <p>
      <textarea class="form-control" name="email" placeholder="enter email" >{{old('email', $user->email )}}</textarea>
      @if ($errors->has('email'))
      <span class="error">{{ $errors->first('body')}}</span>
      @endif
    </p>
      <input type="submit" class="btn btn-primary" value="編集">
    </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
