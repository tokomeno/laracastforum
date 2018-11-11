@extends('layouts.app')

@section('head')
  <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Thread</div>
                    <div class="card-body">
                    <form action="/threads" method="POST">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label for="title">title</label>
                        <input type="text" name='title' class="form-control" id="title" placeholder="title" value="{{ old('title') }}" >
                        <p class="text-danger">{{$errors->first('title')}}</p>
                      </div>

                      <div class="form-group">
                        <label for="body">body</label>
                        <textarea class="form-control" name='body' id="body" placeholder="body" rows="3">{{ old('body') }} </textarea>
                         <p class="text-danger">{{$errors->first('body')}}</p>
                      </div>

                      <div class="form-group">
                        <label for="channel_id">Choose Channel</label>
                        <select  name='channel_id' class="form-control" id="channel_id" placeholder="channel_id"  >
                          <option value="">Choose Channel</option>
                          @foreach ($channels as $c)
                             <option value="{{$c->id}}" {{ old('channel_id') == $c->id ? 'selected' : '' }}>{{$c->name}}</option>
                          @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('channel_id')}}</p>
                      </div>

                      <button type='submit' class="btn">Submit</button>
                   <div class="g-recaptcha" data-sitekey="6LcIAHoUAAAAAL8VLfzae_AqUtvqgH7i8Ay0IYUX"></div>
                     <p class="text-danger">{{$errors->first('g-recaptcha-response')}}</p>
                    </form>
                  </div>



            </div>
        </div>
    </div>
</div>


@endsection
