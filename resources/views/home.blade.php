@extends('layouts.app')

@section('content')

{{--modal部分--}}
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
                    <button id="show-modal" class="btn btn-light" @click="showModal = true" >＋ルーム作成</button>
                    <modal v-if="showModal" @close="showModal = false" v-bind:auth-user="{{ Auth::user() }}" v-bind:modal-type="'createRoom'" v-cloak >
                      <h4 slot="header">Room Create Form</h4>
                    </modal>

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
    </div>
</div>
@endsection

@section('scripts')
<script>
/*
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
*/
</script>
@endsection
