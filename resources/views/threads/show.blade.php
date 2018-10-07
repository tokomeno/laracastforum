@extends('layouts.app')

@section('content')
{{$thread->replies->count()}}
<thread-view inline-template :proprepliescount="{{$thread->replies_count}}">
  <div class="container">
      <div class="row">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Forum Threads</div>

                  <div class="card-body">
                      <article>
                         <img src="{{ $thread->creator->avatar() }}" class="mr-2 mb-1" width="30" height="30">
                        <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name}}</a>
                        <h4> {{$thread->title}} </h4>
                        <div class="body"> {{$thread->body}} </div>
                      </article>
                    @auth
                    <form action="{{$thread->path()}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}

                        <button class="btn btn-danger">Deltee</button>
                    </form>
                    @endauth

                  </div>
              </div>

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


    </div>
  </div>
</thread-view>
@endsection
