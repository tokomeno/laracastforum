 <div class="card my-3">
 	{{-- {{$activity->subject->path()}} --}}
 	<div class="card-header">
    	<a class="" href="{{ $activity->subject->favorited->path() }}"> {{ $profileUser->name }}
    	<span class="font-weight-bold">favorited reply</span>
		</a>
    </div>

    <div class="card-body">

        <article>
          <div class="body"> {{$activity->subject->favorited->body}} </div>
        </article>

    </div>
</div>
