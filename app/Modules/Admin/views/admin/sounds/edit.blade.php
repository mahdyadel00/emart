<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Edit Sound Track')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="sound_id" name="sound_id">
						<div class="form-group row" >
							<label class="col-sm-4 col-form-label"><?=_i('Sound Track')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="file" id="name" class="form-control" name="sound" placeholder="{{_i('Place Enter Sound Track')}}">
								<span class="text-danger">
									<strong id="name-error"></strong>
								</span>
							</div>
						</div>

						<div class="form-group row" >
							<label class="col-sm-4 col-form-label"><?=_i('Order')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="number" id="order" min="1" class="form-control" name="order" required="" placeholder="{{_i('Place Enter Sound Order')}}">
								<span class="text-danger">
									<strong id="code-error"></strong>
								</span>
							</div>
						</div>


                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="checkboxx">
                                {{_i('Publish')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox"  id="checkboxx" name="published" value="1">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i> </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
                        </button>
                        <button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('body').on('click', '.edit', function (e) {
            e.preventDefault();
            var sound_id = $(this).data('id');
            var published = $(this).data('published');
            var order = $(this).data('order');

            $('.modal_edit #sound_id').val(sound_id);
            $('.modal_edit #order').val(order);
            if(published == 1){
                $('.modal_edit #checkboxx').prop('checked',true);
            }
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/sounds/update')}}",
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
                            $('#dataTable').DataTable().draw(false);
                        }
                    }
                });
            });
        });
    </script>
@endpush
