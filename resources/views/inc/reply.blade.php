<div class="card mt-3">
  <div class="card-header">
  	<div class="d-flex">
  		<a href="#">{{ $reply->owner->name}}</a> said
    {{$reply->created_at->diffForHumans()}} ago

    <div class="flex-fill">
    	<form action="/replies/{{$reply->id}}/favorites" method="post">
    		{{csrf_field()}}
    		<button class="btn btn-primery float-right">{{$reply->favorites_count}} Favorite</button>
    	</form>
    </div>
  	</div>

  </div>
    <div class="card-body">

      {{$reply->body}}

    </div>
</div>
