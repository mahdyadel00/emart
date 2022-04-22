<div class="tab-pane" id="digitalProduct">
	<div class="row">
		<div class="col-md-4">
			<div class="dropdown">
				<button class="btn btn-secondary add-digit-row" type="button">
					<i class="ti-plus" style='margin:5px'></i>{{ _i('Add new file') }}
				</button>
			</div>
		</div>
	</div>
	<form action="#" method="post" id="digital-form" enctype="multipart/form-data">
		@csrf
		<div id="digits_list">
		</div>
		<button type="submit" class="btn btn-primary"
			style="float: left;padding: 10px 20px;margin-top: 20px;">{{ _i('Save changes') }}</button>
	</form>
</div>
@push("js")
<script type="text/javascript">
	$(document).on('click', '.product-digital', function(e){
		e.preventDefault();
		$('#digits_list').html('');
		console.log('Attemping to load product digital files');
		$.ajax({
			url: "{{route('get_digital')}}",
			type: "get",
			data: {product_id: $product_id},
			success: function (response) {
				if( response.length == 0 )
				{
					$('#digits_list').append(`
						<div class='row mt-4 there-is-no-files'>
							<div class='col-md-12'>
								<div class="alert alert-warning" role="alert">
									<h4 class="alert-heading">{{ _i('Well') }} !</h4>
									<hr>
									<p class="mb-0">{{ _i('There is no files here') }}.</p>
								</div>
							</div>
						</div>
					`);
				}
				$.each(response, function(k, v){
					console.log(v);
					$('#digits_list').append(`
						<div class="field-section field-section-`+v.code+`">
							<input name="fields[`+v.code+`][sort]" class="btn btn-primary sort" type="hidden" value="`+v.sort+`">
							<div class="row field-row-header">
								<div class="col-md-4 col-xs-7 text-right custom-filed-updown">
									<div class="btn-toolbar">
										<div class="btn-group">
											<button type="button" class="btn btn-default up-button">
												<i class="ti-arrow-up"></i>
											</button>
											<button type="button" class="btn btn-default down-button">
												<i class="ti-arrow-down"></i>
											</button>
											<button type="button" class="btn btn-default bg-danger bg-danger2 remove-file" data-code='`+v.code+`'>
												<i class="ti-close"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-text"></i>
											</span>
											<input type="text" class="form-control" placeholder="{{ _i('Field name') }}" name="fields[`+v.code+`][title]" value='`+v.title+`' required>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div class="input-group">
											<input type="text" class="form-control digital-file-name" readonly data-code='`+v.code+`' value='`+v.file+`'>
											<span class="input-group-append digital-choose-file" data-code='`+v.code+`'>
												{{ _i('Choose file') }}
											</span>
											<input type="file" name="fields[`+v.code+`][file]" class="digital-file" data-code='`+v.code+`' style='display:none'>
										</div>
									</div>
								</div>
							</div>
						</div>
					`);
				});
			},
		});
	});

	$(document).on('click', '.add-digit-row', function(e){
		e.preventDefault();

		//rand = makeid(9);
		var last_sort = $('.field-section:last-child').find('.sort').val();
		if(last_sort === undefined)
		{
			var last_sort = 0;
		}
		if(isNaN(last_sort))
		{
			var last_sort = 0;
		}
		var next_sort = parseInt(last_sort) + 1;

		$('.there-is-no-files').hide();

		$('#digits_list').append(`
			<div class="field-section" data-type="text">
				<input name="fields[`+rand+`][sort]" class="btn btn-primary sort" type="hidden" value="`+next_sort+`">
				<div class="row field-row-header">
					<div class="col-md-4 col-xs-7 text-right custom-filed-updown">
						<div class="btn-toolbar">
							<div class="btn-group">
								<button type="button" class="btn btn-default up-button">
									<i class="ti-arrow-up"></i>
								</button>
								<button type="button" class="btn btn-default down-button">
									<i class="ti-arrow-down"></i>
								</button>
								<button type="button" class="btn btn-default bg-danger bg-danger2 remove-file" data-code='`+rand+`'>
									<i class="ti-close"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-prepend">
									<i class="ti-text"></i>
								</span>
								<input type="text" class="form-control" placeholder="{{ _i('File name') }}" name="fields[`+rand+`][title]" required>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control digital-file-name" readonly data-code='`+rand+`'>
								<span class="input-group-append digital-choose-file" data-code='`+rand+`'>
									Choose file
								</span>
								<input type="file" name="fields[`+rand+`][file]" class="digital-file" data-code='`+rand+`' style='display:none'>
							</div>
						</div>
					</div>
				</div>
			</div>
		`);
	});

	$(document).on('click', '.digital-choose-file', function(e){
		e.preventDefault();
		var file = $(this).next('.digital-file');
		file.trigger('click');
	});

	$(document).on('change', '.digital-file', function(e){
		e.preventDefault();
		var filename = $(this).val().split("\\").pop();
		var file_input = $(this).parent('div').find('.digital-file-name');
		file_input.val(filename);
	});

	$(document).on('click', '.up-button', function(e){
		e.preventDefault();
		var current = $(this).parents('.field-section');
		var previous = current.prev('.field-section');
		$(current).insertBefore(previous);

		var cpos = $(current).find(".sort").val();
		cpos = parseInt(cpos);

		var ppos = $(previous).find(".sort").val();
		ppos = parseInt(ppos);

		$(current).find(".sort").val(ppos);
		$(previous).find(".sort").val(cpos);
	});

	$(document).on('click', '.down-button', function(e){
		e.preventDefault();
		var current = $(this).parents('.field-section');
		var next = current.next('.field-section');
		$(current).insertAfter(next);

		var cpos = $(current).find(".sort").val();
		cpos = parseInt(cpos);

		var ppos = $(next).find(".sort").val();
		ppos = parseInt(ppos);

		$(current).find(".sort").val(ppos);
		$(next).find(".sort").val(cpos);
	});

	$(document).on('click', '.remove-file', function(e){
		e.preventDefault();
		console.log('Attemping to remove section');
		var $this = $(this);
		var code = $(this).data('code');

		$.ajax({
			url: "{{route('del_digital')}}",
			type: "delete",
			data: {'_token': "{{ csrf_token() }}", 'code': code},
			success: function (response) {
				if( response == 'success' )
				{
					$this.parents('.field-section').remove();
				}
			},
		});
	});

	$('#digital-form').submit(function(e){
		e.preventDefault();
		console.log('Attempting to submit form');
		var data = new FormData(this);
		data.append('product_id', $product_id);
		$.ajax({
			url: "{{route('post_digital')}}",
			type: "post",
			data: data,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				if( response == 'error' )
				{
					Swal.fire({
						icon: 'error',
						position: 'center',
						title: "{{ _i('Error !') }}",
						showConfirmButton: false,
						timer: 5000
					})
				}
				else if( response == 'success' )
				{
					Swal.fire({
						icon: 'success',
						position: 'center',
						title: "{{ _i('Saved Successfully !') }}",
						showConfirmButton: false,
						timer: 5000
					})
				}
			},
		});
	});
</script>
@endpush
