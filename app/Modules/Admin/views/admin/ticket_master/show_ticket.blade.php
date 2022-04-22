@extends('admin.layout.index',[
    'title' => _i('Show Ticket'),
    'subtitle' => _i('Show Ticket'),
    'activePageName' => _i('Show Ticket'),
    'activePageUrl' => route('view_request' , $ticket->id),
] )

@section('content')
    @push('js')
        <script>
            $(document).ready(function() {
                $(".e2").select2({
                    placeholder: "choose one",
                    allowClear: true,
                });
            });
        </script>
    @endpush
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">
            @include('admin.layout.message')
            
                <div class="form-group">
                    <label for="subject" class="control-label">{{ _i('Subject') }}</label>
                    <p>{{ $ticket->subject }}</p>
                    
                </div>
                <div class="form-group">
                    <label for="content" class="control-label">{{ _i('Contents') }}</label>
                    
                   <p>{{$ticket->content}}</p>
                </div>
                <div class="form-group row">
                    
                    <div class="col-md-3">
                        <label for="category" class="control-label">{{ _i('Category') }}</label>
                        <p>{{$category_name}}</p>
                        
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="control-label">{{ _i('Status') }}</label>
                        <p>{{$ticket->status}}</p>
                        
                    </div>
                    <div class="col-md-3">
                        <label for="" class="control-label">{{ _i('Priority') }}</label>
                        <p>{{$priority_name}}</p>
                    </div>
                </div>
                
        </div>
    </div>
    </div>
    
    @if(count($replies) > 0)
    <p>Replies</p>
    @foreach($replies as $reply)

        <p>Name :@if($reply->admin_id) {{App\User::find($reply->admin_id)['name']}} @elseif($reply->user_id) {{App\User::find($reply->user_id)['name']}} @endif</p>
        <p>Comment : {{$reply->content}}</p>

    @endforeach
    @if($ticket->status != 'closed')
    <form method="post" action="{{route('admin.reply.to.master' , $ticket->id)}}">
        {{ csrf_field() }}
        <textarea name="comment" class="form-control"></textarea>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @endif
    @else 
    <p>No Replies At This Moment</p>
    @endif

@endsection