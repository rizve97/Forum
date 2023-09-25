@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center alert-info">
        {{$channel->name}}
    </div>

    <div class="card-body">
        @if(Auth::check())
          <button type="button" data-toggle="modal" data-target="#createProblemModal" class="btn btn-primary btn-block btn-lg">
            Post A New Problem
        </button> <br>
        @endif
        <hr> <br>
        @if($channel->problems->count() > 0)
            @foreach($channel->problems as $problem)
                <div class="card">
                    <div class="card-header @if($problem->open) alert-success @else alert-danger @endif">
                        {{$problem->title}} <span class="pull-right"><a href="{{route('problem.show',['id' => $problem->id])}}" class="btn btn-sm btn-success">View</a></span>
                    </div>
                    <div class="card-body">
                        <p class="text-center">
                            {{$problem->body}}......
                        </p>
                    </div>
                    <div class="card-footer">
                        By : {{$problem->user->name}} | {{\Carbon\Carbon::parse($problem->created_at)->diffForHumans()}} | Status : @if($problem->open) Open @else Closed @endif
                    </div>
                </div>
                <hr>
            @endforeach
            <div id="newProblems"></div>
        @else
            <div class="alert alert-info text-center">
                No Problems Posted Yet.
            </div>
        @endif

    </div>
</div>






<!-- modal for creating problems -->



<div class="modal fade" id="createProblemModal" tabindex="-1" role="dialog" aria-labelledby="createProblemModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createProblemModalLabel">Create New Problem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input type="hidden" name="channel_id" value="{{$channel->id}}">
          <div class="form-group">
              <label for="">Channel : </label>
              <input type="text" class="form-control" value="{{$channel->name}}" disabled="">
          </div>
          <div class="form-group">
            <label for="title" class="col-form-label">Title:</label>
            <input type="text" class="form-control" name="title" id="title">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Body:</label>
            <textarea class="form-control" name="body" id="body"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="postProblem()" data-dismiss="modal" class="btn btn-primary">Post Problem</button>
        
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script>
   
  function postProblem(){
    var channel_id = $("input[name=channel_id]");
    var title = $("input[name=title]");
    var body = $("textarea[name=body]");
    var fields = [title,body];
    csrfAjaxToken();
    $.ajax({
      'type' : 'POST',
      'url' : '{{route('problem.store')}}',
      data : {
        'channel_id' : channel_id.val(),
        'title' : title.val(),
        'body' : body.val()
      },
      success : function(response){
        if(response.status == 'error'){
          validationErrors(response.errors);
        } else if(response.status == 'success'){
          clearFields(fields);
          notifications(response.code);
          updateProblems(response.data,response.username);
        }
      },
      error : function(response){
        notifications(response.status);
      }
    });
  }

  function validationErrors(keys)
  {
    for(var key in keys)
    {
      toastr.error(keys[key],'Validation Error');
    }
  }

  function clearFields(keys){
    for(var key in keys){
      keys[key].val('');
    }
  }

  function updateProblems(data,username){
    $("#newProblems").append('<div class="card"><div class="card-header @if('+data["open"]+') alert-success @else alert-danger @endif">'+data["title"]+' <span class="pull-right"><a href="{{route("problem.show",["id" => '+data["id"]+'])}}" class="btn btn-sm btn-success">View</a></span></div><div class="card-body"><p class="text-center">'+data["body"]+'</p></div><div class="card-footer">By : '+username+' | Just Now | Status : @if('+data["open"]+') Open @else Closed @endif</div></div><hr>');
  }



  
</script>
@endsection
