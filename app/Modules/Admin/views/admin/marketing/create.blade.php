@extends('admin.layout.index',
[
	'title' => _i('Add New Campaign'),
	'subtitle' => _i('Add New Campaign'),
	'activePageName' => _i('Add New Campaign'),
	'activePageUrl' => route('campaign.create'),
	'additionalPageName' => _i('Marketing campaigns'),
	'additionalPageUrl' => route('campaign.index')
])

@section('content')

	@push('css')
		<style>
			.modal-header {
				background-color: #5cd5c4;
				border-color: #5cd5c4;
				color: #fff;
			}
			#message_preview.to ,#message_preview a {
				color: #fff;
				background-color: #5dd5c4;
				text-align: left ;
			}
			#message_preview.message {
				box-sizing: border-box;
				padding: 8px 20px;
				min-width: 200px;
				max-width: 500px;
				min-height: 40px;
				margin: 5px 10px;
				border-radius: 15px;
				position: relative;
				clear: both;
				font-size: 14px;
				word-wrap: break-word;
			}

			#message_preview.to::before {
				content: '';
				border: solid 10px;
				border-color: transparent transparent #5dd5c4;
				position: absolute;
				float: right;
				right: -7px;
				bottom: 2px;
			}
		</style>
	@endpush
	<div class="page-body">
		<form  action="{{ url('admin/campaign/store')}}" method="POST" class="form-horizontal" data-parsley-validate="" >
			@csrf
			<div class="row">
				<div class="col-sm-12 ">
					<div class="card">
						<div class="card-header">
							<h5> <i class="icofont icofont-social-telegram"></i> {{ _i('Marketing campaign') }}  </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="form-group row ">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group ">
											<input type="text" id="campaign_name_" class="form-control " name="campaign_name" placeholder="{{_i('Campaign Name')}}" required="">
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											<i class="icofont icofont-font"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group">
											<textarea class="form-control campaign-textarea" id="content" name="message"
													  placeholder="{{_i('The text of the message')}}"></textarea>
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											 <i class="icofont icofont-chat"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div class="form-group row ">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group ">
											<select class="form-control"  name="link_type" required="" id="link_type">
												<option selected disabled>{{_i('Select Link')}}</option>
												{{-- <option value="store">{{_i('Store Link')}}</option> --}}
												<option value="product">{{_i('Product Link')}}</option>
												<option value="category">{{_i('Category Link')}}</option>
												{{-- <option value="offers">{{_i('Discounts Link')}}</option> --}}
											</select>
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											<i class="icofont icofont-link-alt"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>

								<input type="hidden" id="link_id" name="link_id" value="" />
								<input type="hidden" id="link_text" name="link_text" value="" />
								<div class="form-group row  url_product" style="display: none">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group ">
											<select class="form-control "  name="url_item" id="searchbox_product" >
												<option selected disabled>{{_i('Select Product')}}</option>
												@foreach($products as $product)
													<option value="{{$product['prod_id']}}">{{$product['title']}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div class="form-group row  url_category" style="display: none">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group ">
											<select class="form-control "  name="url_item" id="searchbox_category">
												<option selected disabled>{{_i('Select Category')}}</option>
												@foreach($categories as $category)
													<option value="{{$category['id']}}">{{$category['title']}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div class="content-divider text-muted">
									<span><i class="ti ti-eye"></i> {{_i('Message preview')}}</span>
								</div>
								<div class="form-group row " >
									<div class="col-sm-1"></div>
									<p id="message_preview" class="message to" >
										<br>
									</p>
									<div class="typing-indicator">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 ">
					<div class="card">
						<div class="card-header">
							<h5> <i class="icofont icofont-pie"></i> {{ _i('Target segment') }}  </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="form-group row ">
									<div class="col-sm-1"></div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-primary " id="add_condition"  data-toggle="modal" data-target="#sign-in-modal">
											<i class="ti-plus"></i>{{_i('Add Condition')}}
										</button>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div id="get_filter_users">
								</div>
								<div class="form-group row">
									<div class="col-sm-1"></div>
									<div class="col-sm-3">
										<div class="checkbox-fade fade-in-primary">
											<label>
												<input id="apply_all_conditions" type="checkbox" value="1"  name="apply_all_conditions" >
												<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span> {{ _i('All conditions apply') }}
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 ">
					<div class="card">
						<div class="card-header">
							<h5> <i class="icofont icofont-brand-target"></i> {{ _i('Campaign goal') }}  </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="form-group row ">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="input-group ">
											<select class="form-control campaign_goal"  name="campaign_target" required="">
												<option selected disabled>{{_i('Choose Goal')}}</option>
												<option value="store">{{_i('Buy from the store')}}</option>
												<option value="product">{{_i('Buy a specific product')}}</option>
											</select>
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											<i class="icofont icofont-flag"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<div class="form-group row campaign_goal_product " style="display: none">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
											<select class="form-control " name="campaign_target_value">
												<option selected disabled>{{_i('Select Product')}}</option>
												@foreach($products as $product)
												<option value="{{$product['prod_id']}}">{{$product['title']}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="row">
				<div class="col-sm-12 ">
					<div class="card">
						<div class="card-header">
							<h5> <i class="icofont icofont-ui-alarm"></i> {{ _i('Campaign scheduling') }}  </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="form-group row ">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="form-radio ">
												<div class="radio radio-inline ">
													<label>
														<input type="radio" class="publish_type" name="campaign_type_time" value="now" checked="checked">
														<i class="helper"></i> {{_i('Now')}}
													</label>
												</div>
												<div class="radio radio-inline">
													<label>
														<input type="radio" class="publish_type" name="campaign_type_time" value="future">
														<i class="helper"></i> {{_i('Determine the publication time')}}
													</label>
												</div>
										</div>
									</div>
									<div class="col-sm-1"></div>
								</div>
								<!----  date & time ----->
								<div class="form-group row  dateTime" style="display: none">
									<div class="col-sm-1"></div>
									<div class="col-sm-5">
										<div class="input-group ">
											<input type="time" class="form-control" name="campaign_time">
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											<i class="icofont icofont-clock-time"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="input-group ">
											<input type="date" id="date" name="campaign_date" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" placeholder="{{_i('campaign date')}}" >
											<span class="input-group-addon input-group-addon-small" id="basic-addon5">
											<i class="icofont icofont-ui-calendar"></i>
										</span>
										</div>
									</div>
								</div>
								<div class="col-sm-1"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" id="draft_value" name="is_draft" value="" >
			<div class="row">
				<div class=" col-sm-12 text-center " >
					<button type="submit"  class="btn btn-primary  btn-round col-sm-3"><i class="icofont icofont-check"></i> {{_i('Create Campaign')}}</button>
					<button id="draft" type="submit"  class="btn btn-default  btn-round col-sm-3 pull-right "><i class="icofont icofont-ui-folder"></i> {{_i('Save as draft')}}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade modal_create" id="sign-in-modal" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header" >
					<h5 class="modal-title">{{_i('Campaign Conditions')}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="save_filter_row" method="POST">
					@csrf
					<div class="modal-body p-b-0">
						<div class="form-group row ">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_code" id="filter_conditions">
										<option selected disabled>{{_i('Choose Condition')}}</option>
										<option value="gender" id="gender">{{_i('Gender')}}</option>
										<option value="country">{{_i('Country')}}</option>
										<option value="city">{{_i('City')}}</option>
										<option value="buy_from_store">{{_i('Buy from Store')}}</option>
										<option value="buy_store_more_once">{{_i('Buy from the store more than once')}}</option>
										<option value="interest_specific_classification">{{_i('Interested in a specific classification')}}</option>
										<option value="buy_specific_product">{{_i('Buy a specific product')}}</option>
										<option value="add_product_basket_not_buy">{{_i('Added a product to the basket and did not purchase it')}}</option>
										<option value="add_product_to_wishlist">{{_i('Added a product to wishlist')}}</option>
										<option value="never_buy_from_store">{{_i('Never buy from the store')}}</option>
									</select>
									<span class="input-group-addon input-group-addon-small" id="basic-addon5">
										<i class="icofont icofont-filter"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group row gender_selected" style="display: none;">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_gender" >
										<option value="male">{{_i('Male')}}</option>
										<option value="female">{{_i('Female')}}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row country_selected" style="display: none;">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_country">
										@foreach($countries as $country)
											<option value="{{$country['id']}}">{{$country['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row city_selected" style="display: none;">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_city">
										@foreach($cities as $city)
											<option value="{{$city['id']}}">{{$city['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row product_selected" style="display: none;">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_buy_specific_product">
										<option selected disabled>{{_i('Select Product')}}</option>
										@foreach($products as $product)
											<option value="{{$product['prod_id']}}">{{$product['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row category_selected" style="display: none;">
							<div class="col-sm-12">
								<div class="input-group ">
									<select class="form-control " name="marketingUser_interest_specific_classification">
										<option selected disabled>{{_i('Select Category')}}</option>
										@foreach($categories as $category)
											<option value="{{$category['id']}}">{{$category['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
				</div>
				</form>
			</div>
		</div>
	</div>

@endsection
@push('js')
	<script>
		var customers_count = 1634 ;
		var sms_balance = 100 ;
		var _STORE_URL = `{{$domain}}`;
		var tracking_link = `{{$domain}}`;

		$('#content').bind('input propertychange', function () {
			var link_type = $('#link_type').val();
			checkSMSData(link_type)
		});

		$('body').on('change' , '#link_type' , function(){
			var link_type = $(this).val();
			// selected url type
			if (link_type == "product"){
				$('.url_product').show();
				$('.url_category').hide();
			}
			else if (link_type == "category"){
				$('.url_category').show();
				$('.url_product').hide();
			}else{
				$('.url_category').hide();
				$('.url_product').hide();
			}

			checkSMSData(link_type)
		});


		function nl2br(str, is_xhtml) {
			var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
			return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
		}


		function checkSMSData(type) {
			var link = null;
			if (type == "product") {
				if ($('#link_id').val()) {
					link = _STORE_URL + "/{{ app()->getLocale() }}/product/" + $('#link_id').val();
				}
			} else if (type == "category") {
				if ($('#link_id').val()) {
					link = _STORE_URL + "/{{ app()->getLocale() }}/category/" + $('#link_id').val();
				}
			} else if (type == "offers") {
				link = _STORE_URL + "/offer";
			} else if (type == "store") {
				link = _STORE_URL + "/home" ;
			} else {
				link = null;
			}

			var content = $('#content').val();
			var _content = content;

			if (link) {
				content = content + "\n" + "<a  href='" + link + "' target='_blank' > " + link + "</a>";
				_content = _content + "\n" + tracking_link;
			}

			if (content) {
				$(".typing-indicator").hide();
				$('#message_preview').html(nl2br(content));
			} else {
				$('#message_preview').html(null);
				$(".typing-indicator").show();
			}

		   //var sms_count = smsCounter(_content);
			var sms_count = _content;

			var required_sms_count = customers_count * sms_count;
			var new_sms_balance = sms_balance - required_sms_count;
			$('#required_sms_count_span').text(required_sms_count);
		}

		$('body').on('change','#searchbox_product',function () {
			var productId = $(this).val();
			$('#link_text').val(productId);
			$('#link_id').val(productId);
			$('.link_type_span').text('');
			checkSMSData('product');
		});

		$('#searchbox_category').on('change', function () {
			$('#link_id').val($(this).val());
			$('.link_type_span').text('');
			checkSMSData('category');
		});

$('body').on('change' , '#filter_conditions' , function() {
	var filter_type = $(this).val();
	if(filter_type == "gender"){
		$('.gender_selected').show();
		$('.category_selected').hide();
		$('.product_selected').hide();
		$('.country_selected').hide();
		$('.city_selected').hide();
	}else if(filter_type == "country"){
		$('.country_selected').show();
		$('.category_selected').hide();
		$('.product_selected').hide();
		$('.gender_selected').hide();
		$('.city_selected').hide();
	}else if(filter_type == "city"){
		$('.city_selected').show();
		$('.category_selected').hide();
		$('.product_selected').hide();
		$('.gender_selected').hide();
		$('.country_selected').hide();
	}else if(filter_type == "buy_specific_product"){
		$('.product_selected').show();
		$('.category_selected').hide();
		$('.gender_selected').hide();
		$('.country_selected').hide();
		$('.city_selected').hide();
	}else if(filter_type == "interest_specific_classification"){
		$('.category_selected').show();
		$('.product_selected').hide();
		$('.gender_selected').hide();
		$('.country_selected').hide();
		$('.city_selected').hide();
	}else{
		$('.category_selected').hide();
		$('.product_selected').hide();
		$('.gender_selected').hide();
		$('.country_selected').hide();
		$('.city_selected').hide();
	};
});
$(".save").unbind('click');
$('body').on('submit','#save_filter_row',function (e){
	e.preventDefault();
	$.ajax({
		url:'{{ url('admin/campaign/store_marketing_users') }}',
		data: new FormData(this),
		type:'POST',
		dataType: 'json',
		contentType: false,
		processData: false,
		success:function (res) {
			if(res) {
				$('.modal.modal_create').modal('hide');
				$('#get_filter_users').html('');
				$.each(res, function(result ,row){
					if(row.value == null){
						row.value = "";
					}
					$('#get_filter_users').append('<div class="form-group row div_delete"><div class="col-sm-1"></div> <div class="col-sm-10"><div class="alert alert-default small">'+
						'<button type="button" class="close btn-small" data-dismiss="alert" aria-label="Close">' +
						'<i class="icofont icofont-close-line-circled btn-small" onclick="delFilter('+row.id+')"></i></button> <strong> '+ row.code +" "+row.value+'</strong>' +
						' </div> </div>  <div class="col-sm-1"></div> </div>');
				});
			}
		}
	})
});

function delFilter(id) {
	$(this).closest('.div_delete').remove();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: "POST",
		url: "{{ url('admin/campaign/delete_marketing_users') }}",
		data: { rowId: id},
		success: function () {
		}
	});
}
		$('body').on('click','#gender',function () {
			$('.gender_selected').show();
		});
		$('body').on('click','#draft',function (e) {
		  $('#draft_value').val(1);
		   e.preventDefault();
		   $(this).closest("form").submit();
	   });
	$('body').on('change' , '.campaign_goal' , function(){
			var campaign_goal = $(this).val();
			if (campaign_goal == "product"){
				$('.campaign_goal_product').show();
			}else{
				$('.campaign_goal_product').hide();
			}
		});
		$('.publish_type').on("change", function () {
			var publish_type = $(this).val();
			console.log(publish_type);
			if(publish_type == "future"){
				$('.dateTime').show();
			}else{
				$('.dateTime').hide();
			}
		});
	</script>
@endpush
