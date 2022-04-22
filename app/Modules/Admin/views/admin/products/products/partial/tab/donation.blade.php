<div class="tab-pane" id="dontateProduct">
    <form method="post" id="donation-form" data-parsley-validate="" enctype="multipart/form-data"  >
		@csrf
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label>{{_i('The lowest amount to donate')}}</label>
					<div class="input-group">
						<span class="input-group-prepend">
							<i class="ti-money"></i>
						</span>
						<input type="number" class="form-control" placeholder="{{ _i('Min price') }}" name="min_price" required>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label>{{_i('Maximum donation amount')}}</label>
					<div class="input-group">
						<span class="input-group-prepend">
							<i class="ti-money"></i>
						</span>
						<input type="number" class="form-control" placeholder="{{ _i('Max price') }}" name="max_price" required>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>{{_i('Description')}}</label>
					<textarea class="form-control" name="description" id='editor_donate' required></textarea>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary"
		style="float: left;padding: 10px 20px;margin-top: 20px;">{{ _i('Save changes') }}</button>
	</form>
</div>

@push("js")
<script type="text/javascript">
	$(document).on('click', '.product-donation', function(e){
		e.preventDefault();
		$('#digits_list').html('');
		console.log('Attemping to load product donation');
		$.ajax({
			url: "{{route('get_donate')}}",
			type: "get",
			data: {product_id: $product_id},
			success: function (response) {
				$('#donation-form input[name=min_price]').val(response.min_price);
				$('#donation-form input[name=max_price]').val(response.max_price);
				$('#editor_donate').val(response.description);

				CKEDITOR.replace('editor_donate', {
					extraPlugins: 'colorbutton,colordialog',
					filebrowserUploadUrl: "{{asset('masterAdmin/bower_components/ckeditor/ck_upload.php')}}",
					filebrowserUploadMethod: 'form'
				});
			},
		});
	});

	$('body').on('submit', '#donation-form', function (e) {
		e.preventDefault();
		var check = checkMinValue();
		if(!check)
		{
			return;
		}
		var data = new FormData(this);
		data.append('product_id', $product_id);
		$.ajax({
			url: '{{route('post_donate')}}',
			method: "post",
			data: data,
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				if (response == 'success')
				{
					new Noty({
						type: 'success',
						text: "{{ _i('Updated successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
				}
				else if (response == 'error')
				{
					new Noty({
						type: 'error',
						text: "{{ _i('Error !')}}",
						timeout: 2000,
						killer: true
					}).show();
				}
			},
		});
	});

	function checkMinValue(){
		var max = $("#max_value").val();
		var min = $("#min_value").val();
		if (parseFloat(min) > parseFloat(max)) {
			$('#min_price_error').show();
			$("#min_value").val('');
			return false;
		}else{
			$('#min_price_error').hide();
			return true ;
		}
	}
</script>
@endpush
