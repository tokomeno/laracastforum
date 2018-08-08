@extends('layouts.app')

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
                        <input type="text" name='title' class="form-control" id="title" placeholder="title">
                      </div>
                     
                      <div class="form-group">
                        <label for="body">body</label>
                        <textarea class="form-control" name='body' id="body" placeholder="body" rows="3"></textarea>
                      </div>
                      <button type='submit' class="btn">Submit</button>
                    </form>
                  </div>
                  
                  
                
            </div>
        </div>
    </div>
</div>


@endsection
