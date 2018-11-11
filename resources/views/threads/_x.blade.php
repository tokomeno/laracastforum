<div class="card">
    <div class="card-header">Forum Threads</div>
      <div class="card-body" v-if="! editing">
          <article>
             <img src="{{ $thread->creator->avatar_path }}" class="mr-2 mb-1" width="30" height="30">
            <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name}}</a>
            <h4> {{$thread->title}} </h4>
            <div class="body"> {{$thread->body}} </div>
          </article>
        @auth
        <form action="{{$thread->path()}}" method="post">
            {{csrf_field()}}
            {{method_field('delete')}}

            <button class="btn btn-danger">Deltee</button>
        </form>
        @endauth

        <button class="btn btn-warging" @click=" editing = !editing" >Edit</button>

      </div>


      <div class="card-body" v-if="editing">



        <button class="btn btn-warging" @click=" editing = !editing" >Edit</button>

      </div>
</div>
