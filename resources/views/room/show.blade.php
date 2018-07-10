@extends ('layouts.app')
@section('content')
{{--{{dd($room)}}--}}
<div class="container">
  <h1>{{$room->name}}</h1>

<h1>commentbody</h1>

<footer class="fixed-bottom">

    <div style="margin:50px;">
      <h3>comment</h3>
      <textarea class="form-control" rows="3" name="body" placeholder="Leave a comment" ></textarea>
      <button class="btn btn-success" style="margin-top:10px">Save Comment</button>
    </div>
</footer>
</div>

@endsection
