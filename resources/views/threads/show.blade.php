@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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

                   {{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>


     <div class="row justify-content-center">
        <div class="col-md-8">
          @foreach ($thread->replies as $reply)
            @include('inc.reply')
            @endforeach
        </div>
    </div>


     <div class="row justify-content-center mt-3">
        <div class="col-md-8">
    <form action="{{ $thread->path() }}/replies" method="POST">
      {{csrf_field()}}
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Text</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='body'></textarea>
      </div>

      <button class="btn">Submit</button>
 
    </form>
  </div>
</div>


</div>
@endsection
