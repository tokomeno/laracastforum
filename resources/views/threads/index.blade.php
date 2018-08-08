@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Thredas</div>

              
                   @foreach ($threads as $thread)
                   <hr>
                 <div class="card-body mt-3">
                   	<article>
                   		<h4> <a href="{{$thread->path()}}">{{$thread->title}}</a> </h4>

                   		<div class="body"> {{$thread->body}} </div>
                   	</article>
                  </div>
                   @endforeach
                
            </div>
        </div>
    </div>
</div>
@endsection
