@extends('layouts.app')

@section('content')

<div class="container">
{{-- @can('update', $profileUser) --}}

  <avatar-form :user="{{$profileUser}}"></avatar-form>

<div class="page-header d-flex">
	<h1>
		{{$profileUser->name}}
	</h1>




	<small>
		Since {{$profileUser->created_at->diffForHumans() }}
	</small>
</div>
<hr>


<div class="col-md-8">
  @foreach ($activities as $date => $activity)
    <h2>{{$date}}</h2>
    @foreach ($activity as $a)
      @if (view()->exists("profiles.activities.{$a->type}"))
        @include("profiles.activities.{$a->type}", ['activity' => $a])
      @endif
    @endforeach
  @endforeach
</div>


 {{-- <div class="col-md-8">
 	@foreach ($threads as $thread)
            <div class="card my-3">
                <a class="card-header" href="{{$thread->path()}}"> {{$thread->title}}</a>

                <div class="card-body">

                   	<article>
                      <a href="#">{{$thread->creator->name}}</a>
                   		<h4> </h4>

                   		<div class="body"> {{$thread->body}} </div>
                   	</article>

                </div>
            </div>
 	@endforeach
   </div> --}}

	{{-- {{$threads->links()}} --}}
 </div>



@endsection
