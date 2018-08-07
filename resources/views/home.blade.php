@extends('layouts.app')

@section('content')
{{--
@foreach ($collection_array as $room)

{{var_dump($room->room_id)}}


@endforeach
--}}

{{--modal部分--}}
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
              RoomName
              <input type="text" name="name" placeholder="Enter Name" value="{{old('name')}}" class="form-control" v-model="roomName">
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
</script>



<div class="container" v-cloak>
  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @elseif (session('danger'))
      <div class="alert alert-danger" role="alert">
          {{ session('danger') }}
      </div>
  @endif
    {{--<div class="row justify-content-center">
        <div class="col-md-8">--}}
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                      <a href="{{ url('/rooms') }}"  class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);" >Rooms</a>
                    </li>
                    <li class="nav-item">
                      <a  href="{{ url('/users') }}" class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);">Users</a>
                    </li>
                    @can('system-only')
                    <li class="nav-item">
                      <a href="{{ url('admin/index') }}" class="nav-link btn btn-light" style="background-color: rgba(0, 0, 0, 0.03);">Admin Menu</a>
                    </li>
                    @endcan
                  </ul>
                </div>

                <div class="card-body" style="text-align:center;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button id="show-modal" class="btn btn-light"  @click="showModal = true" >＋ルーム作成</button>
                    <modal v-if="showModal" @close="closeModal">
                      <!--
                        you can use custom content here to overwrite
                        default content
                      -->
                      <h3 slot="header">Room Create Form</h3>
                    </modal>
                  {{--  <a href="{{ url('/room/create') }}">＋ルーム作成</a>--}}

                </div>
              </div>
              @forelse ($rooms as $room)
                @if($room->users->contains('id',Auth::user()->id))
                <div class="card">
                  <div class="card-body">
                      <a href="{{ action('RoomController@show',$room) }}" >{{$room->name}}</a>
                      <form method="post" action="{{ action('UserController@leave',$room) }}">
                       {{ csrf_field() }}
                       <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                       <div class="form-group">
                           <button type="submit" style="float:right;" class="btn btn-danger btn-lg">leave</button>
                       </div>
                     </form>
                  </div>
                </div>
                @endif
              @empty
              <div class="card">
                <div class="card-body">
                  <li>Nothing to show</li>
                </div>
              </div>
              @endforelse
          {{--</div>
        </div>--}}
    </div>
</div>
@endsection

@section('scripts')
<script>

Vue.component('modal', {
  props: ['showModal'],
    data: function() {
      return {
        user: {!! Auth::user()->toJson() !!},
        roomName: '',
      }
    },
  methods: {

    createRoom() {
      axios.post('/api/create/'+this.user.id, {
        api_token: this.user.api_token,
        name: this.roomName,
        user_id: this.user.id
      })
      .then((response) =>{
        this.roomName = response.data;
        alert('Suuuccess');
      })
      .catch(function(error) {
        console.log('wawawa');
      })
    },
  },
  template: '#modal-template'
});

const app = new Vue({
  el: '#app',
  data: {
    user: {!! Auth::check() ? Auth::user()->toJson() : 'null'  !!},
    roomName: '',
    showModal: false,
    follow_btn_processing: false,
  },
  methods: {
    closeModal() {
      this.showModal = false
    },

    createRoom() {
      axios.post('/api/create/'+this.user.id, {
        api_token: this.user.api_token,
        name: this.roomName,
        user_id: this.user.id
      })
      .then((response) =>{
        this.roomName = '';
        alert('success');
        this.closeModal()

      })
      .catch(function(error) {
        console.log('wawawa');
      })
    },
  }
});

</script>

@endsection
