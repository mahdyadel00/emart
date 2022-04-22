<div class="tab-pane active" id="productDetail">
	<form method="post" id="form-details">
		@csrf
		<div id="product-details">
			<input type="hidden" name="id" class="product_id" value="">
			<div class="row">
				{{--<div class="col-md-12">--}}
					{{--<div class="form-group">--}}
						{{--<div class="input-group mb-3">--}}
							{{--<span class="input-group-prepend">--}}
								{{--<i class="ti-car"></i>--}}
							{{--</span>--}}
							{{--<select class="form-control" name="delivary" id="delivary">--}}
								{{--<option class="option" value="">{{_i('Does delivery require?')}}</option>--}}
{{--								<option class="option" value="0">{{_i('No delivery required')}}</option>--}}
								{{--<option class="option" value="1">{{_i('Requires delivery')}}</option>--}}
							{{--</select>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group is-free-shipping-div"  >
						<div class="input-group mb-3">
							<span class="input-group-prepend">
								<i class="ti-car"></i>
							</span>
							<select class="form-control" name="is_free_shipping" id="is_free_shipping">
								<option class="option" value="">{{_i('Select Shipping')}}</option>
								<option class="option" value="0">{{_i('Paid Shipping')}}</option>
								<option class="option" value="1">{{_i('Free Shipping')}}</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend">
								<i class="ti-truck"></i>
							</span>
							<input type="text" class="form-control" id="weight" placeholder="{{_i('weight')}}" name="weight" data-toggle="tooltip" data-placement="top" title="{{ _i('weight') }}">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('weight') }}">
								<i class="ti-car"></i>
							</span>
							<select class="form-control" name="weight_unit" id="weight_unit">
								<option class="option" value="g">{{_i('Gram')}}</option>
								<option class="option" value="kg">{{_i('Kilogram')}}</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('sku') }}">
								<i class="ti-receipt"></i>
							</span>
							<input type="text" class="form-control" placeholder="{{_i('sku')}}" name="sku" id="sku" data-toggle="tooltip" data-placement="top" title="{{ _i('sku') }}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('Created at') }}">
								<i class="ti-calendar"></i>
							</span>
							<input type="text" class="form-control datepicker" name="created_at" id="created_at" data-toggle="tooltip" data-placement="top" title="{{ _i('Created at') }}">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('price') }}">
								<i class="ti-money"></i>
							</span>
							<input type="number" step="0.1" min="0.1" class="form-control" placeholder="{{_i('price')}}" name="price" id="price" data-toggle="tooltip" data-placement="top" title="{{ _i('price') }}">
							<span class="input-group-append">
								{{ \App\Bll\Utility::get_default_currency(true)->code }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('Cost') }}">
								<i class="ti-receipt"></i>
							</span>
							<input type="number" step="0.1" min="0.1" class="form-control" placeholder="{{_i('Cost')}}" name="cost" id="cost" data-toggle="tooltip" data-placement="top" title="{{ _i('Cost') }}" required>
							<span class="input-group-append">
								{{ \App\Bll\Utility::get_default_currency(true)->code }}
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('Discount') }}">
								<i class="">%</i>
							</span>
							<input type="number" min="0.5" step="0.5" class="form-control" placeholder="{{_i('discount')}}" name="discount" id="discount" data-toggle="tooltip" data-placement="top" title="{{ _i('Discount') }}">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('Select Brand Name') }}">
								<i class="ti-car"></i>
							</span>
							<select class="form-control selectpicker"  name="brand" id="brand" data-toggle="tooltip" data-placement="top" data-live-search="true" title="{{ _i('Select Brand Name') }}">
{{--								<option class="option" >{{_i('Select Brand Name')}}</option>--}}
								@foreach($brands AS $brand)
								<option value='{{ $brand->id }}'>{{ $brand->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('Country of origin') }}">
								<i class="ti-car"></i>
							</span>
							<select class="form-control selectpicker" name="country_of_origin" id="country_of_origin" data-toggle="tooltip" data-placement="top" title="{{ _i('Country of origin') }}" data-live-search="true" >
{{--								<option class="option" >{{_i('Country of origin')}}</option>--}}
								@foreach($countries AS $country)
								<option value='{{ $country->country_id }}'>{{ $country->title }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group mb-3">
							<span class="input-group-prepend" data-toggle="tooltip" data-placement="top" title="{{ _i('The number of points awarded when purchasing the product') }}">
								<i class="ti-bolt-alt"></i>
							</span>
							<input type="number" step="1" min="1" class="form-control" placeholder="{{_i('The number of points awarded when purchasing the product')}}" name="points" id="points" data-toggle="tooltip" data-placement="top" title="{{ _i('The number of points awarded when purchasing the product') }}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<input type="number" name="refrence"  id="refrence" class="form-control" placeholder="{{ _i('Reference number') }}"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="description"  id="description" class="form-control" placeholder="{{ _i('information')  }}"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="text" id="text" class="ckeditor form-control"></textarea>
					</div>
				</div>
			</div>


			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('close')}}</button>
				<button class="btn btn-tiffany save" type="submit">{{_i('save')}}</button>
			</div>
		</div>
	</form>
</div>
