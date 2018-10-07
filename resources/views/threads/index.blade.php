@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('threads._list')

            {{$threads->links()}}
        </div>

        <div class="col-md-4">
        	@if(count($trending))
	        	<div class="list-group">
				    <a href="#!" class="list-group-item list-group-item-action active">
				    	Tranding Threads
				    </a>
					@foreach ($trending as $thread)
						<a href="{{$thread->path}}" class="list-group-item list-group-item-action disabled">{{$thread->title}}</a>
					@endforeach
				</div>
			@endif
        </div>
    </div>
</div>
@endsection
