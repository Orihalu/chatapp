<template>
  <div>
    <table class="table table-striped" style="background-color:white;" >
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">NAME</th>
          <th scope="col">Master_ID</th>
          <th scope="col">Created_at</th>

        </tr>
      </thead>

      <tbody v-for="room in rooms">
        <tr>
          <th scope="row">{{room.id}}</th>
          <td>{{room.name}}</td>
          <td>{{room.user_id}}</td>
          <td>{{room.created_at}}</td>
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
    getRooms() {
      axios.get('/api/room/')
      .then((response) => {
        this.rooms = response.data;
        console.log(response.data);
      })
      .catch(function(error) {
        console.log('DAME');
      })
    },
  }

}
</script>
