
<div id="TranslateFeature" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                <h4 class="modal-title" id="custom-width-modalLabel">{{_i('Translate Feature')}}</h4>
                <span id="pro_id"></span>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mb-3 divAppend">

                  </div>

            </div>

        </div>
    </div>
</div>


@push('js')
    <script>

        $(document).on('click', '.TransFeature', function() {
            var id = $(this).attr('data-id');
            var url = '{{route('get_translate_feature','id')}}';
            url = url.replace('id',id);
            $.ajax({
                url:url,
                type:'post',
                data:{id:id},
                dataType: 'json',
                success:function (res) {
                    if (res){
                        $('.divAppend').empty()
                        $('.divAppend').html(res)
                        // $('#row_product_id').val(id)
                    }
                },

            })
        });


        $(document).on('submit', 'form[name=saveTranslate]', function (e) {
            e.preventDefault()
            var form = $(this)

            var option_data_id = form.find("input[name='option_data_id']").val();
            var option_data_type = form.find("input[name='option_data_type']").val();
            var translate = form.find("input[name='translate']").val();
            var url = '{{route('saveTranslateFeature')}}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {'_token': '{{csrf_token()}}' , option_data_id:option_data_id ,option_data_type:option_data_type,translate:translate},
                dataType: 'json',
                success: function (res) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "{{_i('update Successfully')}}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                },

            })
        })

        $('.translate').keypress(function (e) {
            if (e.which == 13) {
                $('form[name=saveTranslate]').submit();
            }
        });


        $(document).on('submit', 'form[name=saveTranslateFeatureType]', function (e) {
            e.preventDefault()
            var form = $(this)

            var id = form.find("input[name='id']").val();
            var translateType = form.find("input[name='translateType']").val();
            var url = '{{route('saveTranslateFeatureType')}}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {'_token': '{{csrf_token()}}' , id:id ,translateType:translateType},
                dataType: 'json',
                success: function (res) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "{{_i('update Successfully')}}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                },

            })
        })


    </script>
@endpush
