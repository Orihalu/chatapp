
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// Vue.config.devtools = true;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('v-loading', require('./components/Loading.vue'));
Vue.component('like-button', require('./components/LikeButton.vue'));
Vue.component('modal', require('./components/RoomCreateModal.vue'));
Vue.component('comment-component', require('./components/CommentComponent.vue'));
Vue.component('unlike-button', require('./components/UnlikeButton.vue'));
Vue.component('modal',require('./components/Modal.vue'));
Vue.component('rooms',require('./components/Rooms.vue'));
Vue.component('test-modal',require('./components/testModal.vue'));


const app = new Vue({
      el: '#app',
      // created() {
      //   this.submit();
      // },
      data: {
        show: false,
        showModal: false,
      },

    });
