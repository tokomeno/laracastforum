 @forelse ($threads as $thread)
            <div class="card my-3">
                <div class="card-header">
                    <h4 class='d-flex'>
                      <a href="{{$thread->path()}}">
                        @if( auth()->check() && $thread->hasUpdatesFor( auth()->user() ) )
                          <strong>{{$thread->title}}</strong>
                        @else
                          {{$thread->title}}
                        @endif
                      </a>
                      <div class="flex-1 h6 ml-2 flex-fill text-right">{{$thread->replies_count}} replies</div>
                    </h4>
                    <div class="text-right">
                      Posted by: <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a>
                    </div>
                </div>
                 <div class="card-body mt-3">
                   	<article>
                   		<div class="body"> {{$thread->body}} </div>
                   	</article>
                  </div>
            </div>
          @empty
          <h3>There are no relevant info for this time</h3>
          @endforelse
