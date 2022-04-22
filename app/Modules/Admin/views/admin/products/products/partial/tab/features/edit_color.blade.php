<div class="form-group row saved_option">
    <div class="col-md-2">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-tag"></i>
            </span>
            <input type="` + input_type + `" id="title-${response.data[ii].options[i].id}"
                class="form-control feature_option_title" value="${response.data[ii].options[i].title}"
                placeholder="{{ _i('Option') }}" name="title">
        </div>
    </div>
    ` + name + `
    <div class="col-md-3">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-money"></i>
            </span>
            <input type="text" id="price-${response.data[ii].options[i].id}" class="form-control feature_option_price"
                value="${option_price}" placeholder="{{ _i('Additional Price') }}" name="price">
        </div>
    </div>

    <div class="col-md-3">
        <div class="input-group mb-3">
            <span class="input-group-prepend">
                <i class="ti-home"></i>
            </span>
            <input type="text" id="quantity-${response.data[ii].options[i].id}" value="${option_quantity}"
                class="form-control feature_option_count" placeholder="{{ _i('Available Quantity') }}" name="count">

        </div>
    </div>
    <div class="col-md-6">
		<div class="input-group ">
		` + image + `
		</div>
	</div>
	<div class="col-md-6 ">
        <button type="submit" onclick="updateFeatureOptionSaved(${response.data[ii].options[i].id},this)"
            class="btn btn-warning btn-sm mr-1 ">{{ _i('Update') }}</button>
        <button type="button" class="btn btn-danger btn-sm mr-1 delete_feature_option_saved"
            onclick="deleteFeatureOptionSaved(${response.data[ii].options[i].id},this)">{{ _i('Delete') }}</button>


    </div>
</div>
