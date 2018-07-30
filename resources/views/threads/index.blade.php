@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Thredas</div>

              
                   @foreach ($threads as $thread)
  <div class="card-body">
                   	<article>
                   		<h4> {{$thread->title}} </h4>

                   		<div class="body"> {{$thread->body}} </div>
                   	</article>
</div>
                   @endforeach
                
            </div>
        </div>
    </div>
</div>
@endsection
