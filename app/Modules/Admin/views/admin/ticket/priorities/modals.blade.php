<div class="modal modal_create fade" id="create-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Create New Priority')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_add" class="form-horizontal" action="{{route('ticket.priority.store')}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					<div class="box-body">
						<div class="form-group" >
							<label class="control-label"><?=_i('Language')?> </label>
							<select class="form-control" name="lang_id" id="lang_add">
								@foreach($languages as $lang)
									<option value="{{$lang->id}}">{{$lang->title}}
									</option>
								@endforeach
							</select>
						</div>
						<div class="form-group" >
							<label class="control-label"><?=_i('Name')?> <span style="color: #F00;">*</span></label>
							<input type="text" class="form-control name" name="name" required="" placeholder="{{_i('Place Enter Priority Name')}}">
						</div>
						<!-- ================================== title =================================== -->
						<div class="form-group">
							<label class="control-label"><?=_i('Color')?></label>
							<input type="color" class="form-control color" name="color" placeholder="{{_i('Place Enter Priority Color')}}">
						</div>
						<div class="form-group">
							<label class="control-label"><?=_i('Display Order')?></label>
							<input type="text" class="form-control display_order" name="display_order" placeholder="{{_i('Place Enter Priority Order')}}">
						</div>
						<div class="form-group">
							<label class="control-label" for="txtUser">{{_i('Description')}} </label>
							<textarea  class="form-control description_add" name="description" placeholder="{{_i('Place write description here...')}}"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
						</button>
						<button class="btn btn-info" type="submit"> {{_i('Save')}} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
	<script>
		$(function() {
			$('#form_add').submit(function(e) {
				e.preventDefault();
				var action = $(this).attr('action');
				$.ajax({
					url: action,
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							$('#masages_model').empty();
							$.each(response.errors, function(index, value) {
								$('#masages_model').show();
								$('#masages_model').append(value + "<br>");
							});
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							window.LaravelDataTables["dataTableBuilder"].ajax.reload();
							$('#lang_add').val("");
							$('#title_add').val("");
							$('#link_add').val("");
							$('#image_add').val("");
							$('#checkbox').val("");
							$('#description_add').val("");
						}
					}
				});
			});
		});
	</script>
@endpush
<div class="modal modal_edit fade" id="edit-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Edit Priority')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="edit-form" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="box-body">
						<div class="form-group">
							<label class="control-label"><?=_i('Color')?></label>
							<input type="color" id="color" class="form-control" name="color" placeholder="{{_i('Place Enter Priority Color')}}">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label"><?=_i('Display Order')?></label>
						<input type="text" class="form-control display_order" name="display_order" id="display_order" placeholder="{{_i('Place Enter Priority Order')}}">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
						</button>
						<button class="btn btn-info" type="submit" id="edit-form"> {{_i('Save')}} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
	<script>
		var url;
		$('body').on('click', '.edit', function (e) {
			e.preventDefault();
			var id = $(this).data('id');
			var lang_id = $(this).data('lang_id');
			var name = $(this).data('name');
			var description = $(this).data('description');
			var color = $(this).data('color');
			var display_order = $(this).data('display_order');
			url = $(this).data('url');

			$('#edit-modal #id').val(id);
			$('#edit-modal #lang_id').val(lang_id);
			$('#edit-modal #name').val(name);
			$('#edit-modal #description').val(description);
			$('#edit-modal #color').val(color);
			$('#edit-modal #display_order').val(display_order);
		});

		function showImg(input) {
			var filereader = new FileReader();
			filereader.onload = (e) => {
				console.log(e);
				$("#old_img").attr('src', e.target.result).width(100).height(100);
			};
			console.log(input.files);
			filereader.readAsDataURL(input.files[0]);
		}

		$(function() {
			$('#edit-form').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: url,
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_edit').modal('hide');
							window.LaravelDataTables["dataTableBuilder"].ajax.reload();
						}
					}
				});
			});
		});
	</script>
@endpush
<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
	<div class="modal-dialog" role="document">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form  action="{{route('ticket.priority.store_translation')}}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
						@csrf

						<input type="hidden" name="id" id="id_data" value="">
						<input type="hidden" name="lang_id_data" id="lang_id_data" value="" >

						<div class="box-body">
							<!----============================== title =============================-->
							<div class="form-group row">
								<label for="name" class="col-sm-2 control-label"> <?=_i('Name')?> <span style="color: #F00;">*</span> </label>

								<div class="col-sm-10">
									<input type="text" id="name" class="form-control" name="name" required="" placeholder="{{_i('Place Enter Priority Name')}}">
								</div>
							</div>
							<!----============================== content =============================-->
							<div class="form-group row">
								<label for="description" class="col-sm-2 control-label"> {{_i('description')}} </label>

								<div class="col-sm-10">
									<textarea id="description" class="form-control editor1" name="description" placeholder="{{_i('Place enter description here...')}}"></textarea>
								</div>
							</div>

						</div>
						<!-- /.box-body -->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
							<button type="submit" class="btn btn-primary" >
								{{_i('Save')}}
							</button>
						</div>
						<!-- /.box-footer -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>