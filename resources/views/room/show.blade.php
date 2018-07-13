@extends ('layouts.app')
@section('content')
{{--{{dd($room)}}--}}
<div class="container" >
  <h1>{{$room->name}}</h1>
<h1>commentbody</h1>
<h2>
  @foreach ($room->comments as $comment)
      <div class="media-left" style="margin-top:10px">
        <a href="#">
          <img class="media-object" src="http://placeimg.com/80/80" alt="...">
          <p>{{$comment->user->name}}</p>
        </a>
      </div>


  <div class="card" style="margin-top:10px">
  <p>{{ $comment->body }}</p>
  <p><small class="float-right">{{ date("Y年 m月 d日 H時 i分 s秒", strtotime($comment->created_at)) }}</small></p>
  </div>
  @endforeach

</h2>


     <div class="panel-footer" style="margin-top:10px">
        <form method="post" action="{{ action('CommentController@store' , $room)}}">
          {{ csrf_field() }}
          <textarea class="form-control" style="margin-top:10px" rows="3" name="body" placeholder="Leave a comment" ></textarea>
          <button class="btn btn-success" style="margin-top:10px">Comment</button>
        </form>
     </div>
</div>



@endsection
