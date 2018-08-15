<template>
  <div>
    <div class="card" v-for="comment in comments">
      <div class="card-body">
        <p>{{comment.body}}</p>
        <like-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;unlikeComment(comment.id)" v-show="comment.my_favorite" style="float:right;"></like-button>
        <unlike-button @click.native.prevent="comment.my_favorite=!comment.my_favorite;likeComment(comment.id)"　v-show="!comment.my_favorite" style="float:right;"></unlike-button>
      </div>
    </div>
  </div>
</template>


<script>

export default {
  props:['user'],
  data() {
    return {
      comments: {},
    }
  },
  mounted: function() {
    this.getFavoriteComments()
  },
  methods: {
    getFavoriteComments() {
      axios.get('/api/favorite/comments')
      .then((response) => {
        this.comments = response.data;

        console.log('ok');
        console.log(response.data);
      })
      .catch(function(error) {
        console.log(error);
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

  },
}


</script>
