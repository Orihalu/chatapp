@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    {{--{{dd($user->name)}}--}}
    <h1>{{ $user->name }}</h1>
  </div>
</div>



@endsection
