@extends ('layouts.app')
@section('content')
{{--{{dd($room)}}--}}
<div class="container" >
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

  <h1>{{$room->name}}</h1>
  <?php $aa = $room->users->toArray();
  $bb = $room->toArray();

   ?>
  {{--dd(in_array($aa, $bb))--}}

{{--dd($room->users)--}}
{{--
<h1>commentbody</h1>
<h2>
  @foreach ($room->comments as $comment)
      <div class="media-left" style="margin-top:10px">
        <a href="{{ action('UserController@show',$comment->user)}}">
          <img class="media-object" src="http://placeimg.com/80/80" alt="...">
          <p>{{$comment->user->name}}</p>
        </a>


  <div class="card" style="margin-top:10px;">
  <p>{{ $comment->body }}</p>
  {{$comment->favorites}}
  @if($comment->favorites->contains('id',Auth::user()->id))
  　<form method="post" action="{{ action('UserController@unlike',$comment) }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <div class="form-group">
        <button type="submit" style="float:center;" class="btn btn-danger">UNLIKE</button>
    </div>
    </form>

  @else
  <form method="post" action="{{ action('UserController@like',$comment) }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <div class="form-group">
        <button type="submit" style="float:center;" class="btn btn-success">LIKE</button>
    </div>
    </form>
    @endif
  <p><small class="float-right">{{ date("Y年 m月 d日 H時 i分 s秒", strtotime($comment->created_at)) }}</small></p>
  </div>
  </div>

  @endforeach
--}}


    <div class="media" style="margin-top:20px;" v-for="comment in comments">
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="http://placeimg.com/80/80" alt="...">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">@{{comment.user.name}} said...</h4>
        <p>
          @{{comment.body}}
        </p>
        <span style="color: #aaa;">on @{{comment.created_at}}</span>
      </div>
    </div>


</h2>



     <div class="panel-footer" style="margin-top:10px">
        <form method="post" action="{{ action('CommentController@store' , $room)}}">
          {{ csrf_field() }}

          <textarea class="form-control" style="margin-top:10px" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" ></textarea>
          <button class="btn btn-success" style="margin-top:10px">Comment</button>
        </form>
     </div>
</div>



@endsection

@section('scripts')
<script>

const app = new Vue({
      el: '#app',
      data: {
        comments: {},
        commentBox: '',
        room: {!! $room->toJson() !!},
        user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!}
      },
      mounted() {
        this.getComments();
      },
      methods: {
        getComments() {
          axios.get('/api/room/'+this.room.id+'/comments', {
            api_token: this.user.api_token
          })
                .then((response) => {
                  this.comments = response.data
                })
                .catch(function (error) {
                  console.log(error);
                });
        },
        postComment() {
          axios.post('/api/room/'+this.room.id+'/comment', {
            api_token: this.user.api_token,
            body: this.commentBox
          })
          .then((response) => {
            this.comments.unshift(response.data);
            this.commentBox = '';
          })
          .catch((error) => {
            console.log(error);
          });
        },
      }
    })
</script>
@endsection
