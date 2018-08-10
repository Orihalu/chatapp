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

      <tbody v-for="room in rooms">
        <tr>
          <th scope="row">{{room.id}}</th>
          <td>{{room.name}}</td>
          <td>{{room.user_id}}</td>
          <td>{{room.created_at}}</td>
          <button class="btn btn-light"  @click="deleteRoom(room.id)">×</button>
        </tr>
      </tbody>

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
        console.log('success');
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
