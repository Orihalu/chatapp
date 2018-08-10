<template>
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
          <like-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;unlikeComment(comment.id)" v-show="comment.my_favorite" ></like-button>
          <unlike-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;likeComment(comment.id)"　v-show="!comment.my_favorite"></unlike-button>
        <span style="color: #aaa; float:right;">on @{{comment.created_at}}</span>

      </div>
      </div>
    </div>

    <div id="scroll">
     <div id="app" class="panel-footer" style="margin-top:10px" v-cloak>
          <textarea class="form-control" style="margin-top:10px" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" ></textarea>
          <button class="btn btn-success" style="margin-top:10px" @click.prevent="postComment" v-if="!btn_processing">Comment</button>
          <button class="btn btn-success" disabled style="margin-top:10px" @click.prevent="postComment" v-else>Loading</button>
     </div>
    </div>
</div>
</template>


<script>

var token = 'csrf_token here'

  export default {
    props: ["Room"],
    data: function(){
    return {
      comments: {},
      commentBox: '',
      room: {},
      user: {},
      btn_processing: false,
      csrf: "",
      show:　false,
    }
    },
    created: function() {
      this.room = this.Room
    },
    mounted: function(){
      this.getUser();
      this.getComments();
    },
    methods: {
    getComments() {
      axios.get('/api/room/'+this.room.id+'/user/'+this.user.id+'/comments')
            .then((response) => {
              this.comments = response.data;
              // this.getLikeComments();
              console.log(error);
            })
            .catch(function (error) {
              console.log(error);
            });
    },
    postComment() {
      axios.post('/api/room/'+this.room.id+'/comment', {
        api_token: this.user.api_token,
        body: this.commentBox,
        btn_processing: this.btn_processing=true,
        csrf_token: token,
      })
      .then((response) => {
        this.btn_processing = false;
        this.comments.push(response.data);
        this.commentBox = '';
        console.log(response.data);
      })

      .catch((error) => {
        this.btn_processing = false;
        console.log(error);
      });
    },

    getUser() {
      axios.get('/api/user')
      .then((response) => {
      this.user = response.data;
      console.log(response.data);
      })
      .catch(function() {
      console.log('fail');
      })
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

    }
  }
</script>
