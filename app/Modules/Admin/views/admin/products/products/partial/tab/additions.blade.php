<div class="tab-pane" id="productAddition">
	<div class="row">
		<div class="col-md-4">
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					<i class="ti-plus" style='margin:5px'></i>{{ _i('Add Field') }}
				</button>
				<div class="dropdown-menu custom" aria-labelledby="dropdownMenuButton">
					<a class='dropdown-item' onclick="addFieldAjax('smalltext', '{{ _i('Small Text') }}', 'ti-text');">
						<i class="ti-text"></i>
						{{ _i('Small Text') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('largetext', '{{ _i('Large Text') }}', 'ti-uppercase');">
						<i class="ti-uppercase"></i>
						{{ _i('Large Text') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('number', '{{ _i('Number') }}', 'ti-quote-right');">
						<i class="ti-quote-right"></i>
						{{ _i('Number') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('radio', '{{ _i('Radio Button') }}', 'ti-layout-list-thumb');">
						<i class="ti-layout-list-thumb"></i>
						{{ _i('Radio Button') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('checkbox', '{{ _i('Check Box') }}', 'ti-list');">
						<i class="ti-list"></i>
						{{ _i('Check Box') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('image', '{{ _i('Image') }}', 'ti-image');">
						<i class="ti-image"></i>
						{{ _i('Image') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('date', '{{ _i('Date') }}', 'ti-calendar');">
						<i class="ti-calendar"></i>
						{{ _i('Date') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('time', '{{ _i('Time') }}', 'ti-timer');">
						<i class="ti-timer"></i>
						{{ _i('Time') }}
					</a>
					<a class='dropdown-item' onclick="addFieldAjax('datetime', '{{ _i('Date Time') }}', 'ti-calendar');">
						<i class="ti-calendar"></i>
						{{ _i('Date Time') }}
					</a>
				</div>
			</div>
		</div>
	</div>
	<form action="{{route('products.custom.fields.store')}}" method="post" id="custom-fields-form">
		@csrf
		<input type="hidden" name='product_id' value='43' class='custom-fields-product-id'>
		<div id="fields_list">
		</div>
		<button type="submit" class="btn btn-primary"
			style="float: left;padding: 10px 20px;margin-top: 20px;">{{ _i('Save changes') }}</button>
	</form>
</div>

@push('js')

<script>
	// var product_id;
	// var rand = makeid(9);
	// var option_rand = makeid(9);
	// var option_rand_2 = makeid(9);
	// var icons = {smalltext:"ti-text", largetext:"ti-uppercase", number:"ti-quote-right", radio:"ti-layout-list-thumb", checkbox:"ti-list", image:"ti-image", date:"ti-calendar", time:"ti-timer", datetime:"ti-calendar"};
	// var names = {smalltext:"{{ _i('Small Text') }}", largetext:"{{ _i('Large Text') }}", number:"{{ _i('Number') }}", radio:"{{ _i('Radio Button') }}", checkbox:"{{ _i('Check Box') }}", image:"{{ _i('Image') }}", date:"{{ _i('Date') }}", time:"{{ _i('Time') }}", datetime:"{{ _i('Date Time') }}"};

	$(document).on('click', '.product-order-form', function(e){
		e.preventDefault();
		$('#fields_list').html('');
		product_id = $('.product_id').val();
		$('.custom-fields-product-id').val(product_id);
		console.log(product_id);
		console.log('Attemping to load product order form card');
		$.ajax({
			url: "{{route('products.custom.fields.show')}}",
			type: "get",
			data: {product_id: product_id},
			success: function (response) {
				if( response.length == 0 )
				{
					$('#fields_list').append(`
						<div class='row mt-4 there-is-no-options'>
							<div class='col-md-12'>
								<div class="alert alert-warning" role="alert">
									<h4 class="alert-heading">{{ _i('Well') }} !</h4>
									<hr>
									<p class="mb-0">{{ _i('There is no options here') }}.</p>
								</div>
							</div>
						</div>
					`);
				}
				$.each(response, function(k, v){
					console.log(v);
					var checked = v.required == 1 ? 'checked' : '';
					$('#fields_list').append(`
						<div class="field-section field-section-`+v.code+`" data-type="text">
							<input name="fields[`+v.code+`][type]" class="btn btn-primary" type="hidden" value="`+v.type+`">
							<input name="fields[`+v.code+`][sort]" class="btn btn-primary sort" type="hidden" value="`+v.sort+`">
							<div class="row field-row-header">
								<div class="col-md-6 col-xs-6 field-label-col">
									<span class="label label-info field-label label-info-light">
										<i class="`+icons[v.type]+`"></i> &nbsp; ` + names[v.type] + `
									</span>
								</div>
								<div class="col-md-6 col-xs-6 text-right field-required-col">
									<label>
										<input type="checkbox" class="check_field js-switch" `+checked+` name="fields[`+v.code+`][required]">
										{{ _i('Required field') }}
									</label>
								</div>
							</div>
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
											<button type="button" class="btn btn-default bg-danger bg-danger2 remove-button" data-code='`+v.code+`'>
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
											<input type="text" class="form-control" placeholder="{{ _i('Field name') }}" name="fields[`+v.code+`][name]" value='`+v.name+`' required>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-write"></i>
											</span>
											<input type="text" class="form-control" placeholder="{{ _i('Field description (optional)') }}" name="fields[`+v.code+`][desc]" value='`+v.desc+`'>
										</div>
									</div>
								</div>
							</div>
							<div class='field_custom_section field_custom_section_`+v.code+`'>

							</div>
						</div>
					`);

					var elem = Array.prototype.slice.call(document.querySelectorAll('.field-section:last-child .js-switch'));
					elem.forEach(function (html) {
						var switchery = new Switchery(html, {
							color: '#e22525',
							jackColor: '#fff',
							size: 'small'
						});
					});

					if (v.type == 'radio' || v.type == 'checkbox')
					{
						$('.field_custom_section_'+v.code).append(`
							<div class="row add-option-container add-option-`+v.code+`">
								<div class="col-md-12">
									<button type="button" class="btn btn-tiffany add_option" data-main-id='`+v.code+`'>
										{{ _i('Add Option') }}
									</button>
								</div>
							</div>
						`);

						if( v.options.length != 0 )
						{
							$.each( v.options, function( ok, ov )
							{
								$('.add-option-'+v.code).before(`
									<div class="row option-container">
										<div class='col-md-1'>
											<button type="button" class="btn deleteOption btn-default remove-option-button text-danger" data-code='`+ov.code+`'>
												<i class="ti-close"></i>
											</button>
										</div>
										<div class='col-md-11'>
											<div class='row'>
												<div class='col-md-6 option-box'>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-prepend">
																<i class="ti-text"></i>
															</span>
															<input type="text" class="form-control" placeholder="{{ _i('Option title') }}" name="fields[`+v.code+`][options][`+ov.code+`][name]" value='`+ov.name+`' required>
														</div>
													</div>
												</div>
												<div class='col-md-6 option-box'>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-prepend">
																<i class="ti-money"></i>
															</span>
															<input type="number" class="form-control" placeholder="{{ _i('Additional price') }}" name="fields[`+v.code+`][options][`+ov.code+`][price]" value='`+ov.price+`' required>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								`);
							});
						}
					}
				});
			},
		});
	});

	function addFieldAjax(type, name, icon) {
		$('.there-is-no-options').fadeOut('slow');
		rand = makeid(9);
		option_rand = makeid(9);
		option_rand_2 = makeid(9);
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
		$('#fields_list').append(`
			<div class="field-section" data-type="text">
				<input name="fields[`+rand+`][type]" class="btn btn-primary" type="hidden" value="`+type+`">
				<input name="fields[`+rand+`][sort]" class="btn btn-primary sort" type="hidden" value="`+next_sort+`">
				<div class="row field-row-header">
					<div class="col-md-6 col-xs-6 field-label-col">
						<span class="label label-info field-label label-info-light">
							<i class="`+icon+`"></i> &nbsp; ` + name + `
						</span>
					</div>
					<div class="col-md-6 col-xs-6 text-right field-required-col">
						<label>
							<input type="checkbox" class="check_field js-switch" checked="checked" name="fields[`+rand+`][required]">
							{{ _i('Required field') }}
						</label>
					</div>
				</div>
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
								<button type="button" class="btn btn-default bg-danger bg-danger2 remove-button" data-code='`+rand+`'>
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
								<input type="text" class="form-control" placeholder="{{ _i('Field name') }}" name="fields[`+rand+`][name]" required>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-prepend">
									<i class="ti-write"></i>
								</span>
								<input type="text" class="form-control" placeholder="{{ _i('Field description (optional)') }}" name="fields[`+rand+`][desc]">
							</div>
						</div>
					</div>
				</div>
			</div>
		`);
		if (type == 'radio' || type == 'checkbox')
		{
			$('.field-section:last-child').append(`
				<div class="field_custom_section">
					<div class="row option-container">
						<div class='col-md-1'>
							<button type="button" class="btn deleteOption btn-default remove-option-button text-danger" data-code='`+option_rand+`'>
								<i class="ti-close"></i>
							</button>
						</div>
						<div class='col-md-11'>
							<div class='row'>
								<div class='col-md-6 option-box'>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-text"></i>
											</span>
											<input type="text" class="form-control" placeholder="{{ _i('Option title') }}" value="" name="fields[`+rand+`][options][`+option_rand+`][name]" required>
										</div>
									</div>
								</div>
								<div class='col-md-6 option-box'>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-money"></i>
											</span>
											<input type="number" class="form-control" placeholder="{{ _i('Additional price') }}" value="" name="fields[`+rand+`][options][`+option_rand+`][price]" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row option-container">
						<div class='col-md-1'>
							<button type="button" class="btn deleteOption btn-default remove-option-button text-danger" data-code='`+option_rand_2+`'>
								<i class="ti-close"></i>
							</button>
						</div>
						<div class='col-md-11'>
							<div class='row'>
								<div class='col-md-6 option-box'>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-text"></i>
											</span>
											<input type="text"  class="form-control" placeholder="{{ _i('Option title') }}" value="" name="fields[`+rand+`][options][`+option_rand_2+`][name]" required>
										</div>
									</div>
								</div>
								<div class='col-md-6 option-box'>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-prepend">
												<i class="ti-money"></i>
											</span>
											<input type="number" class="form-control" placeholder="{{ _i('Additional price') }}" value="" name="fields[`+rand+`][options][`+option_rand_2+`][price]" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row add-option-container">
						<div class="col-md-12">
							<button type="button" class="btn btn-tiffany add_option" data-main-id='`+rand+`'>
								{{ _i('Add Option') }}
							</button>
						</div>
					</div>
					</div>
				</div>
			`);
		}
		var elem = Array.prototype.slice.call(document.querySelectorAll('.field-section:last-child .js-switch'));
		elem.forEach(function (html) {
			var switchery = new Switchery(html, {
				color: '#e22525',
				jackColor: '#fff',
				size: 'small'
			});
		});
	}

	$(document).on('click', '.remove-button', function(e){
		e.preventDefault();
		console.log('Attemping to remove section');
		var $this = $(this);
		var code = $(this).data('code');

		$.ajax({
			url: "{{route('products.custom.fields.destroy')}}",
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

	$(document).on('click', '.up-button', function(e){
		e.preventDefault();
		console.log('Attemping to up button');
		var current = $(this).parents('.field-section');
		var previous = current.prev('.field-section');
		$(current).insertBefore(previous);

		var cpos = $(current).find(".sort").val();
		cpos = parseInt(cpos);

		var ppos = $(previous).find(".sort").val();
		ppos = parseInt(ppos);

		$(current).find(".sort").val(ppos);
		$(previous).find(".sort").val(cpos);

		console.log(current);
		console.log(previous);
	});

	$(document).on('click', '.down-button', function(e){
		e.preventDefault();
		console.log('Attemping to down button');
		var current = $(this).parents('.field-section');
		var next = current.next('.field-section');
		$(current).insertAfter(next);

		var cpos = $(current).find(".sort").val();
		cpos = parseInt(cpos);

		var ppos = $(next).find(".sort").val();
		ppos = parseInt(ppos);

		$(current).find(".sort").val(ppos);
		$(next).find(".sort").val(cpos);

		console.log(current);
		console.log(next);
	});

	$(document).on('click', '.remove-option-button', function(e){
		e.preventDefault();
		console.log('Attemping to delete option');
		var $this = $(this);
		var code = $(this).data('code');
		$.ajax({
			url: "{{route('products.custom.fields.options.destroy')}}",
			type: "delete",
			data: {'_token': "{{ csrf_token() }}", 'code': code},
			success: function (response) {
				if( response == 'success' )
				{
					$this.parents('.option-container').remove();
				}
			},
		});
	});

	$(document).on('click', '.add_option', function(e){
		console.log('Attemping to add option');
		rand = $(this).data('main-id');
		var option_rand = makeid(9);
		$(this).parents('.add-option-container').before(`
			<div class="row option-container">
				<div class='col-md-1'>
					<button type="button" class="btn deleteOption btn-default remove-option-button text-danger" data-code='`+option_rand+`'>
						<i class="ti-close"></i>
					</button>
				</div>
				<div class='col-md-11'>
					<div class='row'>
						<div class='col-md-6 option-box'>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-prepend">
										<i class="ti-text"></i>
									</span>
									<input type="text" class="form-control" placeholder="{{ _i('Option title') }}" value="" name="fields[`+rand+`][options][`+option_rand+`][name]">
								</div>
							</div>
						</div>
						<div class='col-md-6 option-box'>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-prepend">
										<i class="ti-money"></i>
									</span>
									<input type="text" class="form-control" placeholder="{{ _i('Additional price') }}" value="" name="fields[`+rand+`][options][`+option_rand+`][price]">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		`);
	});

	$('#custom-fields-form').submit(function(e){
		e.preventDefault();
		console.log('Attempting to submit form');
		$.ajax({
			url: "{{route('products.custom.fields.store')}}",
			type: "post",
			data: new FormData(this),
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				if( response.status == 'error' )
				{
					Swal.fire({
						icon: 'error',
						position: 'center',
						title: "{{ _i('Error !') }}",
						showConfirmButton: false,
						timer: 5000
					})
				}
				else
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
	})
</script>
@endpush
