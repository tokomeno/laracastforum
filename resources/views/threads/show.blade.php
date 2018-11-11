@extends('layouts.app')

@section('content')
{{$thread->replies->count()}}
<thread-view inline-template :thread="{{$thread}}" data_locked="{{$thread->locked}}" :proprepliescount="{{$thread->replies_count}}">
  <div class="container">
      <div class="row">
          <div class="col-md-8">
              @include('threads._x')

              <replies
              @removed="repliesCount--"
              @added="repliesCount++"
               ></replies>

        </div>
  <div class="col-md-4">
              <div class="card mb-3">
                  <div class="card-header">Some</div>

                  <div class="card-body">
                      <article>
                        <p>
                          Thread was published at {{$thread->created_at->diffForHumans()}} by
                          <a href="#">{{$thread->creator->name}}</a>
                           and currently has <span v-text="repliesCount"></span>
                        </p>
                      </article>


                  </div>
              </div>


            <sub-btn :propactive="{{$thread->isSubscribedTo ? 'true' : 'false'}}"></sub-btn>
             {{-- <sub-btn :propactive="{{$thread->isSubscribedTo}}"></sub-btn> --}}


            <button class="btn" :class="locked == true ? 'btn-danger' : 'btn-info'" v-if="authorize('isAdmin')" @click="lock">Lock</button>


    </div>
  </div>
</thread-view>
@endsection
