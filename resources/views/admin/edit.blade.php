@extends('layouts.app')


@section('content')

<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="form-group">
    <form method="post" action="{{ action('AdminController@update',$user) }}">
      {{ csrf_field() }}
      {{ method_field('patch') }}
    <p>
      <input class="form-control" type="text" name="name" placeholder="enter name" value="{{old('name', $user->name)}}">
      @if ($errors->has('name'))
      <span class="error">{{ $errors->first('name')}}</span>
      @endif
    </p>
    <p>
      <textarea class="form-control" name="email" placeholder="enter email" >{{old('email', $user->email )}}</textarea>
      @if ($errors->has('email'))
      <span class="error">{{ $errors->first('body')}}</span>
      @endif
    </p>
      <input type="submit" class="btn btn-primary" value="編集">
    </form>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/x-template" id="modal-template">
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
              default body
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              default footer
              <button class="modal-default-button" @click="$emit('close')">
                OK
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>

<div id="app">
  <button id="show-modal" @click="showModal = true">Show Modal</button>
  <!-- use the modal component, pass in the prop -->
  <modal v-if="showModal" @close="showModal = false">
    <!--
      you can use custom content here to overwrite
      default content
    -->
    <h3 slot="header">custom header</h3>
  </modal>
</div>

@endsection
@section('scripts')
<script>
Vue.component('modal', {
  template:'#modal-template'
})

const vm = new Vue({
  el: '#app',
  data: {
    showModal: false,
  },
});
</script>

@endsection
