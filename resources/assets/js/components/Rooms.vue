<template v-for="room in rooms">
<tbody>
  <tr>
    <th scope="row">@{{room.id}}</th>
    <td>@{{room.name}}</td>
    <td>@{{room.user_id}}</td>
    <td>@{{room.created_at}}</td>
  </tr>
</tbody>
</template>

<script>
export default {
  props:["Rooms"],
  data: function() {
    return {
      rooms: {},
    }
  },
  created: function() {
    this.rooms = this.Rooms;
  },

}
</script>
