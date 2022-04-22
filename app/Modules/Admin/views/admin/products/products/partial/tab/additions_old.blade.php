<div class="tab-pane"  id="productAddition">
	<form method="post" id="form-features">
		@csrf
		<div class="product-features" id="static_feature_color">
			<input type="hidden" form="form-features" name="id" class="product_id" value="">
			<div class="form-group">
				<div class="input-group mb-3 mt-3">
					<span class="input-group-prepend">
						Name
					</span>
					
					<input type="text" form="form-features" class="form-control feature_title"  name="name">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group mb-3 mt-3 select_div">
					<span class="input-group-prepend">
						Select
					</span>
					<select name="choose[]" class="form-control choose">
						<option value="">Choose Type</option>
						<option value="text_box">Text box</option>
						<option value="text_area">Text area</option>
						<option value="number">Number</option>
						<option value="file">File</option>
						<option value="select">Select</option>
						<option value="radio">Radio</option>
						<option value="check_box">Checkbox</option>
					</select>
				</div>

			</div>
			<div class="form-group male_or_female" hidden>
				<label for="male">Male</label>
				<input id="male" type="radio" name="gender[]" value="male">
				<label for="female">Female</label>
				<input id="female" type="radio" name="gender[]" value="female">
			</div>
			<div class="form-group upload_file" hidden>
				<input type="file" name="upload_file[]" class="form-control">
			</div>
			<div class="form-group text_area" hidden>
				<textarea name="text_area" class="form-control"></textarea>
			</div>

			<div class="form-group number" hidden>
				<input type="number" name="number[]" class="form-control">
			</div>
			<div class="form-group">
				<div class="input-group mb-3 mt-3">
						not Required
					<input type="checkbox" form="form-features" class="form-control js-switch"  name="name" checked>
						Required
				</div>
			</div>
		

			<div class="new_option_one"></div>
			<button type="button" class="btn btn-tiffany mb-4 add_option">
				<i class="ti-plus"></i>
				{{ _i('Add More') }}
			</button>
			<br>
		</div>
		<div class="col-md-12"><hr></div>
		
		<div class="new_feature_one"></div>
	</form>

	<div class="form-group mt-3">
		<button class="btn btn-tiffany save" form="form-features" type="submit">{{_i('save')}}</button>
	</div>
</div>

@push('js')
<script>
	$('.choose').change(function() {

		if($(this).find(":selected").val() == 'radio') {
			$('.male_or_female').removeAttr('hidden');
			$('.upload_file').attr('hidden' , true);
			$('.number').attr('hidden' , true);
			$('.text_area').attr('hidden' , true);

		} else if($(this).find(":selected").val() == 'file') {
			$('.upload_file').removeAttr('hidden');
			$('.male_or_female').attr('hidden' , true);
			$('.number').attr('hidden' , true);
			$('.text_area').attr('hidden' , true);

		} else if($(this).find(":selected").val() == 'number') {
			$('.number').removeAttr('hidden');
			$('.upload_file').attr('hidden' , true);
			$('.male_or_female').attr('hidden' , true);
			$('.text_area').attr('hidden' , true);
		
		} else if($(this).find(":selected").val() == 'text_area') {
			$('.text_area').removeAttr('hidden');
			$('.upload_file').attr('hidden' , true);
			$('.male_or_female').attr('hidden' , true);
			$('.number').attr('hidden' , true);	

		} else if($(this).find(":selected").val() == 'select') {
			$('.select').removeAttr('hidden');
			$('.upload_file').attr('hidden' , true);
			$('.male_or_female').attr('hidden' , true);
			$('.number').attr('hidden' , true);			
		}

	});

	$('.add_option').click(function() {
	$('form').append(`<div class="product-features" id="static_feature_color">
			<input type="hidden" form="form-features" name="id" class="product_id" value="">
			<div class="form-group">
				<div class="input-group mb-3 mt-3">
					<span class="input-group-prepend">
						Name
					</span>
					
					<input type="text" form="form-features" class="form-control feature_title"  name="name">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group mb-3 mt-3 select_div">
					<span class="input-group-prepend">
						Select
					</span>
					<select name="choose[]" class="form-control choose">
						<option value="">Choose Type</option>
						<option value="text_box">Text box</option>
						<option value="area">Area</option>
						<option value="number">Number</option>
						<option value="file">File</option>
						<option value="select">Select</option>
						<option value="radio">Radio</option>
						<option value="check_box">Checkbox</option>
					</select>
				</div>

			</div>
			<div class="form-group male_or_female" hidden>
				<label for="male">Male</label>
				<input id="male" type="radio" name="gender[]" value="male">
				<label for="female">Female</label>
				<input id="female" type="radio" name="gender[]" value="female">
			</div>
			<div class="form-group upload_file" hidden>
				<input type="file" name="upload_file[]" class="form-control">
			</div>
			<div class="form-group text_area" hidden>
				<textarea name="text_area" class="form-control"></textarea>
			</div>

			<div class="form-group number" hidden>
				<input type="number" name="number[]" class="form-control">
			</div>
			<div class="form-group">
				<div class="input-group mb-3 mt-3">
						not Required
					<input type="checkbox" form="form-features" class="form-control js-switch"  name="name" checked>
						Required
				</div>
			</div>
			<div class="new_option_one"></div>
			<br>
		</div>`)



	});


</script>

@endpush
