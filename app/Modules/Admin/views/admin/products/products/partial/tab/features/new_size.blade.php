<div class="form-group row new_option new_option_size">
    <div class="col-md-4">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-tag"></i>
            </span>
            <input type="text" data-size="size" class="form-control feature_option_title"
                placeholder="{{ _i('Option') }}" required="" name="feature_option_size" value="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-money"></i>
            </span>
            <input type="text"  data-size="size" class="form-control feature_option_price"
                placeholder="{{ _i('Additional Price') }}" name="feature_option_size_price" value="">

        </div>
    </div>

    <div class="col-md-5">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-home"></i>
            </span>
            <input type="number" required="" data-size="size" class="form-control feature_option_count"
                placeholder="{{ _i('Available Quantity') }}" name="feature_option_size_quantity" min="1" value="">
				<input type="hidden" name="feature_id" value="">

				<button type="submit" class="btn btn-primary btn-sm mr-3 "  id="saveFeature">{{ _i('save') }}</button>
        </div>
    </div>

</div>
