<template>
<div v-if="show"><img :src="img_src">&nbsp;<span v-text="text"></span></div>
</template>

<script>
export default {
    props: ["url"],
    data() {
        return{
          text: 'NowLoading...',
          show: false,
          img_src: "/img/ajax-loader.gif"
        }
      },

        created: function() {
          this.submit();
        },

    methods: {
      submit: function() {
        var self = this;
        this.show = true;
        axios.get('/api/room/4/user/4/comments')
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
      },
    }
</script>
