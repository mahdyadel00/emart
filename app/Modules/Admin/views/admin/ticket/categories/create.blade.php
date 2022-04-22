@extends('admin.layout.index',[
	'title' => _i('Create New Category'),
	'subtitle' => _i('Create New Category'),
	'activePageName' => _i('Create New Category'),
	'activePageUrl' => route('ticket.category.index'),
	'additionalPageUrl' => route('ticket.index') ,
	'additionalPageName' => _i('Tickets'),
] )
@section('content')
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
				@include('admin.layout.message')
				{!! Form::open(['route'=>'ticket.category.store','class'=>'form-group']) !!}
				<div class="form-group">
					{{Form::label('name',null,['class'=>'control-label'])}}
					{{Form::text('name',old('name'),['class'=>'form-control'])}}
					@if ($errors->has('name'))
						<span class="text-danger invalid-feedback" role="alert">
								  <strong>{{ $errors->first('name') }}</strong>
							</span>
					@endif
				</div>
				<div class="form-group">
					{{Form::label('color',null,['class'=>'control-label'])}}
					{{Form::color('color',null,['class'=>'form-control'])}}
					@if ($errors->has('color'))
						<span class="text-danger invalid-feedback" role="alert">
								  <strong>{{ $errors->first('color') }}</strong>
							</span>
					@endif
				</div>
				{!! Form::submit('save',['class'=>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection