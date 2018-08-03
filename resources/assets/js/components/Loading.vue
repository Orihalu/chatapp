<template>
<div v-if="show"><img src="https://www.homepage-tukurikata.com/image/lion.jpg" >&nbsp;<span v-text="text"></span></div>
</template>

<script>
export default {
props: {
    text: {
        default: 'NowLoading...',
        type: String
    },
    show: {
        default: false,
        type: Boolean
    }
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

}
</script>
