<div class="modal modal_create fade" id="modal-in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Change Stock')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add" class="form-horizontal" action="{{url('admin/stock/change')}}" method="POST"
                      data-parsley-validate="" enctype="multipart/form-data">
                    {{method_field('post')}}
                    {{csrf_field()}}
                    <div class="box-body">
						<div class="form-group row" >
							<label class=" col-sm-2 col-form-label"><?=_i('product')?> </label>
							<div class="col-sm-10">
								<select class="form-control selectpicker" name="product_id" id="lang_add" data-live-search='true'>
									<option selected disabled><?=_i('CHOOSE')?></option>
									@foreach($products as $product)
									<option value="{{$product->id}}"
									<?=old('product') == $product->id ? 'selected' : ''?>>
										{{$product->id}} - {{$product->title}}
									</option>
									@endforeach
								</select>
							</div>
						</div>
                        <div class="form-group row" >
                            <label class=" col-sm-2 col-form-label"><?=_i('Quantity')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="title_add" class="form-control" name="quantity" >
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class=" col-sm-2 col-form-label"><?=_i('Details')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <textarea id="description_add" class="form-control" name="details"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
				</button>
				<button class="btn btn-info" type="submit" id="s_form_1" form='form_add'> {{_i('Save')}} </button>
			</div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/stocks/change')}}",
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
                            table.ajax.reload();
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
