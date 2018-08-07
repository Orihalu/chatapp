


<template type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              default header
            </slot>
          </div>

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
      </div>
    </div>
  </transition>
</template>
