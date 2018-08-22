@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

           @forelse ($threads as $thread)
            <div class="card my-3">
                <div class="card-header"> <h4 class='d-flex'>
                        <a href="{{$thread->path()}}">{{$thread->title}}</a>
                        <div class="flex-1 h6 ml-2 flex-fill text-right">{{$thread->replies_count}} replies</div>
                      </h4>
</div>
                 <div class="card-body mt-3">
                   	<article>

                   		<div class="body"> {{$thread->body}} </div>
                   	</article>
                  </div>
            </div>
          @empty
          <h3>There are no relevant info for this time</h3>
          @endforelse
        </div>
    </div>
</div>
@endsection
