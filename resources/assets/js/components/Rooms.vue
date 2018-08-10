<template>
  <div>
    <table class="table table-striped" style="background-color:white;" >

      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">NAME</th>
          <th scope="col">Master_ID</th>
          <th scope="col">Created_at</th>
          <th></th>
        </tr>
      </thead>
      <!-- <transition-group  class="table table-striped" tag="tbody" name="row"> -->

        <tbody  class="table" is="transition-group">
          <tr　v-for="room in rooms"  :key="room.id" name="row">
            <th scope="row" >{{room.id}}</th>
            <td>{{room.name}}</td>
            <td>{{room.user_id}}</td>
            <td>{{room.created_at}}</td>
            <td><button class="btn btn-light"  @click="deleteRoom(room.id)">×</button></td>
          </tr>
        </tbody>
      <!-- </transition-group> -->

   </table>
  </div>

</template>

<script>

export default {

  data: function() {
    return {
      rooms: {},
    }
  },
  mounted: function() {
    this.getRooms();
  },
  methods: {
    setRooms: function() {
      this.rooms.push(response.data);
      console.log('uu')
    },


    getRooms() {
      axios.get('/api/room/')
      .then((response) => {
        this.rooms = response.data;
        console.log('ok');
      })
      .catch(function(error) {
        console.log('DAME');
      })
    },

    deleteRoom(id) {
      axios.delete('/api/room/'+id+'/delete', {
      })
      .then((response) => {
        alert('complete');
        this.rooms.shift();
      })
      .catch(function(error) {
        console.log(response.data);
      })
    }
  }
}

</script>

<style>

.v-leave-active, .v-move {
  transition: all 1s;
}

.v-leave-active {
  position: absolute;
}
.v-leave-to {
  opacity: 0;
  background: #f9a3b1;
  transform: translateY(-30px);
}

</style>
