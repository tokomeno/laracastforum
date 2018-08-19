@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Thredas</div>


                   @foreach ($threads as $thread)

                 <div class="card-body mt-3">
                   	<article>
                   		<h4 class='d-flex'>
                        <a href="{{$thread->path()}}">{{$thread->title}}</a>
                        <div class="flex-1 h6 ml-2 flex-fill text-right">{{$thread->replies_count}} replies</div>
                      </h4>

                   		<div class="body"> {{$thread->body}} </div>
                   	</article>
                  </div>
                  <hr>
                   @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
