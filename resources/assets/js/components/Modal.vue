<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              default header
            </slot>
          </div>

          <div v-if="modalType === 'createRoom'">
            <div class="modal-body">
              <slot name="body">
                RoomName
                <input type="text" name="name" placeholder="Enter Name" class="form-control" v-model="roomName">
              </slot>
            </div>

            <div class="modal-footer">
              <slot name="footer">
                <button class="modal-default-button btn btn-primary" @click="$emit('close')">
                  キャンセル
                </button>
                <button type="submit"  class="modal-default-button btn btn-success" @click="createRoom();$emit('close')">
                  作成
                </button>
              </slot>
            </div>
          </div>

          <div v-if="modalType === 'registerUser'">
            <div class="modal-body">
              <slot name="body">
                UserName
                <input type="text" name="name" placeholder="User Name" class="form-control" v-model="userName"/>
                Email
                <input type="text" name="email" placeholder="Email" class="form-control" v-model="userEmail"/>
                password
                <input type="text" name="pass" placeholder="pass" class="form-control" v-model="userPass"/>
              </slot>
            </div>

            <div class="modal-footer">
              <slot name="footer">
                <button class="modal-default-button btn btn-primary" @click="$emit('close')">
                  キャンセル
                </button>
                <button type="submit" class="modal-default-button btn btn-success" @click="registerUser();$emit('close')">
                  登録
                </button>
              </slot>
            </div>
          </div>


        </div>
      </div>
    </div>
  </transition>
</template>


<script>
export default {
  props: ["authUser","rooms","modalType"],
  data() {
    return {
      user: {},
      roomName: '',
      propsrooms: {},
      userName: '',
      userEmail: '',
      userPass: '',
      }
    },
    created: function() {
      this.propsrooms = this.rooms
    },
    methods: {
      createRoom() {
        axios.post('/api/create/'+this.user.id, {
          api_token: this.user.api_token,
          name: this.roomName,
          user_id: this.authUser.id
        })
        .then((response) => {
          this.roomName = '';
          alert('success');
          this.closeModal()
          this.propsrooms.push(response.data);
          console.log('s');
        })
        .catch(function(error) {
          console.log(error);
        })
      },

      closeModal() {
        this.showModal = false
      },

      registerUser() {
        axios.post('/api/user/register', {
          name: this.userName,
          email: this.userEmail,
          password: this.userPass,
        })
        .then((response) => {
          this.userName = '';
          this.userEmail = '';
          this.userPass = '';
          alert('success');
          console.log('iine');
        })
        .catch(function(error) {
          console.log(error);
        })
      }
    },
  }
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}
 .modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
 .modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
 .modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
 .modal-body {
  margin: 20px 0;
}
 .modal-default-button {
  float: right;
}
 /*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
 .modal-enter {
  opacity: 0;
}
 .modal-leave-active {
  opacity: 0;
}
 .modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
