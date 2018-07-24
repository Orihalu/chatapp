@extends('layouts.app')

@section('content')

<div class="container">
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @elseif (session('danger'))
          <div class="alert alert-danger" role="alert">
              {{ session('danger') }}
          </div>
      @endif

    <a href="{{ url('/home')}}" class="row justify-content-center">TOPPAGE</a>

    <div class="card">
      <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a href="#tab"  class="nav-link" data-toggle="tab">follow users![{{$user->following->count()}}]</a>
        </li>
        <li class="nav-item">
          <a  href="#tab2" class="nav-link" data-toggle="tab">followers![{{$user->followers->count()}}]</a>
        </li>
        <li class="nav-item">
          <a href="#tab3" class="nav-link" data-toggle="tab">Joined Rooms[{{$user->rooms->count()}}]</a>
        </li>
      </ul>
    </div>


    <div class="card" style="margin-bottom:20px;">
      <div class="card-body">
        {{$user->following}}
        <h1>{{ $user->name }}</h1>
        @if(Auth::user()->following->contains($user->id))
        <form method="post" action="{{ action('UserController@unfollow',$user) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
          </div>
        </form>
        @else(Auth::user()->following->contains($user->id))
        <form method="post" action="{{ action('UserController@follow',$user) }}">
          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="form-group">
            <button type="submit" style="float:right;" class="btn btn-primary">follow</button>
          </div>
        </form>
        @endif


        @can('system-only')
        <div id="app">
          <button id="show-modal" @click="showModal = true" class="btn btn-primary">Edit</button>
          <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">User Edit</h3>
          </modal>
        </div>
        {{--<a href="{{ action('AdminController@edit',$user) }}"  style="float:right; margin-right:10px;" class="btn btn-success">[Edit]</a>--}}
        @endcan


      </div>
    </div>


    <div class="tab-content">
      <div id="tab" class="tab-pane active">

            @forelse($user->following as $following)
              @if($following->id == Auth::user()->id)
              <div class="card">
                <div class="card-body">
              <a href="{{ action('UserController@show', $following)}}">{{$following->name}}</a>
              {{ csrf_field() }}
                  <div style="float:right;">you are followed</div>
                </div>
              </div>
              @continue
              @elseif(Auth::user()->following->contains($following->id))
                  <div class="card">
                    <div class="card-body">
                  <a href="{{ action('UserController@show', $following) }}">{{$following->name}}</a>
                  <form method="post" action="{{ action('UserController@unfollow',$following) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                      <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
                    </div>
                  </form>
                    </div>
                  </div>
              @else
                  <div class="card">
                    <div class="card-body">
                      <a href="{{ action('UserController@show', $following) }}">{{$following->name}}</a>
                      <form method="post" action="{{ action('UserController@follow',$following) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                      <div class="form-group">
                        <button type="submit" style="float:right;" class="btn btn-primary">follow</button>
                      </div>
                      </form>
                    </div>
                  </div>
              @endif
            @empty
              <div class="card">
                <div class="card-body">
                 <li>daremoinai</li>
                </div>
              </div>
            @endforelse
      </div>

    　<div id="tab2" class="tab-pane">
            @forelse($user->followers as $followers)
{{--dd($followers)--}}
              @if($followers->id == Auth::user()->id)
              <div class="card">
                <div class="card-body">
              <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
              {{ csrf_field() }}
                  <div style="float:right;">you've followed</div>
                </div>
              </div>

              @continue

              @elseif(Auth::user()->following->contains($followers))
              <div class="card">
                <div class="card-body">
              <a href="{{ action('UserController@show', $followers)}}">{{$followers->name}}</a>
              {{ csrf_field() }}
              <form method="post" action="{{ action('UserController@unfollow',$following) }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-group">
                  <button type="submit" style="float:right;" class="btn btn-danger">unfollow</button>
                </div>
              </form>
            </div>
            </div>
            @else
            <div class="card">
              <div class="card-body">
                <a href="{{ action('UserController@show', $following) }}">{{$followers->name}}</a>
                {{ csrf_field() }}
                <form method="post" action="{{ action('UserController@follow', $following) }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                  <div class="form-group">
                    <button type="submit" style="float:right;" class="btn btn-primary">follow</button>
                  </div>
              </div>
            </div>

              @endif

            @empty
            Nothing to show...
            @endforelse
          </div>

      <div id="tab3" class="tab-pane">
            @forelse($user->rooms as $room)
               @if(Auth::user()->rooms->contains($room))
               <div class="card">
                 <div class="card-body">
               <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
               {{ csrf_field() }}
                <form method="post" action="{{ action('UserController@leave',$room) }}">
                 {{ csrf_field() }}
                 <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                 <div class="form-group">
                     <button type="submit" style="float:right;" class="btn btn-danger">leave</button>
                 </div>
                </form>
              </div>
            </div>
               @continue
               @else
               <div class="card">
                 <div class="card-body">
               <a href="{{ action('RoomController@show', $room) }}">{{$room->name}}</a>
               {{ csrf_field() }}
                 <form method="post" action="{{ action('UserController@join',$room) }}">
                   {{ csrf_field() }}
                   <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                   <div class="form-group">
                     <button type="submit" style="float:right;" class="btn btn-primary">join</button>
                   </div>
                 </form>
               </div>
             </div>

               @endif

             @empty
              No room user joined...

             @endforelse
      </div>
  　</div>
</div>

@endsection

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
              UserName
              <input type="text" name="name" placeholder="Enter Name" value="{{old('name', $user->name)}}" class="form-control">
            </slot>
            <slot name="body">
              Email
              <input type="text" name="email" placeholder="Enter Email" value="{{old('email', $user->email)}}" class="form-control">
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button btn btn-primary" @click="$emit('close')">
                キャンセル
              </button>
              <button type="submit" class="modal-default-button btn btn-success" action="{{ action('AdminController@update',$user) }}">
                編集
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>


@section('scripts')
<script>
Vue.component('modal', {
  template:'#modal-template'
});

const vm = new Vue({
  el: '#app',
  data: {
    showModal: false,
  },
});
</script>

@endsection
