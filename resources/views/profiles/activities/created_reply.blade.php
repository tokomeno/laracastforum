 <div class="card my-3">
 	{{-- {{$activity->subject->path()}} --}}
 	<div class="card-header">
    	<a class="" href=""> {{$activity->subject->owner->name}}</a>
    	<span class="font-weight-bold">replied to</span>
    	<a href="">{{$activity->subject->thread->title}}</a>
    </div>

    <div class="card-body">

        <article>
          <div class="body"> {{$activity->subject->body}} </div>
        </article>

    </div>
</div>
