<div class="form-group row new_option new_option_color">
	<div class="col-md-2">
		<div class="input-group mb-1">
			<span class="input-group-prepend">
				<i class="ti-tag"></i>
			</span>
			<input  type="color" data-color="color" class="form-control feature_option_title colorpicker"
					 placeholder="{{ _i('Option') }}" name="feature_option_color"
					value="null">
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group mb-1">
			<span class="input-group-prepend">
				<i class="ti-tag"></i>
			</span>
			<input  type="text" data-color="color" class="form-control feature_option_title feature_option_name"  placeholder="{{ _i('Name') }}" name="feature_option_color_name" required=""/>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group mb-1">
			<span class="input-group-prepend">
				<i class="ti-money"></i>
			</span>
			<input  type="text" data-color="color" min="0.1" step="0.1" class="form-control feature_option_price"
					placeholder="{{ _i('Additional Price') }}" name="feature_option_color_price" value="">
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group mb-1">
			<span class="input-group-prepend">
				<i class="ti-home"></i>
			</span>
			<input  type="number" data-color="color" required=""  data-id class="form-control feature_option_count"
					placeholder="{{ _i('Available Quantity') }}" min="1" name="feature_option_color_quantity" value="">

		</div>
	</div>
	<div class="col-md-8">
		<div class="input-group mb-8">
				<span class="input-group-prepend">
					<i class="ti ti-export "> </i>
				</span>
			<input  type="file" id="file2" data-color="color"  class="form-control feature_option_count col-md-6"  name="feature_option_color_image" >

				<button type="submit" data-type="color" class="btn btn-primary btn-sm  " id="saveFeature"
            >{{ _i('save') }}</button>
		</div>
	</div>
</div>
<input type="hidden" name="feature_id" value="">
<div class="new_option_one"></div>
