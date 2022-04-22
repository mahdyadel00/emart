@extends('admin.layout.index',[
'title' => _i('Create New Ticket'),
'level1' => _i('Tickets'),
'level1_url' => route('new_request'),
'level2' => _i('Create New Ticket'),
'level2_url' =>"#",
])
@section('content')
@push('js')
	<script>
		$(document).ready(function() {
			$(".e2").select2({
				placeholderr: "choose one",
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
			<form method='post' action='{{ route('admin.new.ticket.store') }}' class='form-group' data-parsley-validate>
				@csrf
				<div class="form-group">
					<label for="subject" class="control-label">{{ _i('Subject') }}</label>
					<input class="form-control" name="subject" type="text" id="subject" required="">
					@if ($errors->has('subject'))
						<span class="text-danger invalid-feedback" role="alert">
							<strong>{{ $errors->first('subject') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group">
					<label for="content" class="control-label">{{ _i('Contents') }}</label>
					<textarea class="form-control" name="content" cols="50" rows="10" id="content" required=""></textarea>
					@if ($errors->has('content'))
						<span class="text-danger invalid-feedback" role="alert">
							<strong>{{ $errors->first('content') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group row">
					
					<div class="col-md-3">
						<label for="category" class="control-label">{{ _i('Category') }}</label>
						<select name='category' class='form-control' placeholder='{{ _i('Choose One') }}' required="">
							@foreach($categories AS $category)
							<option value='{{$category->id}}'>{{$category->translation->name}}</option>
							@endforeach
						</select>
						@if ($errors->has('category'))
							<span class="text-danger invalid-feedback" role="alert">
								<strong>{{ $errors->first('category') }}</strong>
						</span>
						@endif
					</div>
					<!-- <div class="col-md-3">
						<label for="status" class="control-label">{{ _i('Status') }}</label>
						<select name='status' class='form-control' placeholder='{{ _i('Choose One') }}' required="">
							@foreach(get_ticket_statuses() AS $key => $status)
							<option value='{{$key}}'>{{$status}}</option>
							@endforeach
						</select>
						@if ($errors->has('status'))
							<span class="text-danger invalid-feedback" role="alert">
								<strong>{{ $errors->first('status') }}</strong>
						</span>
						@endif
					</div> -->
					<div class="col-md-3">
						<label for="" class="control-label">{{ _i('Priority') }}</label>
						<select name='priority' class='form-control' placeholder='{{ _i('Choose One') }}' required="">
							@foreach($priorities AS $priority)
							<option value='{{$priority->id}}'>{{$priority->translation->name}}</option>
							@endforeach
						</select>
						@if ($errors->has('priority'))
							<span class="text-danger invalid-feedback" role="alert">
								<strong>{{ $errors->first('priority') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<input class="btn btn-primary" type="submit" value="{{ _i('Save') }}">
			</form>
		</div>
	</div>
	</div>
@endsection
