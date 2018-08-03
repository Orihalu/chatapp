@extends ('layouts.app')
@section('content')
<v-loading :show="show" v-cloak></v-loading>
<div class="container" v-cloak >
  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @elseif (session('danger'))
      <div class="alert alert-danger" role="alert">
          {{ session('danger') }}
      </div>
  @endif
  <div class="card-header" v-cloak>
    <ul class="nav nav-tabs nav-justified">
      <li class="nav-item">
        <a href="{{ url('/rooms') }}"  class="nav-link">Rooms</a>
      </li>
      <li class="nav-item">
        <a  href="{{ url('/users') }}" class="nav-link">Users</a>
      </li>
    </ul>
  </div>
<div class="container" style="text-align:center;">

  <h1>{{$room->name}}</h1>
</div>
  {{--
  <h1>commentbody</h1>
<h2>
  @foreach ($room->comments->reverse() as $comment)
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
        <button type="submit" style="float:center;" class="btn btn-danger">kaijo</button>
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

</h2>
<div id="app" v-cloak>
    <div class="media" style="margin-top:20px;" v-for="comment in comments">
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="http://placeimg.com/60/60" alt="...">
          <p>@{{comment.user.name}}</p>
        </a>
      </div>
      <div class="card container">
      <div class="media-body">
        <!-- <h4 class="media-heading">@{{comment.user.name}} said...</h4> -->
        <p>
          @{{comment.body}}
        </p>
{{--like button--}}

          <like-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;unlikeComment(comment.id)" v-show="comment.my_favorite" ></like-button>
          <unlike-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;likeComment(comment.id)"　v-show="!comment.my_favorite"></unlike-button>
        <span style="color: #aaa; float:right;">on @{{comment.created_at}}</span>

      </div>
      </div>
    </div>


     <div id="app" class="panel-footer" style="margin-top:10px" v-cloak>
        <form method="post" action="{{ action('CommentController@store' , $room)}}">
          {{ csrf_field() }}

          <textarea class="form-control" style="margin-top:10px" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" ></textarea>
          <button class="btn btn-success" style="margin-top:10px" @click.prevent="postComment" v-if="!show">Comment</button>
        </form>
     </div>
</div>
</div>




@endsection

@section('scripts')

<script>
Vue.component('v-loading', {
        props: {
            text: {
                default: 'Now Loading...',
                type: String
            },
            show: {
                default: false,
                type: Boolean
            }
        },
        template: '<div v-if="show"><img src="https://www.homepage-tukurikata.com/image/lion.jpg" >&nbsp;<span v-text="text"></span></div>'
    });

Vue.component('like-button', {
  data: function() {
    return {
      // comments: {},

      counter: {},
    }
  },
  methods: {
    toggleCounter: function(comment) {
        if(my_favorite=true){
          counter -= 1

        }else {
          counter +=1

        }
    },
  },
  template: '<i class="fa fa-heart"  @click="toggleCounter" style="color:tomato"></i>'
});
Vue.component('unlike-button', {
  data: function() {
    return {
      // comments: {},

    }
  },
  template: '<i class="fa fa-heart" f004></i>'
});

const app = new Vue({
      el: '#app',
      data: {
        comments: {},
        commentBox: '',
        room: {!! $room->toJson() !!},
        user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!},
        favorites: {},
        show: false,
        counter: 0,
      },
      created() {
        this.submit();
      },
      mounted() {
        this.getComments();
        // this.getLikeComments();
      },
      updated() {
      },
      methods: {
        getComments() {
          axios.get('/api/room/'+this.room.id+'/user/'+this.user.id+'/comments')
                .then((response) => {
                  this.comments = response.data.reverse();
                  // this.getLikeComments();
                  console.log(response.data.comment);
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
            this.getComments();
            this.comments.unshift(response.data);
            this.commentBox = '';
          })

          .catch((error) => {
            console.log(error);
          });
        },



        likeComment(id) {
        axios.post('/api/comment/'+id+'/likes', {
          api_token: this.user.api_token
        })
        .then((response) => {
          console.log('dododo');
          // this.getComments();
          // this.getLikeComments();
        })
        .catch(function (error) {
          alert('success');
          console.log(error.message);
        });
        },

        getLikeComments() {
          axios.get('/api/user/'+this.user.id+'/comments')
          .then((response) => {
            this.favorites = response.data.comment;
          })
          .catch(function (error) {
            alert('alert');
            console.log(error.message);
          });
        },
        // toggleLike(id) {
        //   if(comment.my_favorite=true){
        //     this.unlikeComment(id)
        //   }else{
        //     this.likeComment(id)
        //   }
        // },

        unlikeComment(id) {
          axios.post('/api/comment/'+id+'/unlikes',{
            api_token:this.user.api_token
          })
          .then((response) => {

            // this.getComments();
            console.log('bababa');
          })
          .catch(function(error) {
            alert('alert');
            console.log(error.message);
          });
        },

          submit: function() {
            var self = this;
            this.show = true;
            axios.get(this.room.id)
            .then(function(response){
              console.log('d');

            })
            .catch(function(error){
              console.log('dd');
            })
            .then(function() {
              self.show = false;
              console.log('ddd');
            });
          },

          checkLike(id) {
            axios.get('/api/comments/'+id+'/status')
            .then((res) => {
              this.test = response.data;
              console.log('yyy');
            })
            .catch(function(error) {
              console.log(error);
            })
          },



      }
    })
</script>

@endsection
