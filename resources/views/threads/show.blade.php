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
            <div class="card mt-3"> 
              <div class="card-header">
                 {{ $reply->owner->name}} said
                {{$reply->created_at->diffForHumans()}} ago
              </div>
                <div class="card-body">
                    
                  {{$reply->body}}
                  
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
