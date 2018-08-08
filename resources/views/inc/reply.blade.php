<div class="card mt-3"> 
  <div class="card-header">
     {{ $reply->owner->name}} said
    {{$reply->created_at->diffForHumans()}} ago
  </div>
    <div class="card-body">
        
      {{$reply->body}}
      
    </div>
</div>