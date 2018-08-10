@extends('layouts.app')

@section('content')
<div class="container" id="app" v-cloak>
  <button id="show-modal" class="btn btn-success"  @click="showModal = true">＋ルーム作成</button>
  <modal v-if="showModal" @close="showModal = false" v-bind:auth-user="{{ Auth::user() }}" v-bind:modal-type="'createRoom'"　v-bind:rooms="{{ $rooms }}" v-cloak>
    <h4 slot="header">Room Create Form</h4>
  </modal>
<rooms></rooms>

</div>

@endsection

@section('scripts')

@endsection
