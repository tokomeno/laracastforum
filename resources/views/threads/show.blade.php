@extends('layouts.app')

@section('content')
<thread-view inline-template :proprepliescount="{{$thread->replies_count}}">
  <div class="container">
      <div class="row">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Forum Thredas</div>

                  <div class="card-body">  
                      <article>
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
               {{-- :data="{{$thread->replies}}" --}}
               ></replies>
{{--  
              <form action="{{ $thread->path() }}/replies" method="POST" class="mt-4">
                {{csrf_field()}}
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Text</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='body'></textarea>
                </div>

                <button class="btn">Submit</button>

              </form> --}}
        </div>
  <div class="col-md-4">
              <div class="card">
                  <div class="card-header">SOme</div>

                  <div class="card-body">
                    {{-- @foreach ($threads as $thread) --}}

                      <article>
                        <p>
                          Thread was published at {{$thread->created_at->diffForHumans()}} by  
                          <a href="#">{{$thread->creator->name}}</a>
                           and currently has <span v-text="repliesCount"></span>
                        </p>
                      </article>

                    {{-- @endforeach --}}
                  </div>
              </div>



    </div>
  </div>
</thread-view>
@endsection
