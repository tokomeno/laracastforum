@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Thredas</div>

                <div class="card-body">
                   {{-- @foreach ($threads as $thread) --}}

                   	<article>
                      <a href="#">{{$thread->creator->name}}</a>
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

                   {{-- @endforeach --}}
                </div>
            </div>


            @foreach ($replies as $reply)
            @include('inc.reply')
            @endforeach

            <div class="my-5">
              {{$replies->links()}}
            </div>



            <form action="{{ $thread->path() }}/replies" method="POST" class="mt-4">
              {{csrf_field()}}
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Text</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='body'></textarea>
              </div>

              <button class="btn">Submit</button>

            </form>
      </div>

          <div class="col-md-4">
            <div class="card">
                <div class="card-header">SOme</div>

                <div class="card-body">
                   {{-- @foreach ($threads as $thread) --}}

                    <article>
                      <p>
                        Thread was published at {{$thread->created_at->diffForHumans()}} by  <a href="#">{{$thread->creator->name}}</a> and currently has {{$thread->replies_count}}
                      </p>
                    </article>

                   {{-- @endforeach --}}
                </div>
            </div>



  </div>
</div>
@endsection
