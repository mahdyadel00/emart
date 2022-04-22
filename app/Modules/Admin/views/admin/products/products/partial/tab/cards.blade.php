<div class="tab-pane" id="productCard">
	<div class="row">
		<div class="col-md-4">
			<div class="dropdown">
				<button class="btn btn-secondary add-card-row" type="button">
					<i class="ti-plus" style='margin:5px'></i>{{ _i('Add new card') }}
				</button>
			</div>
		</div>
	</div>
	<form action="#" method="post" id="cards-form" enctype="multipart/form-data">
		@csrf
		<div id="cards_list">
		</div>
		<button type="submit" class="btn btn-primary"
			style="float: left;padding: 10px 20px;margin-top: 20px;">{{ _i('Save changes') }}</button>
	</form>
</div>
@push("js")
<script type="text/javascript">
	$(document).on('click', '.product-cards', function(e){
		e.preventDefault();
		$('#cards_list').html('');
		console.log('Attemping to load product cards');
		$.ajax({
			url: "{{route('get_card')}}",
			type: "get",
			data: {product_id: $product_id},
			success: function (response) {
				if( response.length == 0 )
				{
					$('#cards_list').append(`
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
					$('#cards_list').append(`
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
											<button type="button" class="btn btn-default bg-danger bg-danger2 remove-card" data-code='`+v.code+`'>
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
												<i class="ti-credit-card"></i>
											</span>
											<input type="text" class="form-control" placeholder="{{ _i('Card number') }}" name="fields[`+v.code+`][card]" value='`+v.card+`'>
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

	$(document).on('click', '.add-card-row', function(e){
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

		$('#cards_list').append(`
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
								<button type="button" class="btn btn-default bg-danger bg-danger2 remove-card" data-code='`+rand+`'>
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
									<i class="ti-credit-card"></i>
								</span>
								<input type="text" class="form-control" placeholder="{{ _i('Card number') }}" name="fields[`+rand+`][card]">
							</div>
						</div>
					</div>
				</div>
			</div>
		`);
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

	$(document).on('click', '.remove-card', function(e){
		e.preventDefault();
		console.log('Attemping to remove section');
		var $this = $(this);
		var code = $(this).data('code');

		$.ajax({
			url: "{{ route('delete_card') }}",
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

	$('#cards-form').submit(function(e){
		e.preventDefault();
		console.log('Attempting to submit form');
		var data = new FormData(this);
		data.append('product_id', $product_id);
		$.ajax({
			url: "{{route('post_card')}}",
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
