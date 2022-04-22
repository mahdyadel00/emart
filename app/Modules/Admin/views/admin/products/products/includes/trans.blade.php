<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_create" id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
                </div>
                <div class="modal-body">
                    <form  action="{{route('Product_lang_store')}}" method="post" class="form-horizontal"  id="lang_submit_prod" data-parsley-validate="">

                        {{method_field('post')}}
                        {{csrf_field()}}

                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >

                        <div class="box-body">
                            <!----============================== title =============================-->
                            <div class="form-group row">
                                <label for="" class="col-sm-2 control-label "> {{_i('Title')}} </label>

                                <div class="col-md-10">
                                    <input type="hidden" name="lang_id_data" id="langId">
                                    <input type="hidden" name="id" id="productId">
                                    <input type="text"  placeholder="{{_i('title')}}" name="title"  value=""
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" required="" id="titletrans" >
                                </div>
                            </div>
                            <!----============================== content =============================-->
                            <div class="form-group row">
                                <label for="address" class="col-sm-2 control-label"> {{_i('Specifications')}} </label>

                                <div class="col-sm-10">
                                    <textarea id="editor1"  placeholder="{{_i('Specifications')}}" class="form-control editor1" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="information" class="col-sm-2 control-label"> {{_i('Description')}} </label>
                                <div class="col-sm-10">
                                    <textarea name="information"  id="information" class="form-control" placeholder="{{ _i('Description')  }}"></textarea>
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
@push("js")
    <script>
        $(document).on('click', '.lang_ex', function (e){
            let lang = $(this).data('lang')
            let id = $(this).data('id')
            $('#langId').val(lang)
            $('#productId').val(id)
        })
        $(document).on('submit', '#lang_submit_prod', function (e){
            e.preventDefault()
            let url = $(this).attr('action')

            $.ajax({
                url: url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.errors){
                        $('#masages_model').empty();
                        $.each(response.errors, function( index, value ) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response.status === 'SUCCESS'){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show()
                        $('#product_name').val(response.title)
                        $('.modal.modal_create').modal('hide');
                    }
                }
            })
        })
    </script>
@endpush
<!--------------------------------- modal trans end ------------------------------->
