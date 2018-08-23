<div class="card my-3">
	<div class="card-header">
	    <a href="#" class="font-weight-bold">{{$activity->subject->creator->name}} </a> <span class="font-weight-bold">published a</span>
	    <a  href="{{$activity->subject->path()}}"> {{$activity->subject->title}}</a>
	</div>

    <div class="card-body">

        <article>

          <div class="body"> {{$activity->subject->body}} </div>
        </article>

    </div>
</div>
