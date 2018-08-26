<reply inline-template :reply="{{$reply}}" v-cloak>


  <div class="card mt-3" id="reply-{{$reply->id}}">
    <div class="card-header">
      <div class="d-flex">
        <a href="#">{{ $reply->owner->name}}</a> said
      {{$reply->created_at->diffForHumans()}} ago

        <div class="flex-fill">
          <form action="/replies/{{$reply->id}}/favorites" method="post">
            {{csrf_field()}}
            <button class="btn btn-primery float-right">{{$reply->favorites_count}} Favorite</button>
          </form>
          <favorite :reply="{{$reply}}"></favorite>
        </div>

      </div>

    </div>
    <div class="card-body">
        <div v-if='!editing' v-text="body">
            {{$reply->body}}
        </div>
        <div v-else>
          <div class="form-group">
          <textarea class='form-control' v-model="body"></textarea>
          </div>

          <button class="btn btn-sm btn-danger" @click="update">save</button>
          <button class="btn btn-sm btn-warning" @click="editing = false">cancel</button>

        </div>
    </div>

@can('update', $reply)
      <div class="card-footer justify-content-start">
       {{--   <form action="/replies/{{$reply->id}}" method="post" style="width: 120px;">
          {{csrf_field()}}
          {{method_field('DELETE')}}
          <button class="btn btn-sm btn-danger float-right">Delete</button>
        </form> --}}

         <button @click="destroy" class="btn btn-sm btn-danger">Delete</button>
        <button class="btn btn-sm" @click="editing = true">Edit</button>
      </div>
    @endcan

  </div>


</reply>
