@extends('admin.layout.index',[
	'title' => _i('Tickets'),
	'subtitle' => _i('Tickets'),
	'activePageName' => _i('Tickets'),
	'activePageUrl' => route('ticket.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
	@push('js')
		<script>
			$(function () {
				'use strict'
				$('.mark').on('click',function () {
					var mark = '{{$ticket->status == 'closed' ? 'opened' : 'closed'}}';
					var ticket = '{{$ticket->id}}';
					if (this){
						$.ajax({
							url:"{{url('admin/ticket/completed/complate')}}",
							dataType:'html',
							type:'get',
							data:{mark: mark, ticket: ticket},
							success:function (data) {
								if (data == 'closed'){
									window.location.href = "{{url('admin/ticket')}}";
								}else{
									window.location.href = "{{url('admin/ticket')}}";
								}
							}
						})
					}
				});
			});
		</script>
	@endpush
	@push('css')
		<style>
			.heading-title{
				padding: 20px;
			}
			.header{
				padding: 20px;
			}
			.header li {
				margin-bottom: 5px;
			}
			.text{
				padding: 10px 20px;
				font-size: 16px;
			}
			.text p{
				line-height: 1.4;
			}
			.reply .content{
				resize: none;
			}
		</style>
	@endpush
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
			@include('admin.layout.message')
			<div class="panel panel-default">
				<div class="heading-title">
					<div class="row">
						<div class="col-md-6">
							<h4 style="margin-top:5px">{{$ticket->subject}}</h4>
						</div>
						<div class="col-md-6" style="text-align: left">
							<ul class="list-inline">
								<li>
									<a href="#" class="btn btn-success mark">
										@if($ticket->status != 'closed')  {{ _i('Mark Complate') }} @else {{ _i('Reopene ticket') }} @endif
									</a>
								</li>
								<li>
									<a href="{{route('ticket.edit', $ticket->id)}}" class="btn btn-primary">{{ _i('Edit') }}</a>
								</li>
								<li>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">{{ _i('Delete') }}</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
					<div class="header">
						<div class="panel well well-sm">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<ul class="list-unstyled">
											<li><strong>{{ _i('Responsible') }}: </strong>
												@isset( $ticket->admin->name ) {{ $ticket->admin->name }} @endisset</li>
											<li><strong>{{ _i('Category') }}: </strong>{{$ticket->category->translation->name}}</li>
											<li><strong>{{ _i('created') }}: </strong>{{$ticket->created_at->diffForHumans() }}</li>
											<li><strong>{{ _i('Last Update') }}: </strong>{{$ticket->updated_at->diffForHumans() }}</li>
										</ul>
									</div>
									<div class="col-md-6">
										<ul class="list-unstyled">
											<li><strong>{{ _i('Owner') }}: {{$ticket->user->name}}</strong></li>
											<li>
												<strong>{{ _i('Status') }}: </strong>
												{{get_ticket_statuses($ticket->status)}}
											</li>
											<li>
												<strong>{{ _i('Priority') }}: </strong>
												{{$ticket->priority->translation->name}}
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							{{$ticket->content}}
						</p>
					</div>
			</div>
			@if(count($comments) > 0)
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="comments">
						<h3>{{ _i('comments') }}</h3>
						@foreach($comments as $comment)
						<div class="panel panel-default panel-main">
							<div class="panel-heading">
								<h3 class="panel-title">
									@if($comment->res_comment == 2)
									{{$comment->user->name}}
									@elseif($comment->res_comment == 1)
									@isset($comment->admin->name) {{$comment->admin->name}} @endisset
									@endif
								</h3>
							</div>
							<div class="panel panel-body">
								{{$comment->content}}
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			@endif
			{!! Form::open(['route'=>'ticket_comment.store','class'=>'form-group reply']) !!}
			<div class="panel panel-default">
				<div class="panel-body">
					<fieldset>
						<legend>
							{{ _i('Reply') }}
						</legend>
					</fieldset>
					<div class="form-group">
						{{Form::hidden('ticket',$ticket->id)}}
						{{Form::textarea('msgcontent',null,['class'=>'form-control content'])}}
					</div>
				</div>
			</div>
			{{Form::submit('Submit',['class'=>'btn btn-primary'])}}
			{!! Form::close() !!}
		</div>
	</div>

	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">{{$ticket->subject}}</h4>
				</div>
				<div class="modal-body">
					<p>{{ _i('are you sure to delete this ticket ?!') }}</p>
				</div>
				<div class="modal-footer">
					<div class="col-md-6 text-left">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ _i('Close') }}</button>
					</div>
					<div class="col-md-6 text-right">
						{{Form::open(['method'=>'DELETE','route'=>['ticket.destroy',$ticket->id]])}}
						{{Form::submit('Delete',['class'=>'btn btn-danger'])}}
						{{Form::close()}}
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection
