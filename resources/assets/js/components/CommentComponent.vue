<template>
<div id="app" v-cloak>
  <button class="btn brn-light" style="margin-bottom:10px;" @click.prevent="scrollDown()">DOWN</button>
<transition-group>
    <div class="media" style="margin-top:20px;" v-for="(comment, index) in comments" :key="index">
      <div class="media-left">
        <a v-bind:href="'/users/'+comment.user_id" >
          <img class="media-object" src="http://placeimg.com/60/60" alt="...">
          <p>{{comment.user.name}}</p>
        </a>
      </div>
      <div class="card container">
        <div class="media-body">
          <p>
            {{comment.body}}
          </p>
            <like-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;unlikeComment(comment.id)" v-show="comment.my_favorite" ></like-button>
            <unlike-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;likeComment(comment.id)"　v-show="!comment.my_favorite"></unlike-button>
          <span style="color: #aaa; float:right;">on {{comment.created_at}}</span>

        </div>
      </div>
    </div>
</transition-group>

    <div id="element">
     <div id="app" class="panel-footer" style="margin-top:10px" v-cloak>
          <textarea class="form-control" style="margin-top:10px" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" ></textarea>
          <button class="btn btn-success" style="margin-top:10px" @click="postComment" v-if="!btn_processing">Comment</button>
          <button class="btn btn-success" disabled style="margin-top:10px" @click.prevent="postComment" v-else>Loading</button>
          <button class="btn brn-dark" style="margin-top:10px; float:right;" @click.prevent="scrollTop()">TOP</button>
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
      this.room = this.Room;
      this.getUser();
    },
    mounted: function(){
      this.getComments();
      this.listen();
    },
    updated: function() {
      this.scrollDown();
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
      })
      .catch(function(error) {
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

    scrollDown() {
      window.scrollTo(0,document.body.scrollHeight);
    },
    scrollTop() {
      window.scrollTo(0,0);
    },

    listen() {
      Echo.channel('room.'+this.room.id)
        .listen('NewComment', (comment) => {
          this.comments.push(comment);
          console.log(comment);
        })
      },
    }
  }

</script>

<style>
.v-enter-active, .v-leave-active, .v-move {
  transition: opacity 1s, transform 1s;
}
.v-leave-active {
  position: absolute;
}
.v-enter {
  opacity: 0;
  transform: translateY(20px);
}
.v-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>
