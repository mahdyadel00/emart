<div id="detailProduct" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Product Labels') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <span id="pro_id"></span>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-3">
                        <form method="post" id="insertDetail" data-parsley-validate="">
                            @csrf
                            <div class="form-group">
                                <label for="new-label">{{ _i('Add New Label') }}</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="new_label" id="new-label"
                                        placeholder="{{ _i('Add New Label') }}" required>
                                    <span class="input-group-btn">
                                        <button type="submit" form="insertDetail" id="insertDetail-btn"
                                            class="clearplus btn btn-primary">&plus;</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4">
                        <label for="new-label">{{ _i('Add New Value') }}</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="new_value" id="new_value"
                                placeholder="{{ _i('Add New Value') }}" required>
                            <span class="input-group-btn">
                                <button id="insertVal-btn" class="clearplus btn btn-primary">&plus;</button>
                            </span>
                        </div>
                    </div>
                </div>

                <form method="post" id="saveDetail" data-parsley-validate="">
                    @csrf
                    <input type="hidden" name="row_product_id" id="row_product_id">

                    <div class="tab-content tabs row" id="divAppend">

                    </div>
                    <div class="">
                        <button type="submit" form="saveDetail" class="btn btn-primary waves-effect waves-light ml-3">
                            {{ _i('Submit') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
</div>


@push('js')
    <script type="text/javascript">
        let select1;
        let select2;

        function changeNext(obj) {
            if ($(obj).is(":checked"))
                $(obj).prev("input").attr("name", "hide_filter[][]");
            else
                $(obj).prev("input").attr("name", "filter[][]");

        }

        $(document).on('click', '#insertVal-btn', function(e) {
            // e.preventDefault();
            let value = $('#new_value').val();
            $('#new_value').val('');
            $('.selectpicker2').append(
                `
                    <option value="${value}" id="value_0">${value} </option>
                `
            );
            $('.selectpicker2').selectpicker('refresh');
        })
        $(document).ready(function() {


            $(document).on('click', '#insertDetail-btn', function(e) {
                e.preventDefault();
                let label = $('#new-label').val();
                // let value = $('#new_value').val();
                //console.log(label);

                $.ajax({
                    url: "{{ route('new.label') }}",
                    method: "post",
                    data: {
                        'label': label,
                        // 'value' :value
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.success) {

                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{ _i('Saved Successfully !') }}",
                                showConfirmButton: false,
                                timer: 5000
                            })
                            $('#new-label').val('');
                            $('.selectpicker').append(
                                `
                                    <option value="${response.label['lable_id']}">
                                        ${response.label['title']}
                                    </option>
                                `
                            );


                            $('.selectpicker').selectpicker('refresh');

                        } else if (response.error) {
                            Swal.fire({
                                position: 'top-end',
                                type: 'error',
                                title: "{{ _i('Error') }}",
                                showConfirmButton: false,
                                timer: 5000
                            })
                        }

                    }
                });
            });

            $(document).on('click', '.detaPro', function() {
                var id = $(this).attr('data-id');
                var url = "{{ route('get_detail', 'id') }}";
                url = url.replace('id', id);
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {

                        if (res) {
                            $('#divAppend').empty()
                            $('#divAppend').html(res)
                            $('#row_product_id').val(id)
                            //$('select.select2').select2({
                            //placeholder: "{{ _i('Select an option') }}",
                            //});
                            $(".selectpicker").selectpicker('refresh');
                            $(".selectpicker2").selectpicker('refresh');
                            select1 = $('select#title_0');
                            select2 = $('select#detail_0');
                            // console.log(select1, select2);

                        }


                    },

                })
            });

            var max_fields = 10; //maximum input boxes allowed
            var wrapper = $(".input_fields"); //Fields wrapper
            var x = 1; //initlal text box count
            $(document).on('click', '.plusss', function(e) {

                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    // let dd = `<select name="title[new][]" id="cloned" class="load2 selectpicker form-control selectpicker "  data-live-search="true" data-toggle='tooltip' data-placement='top'></select>`
                    // let da = `<select name="detail[new][]" id="cloned2"  class="selectpicker2 form-control  select-append2"  data-live-search="true" data-toggle='tooltip' data-placement='top' title={{ _i('Value') }} required></select>`
                    // alert("add");
                    $("#divAppend").append(
                        `
                        <div class=" row mt-3">
                            <div class="col-sm-3 title">
                                <div class="input-group cloned_${x}">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group cloned2_${x}">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="hidden" name="hide_filter[new][]" value="0">
                                        <input type="checkbox" checked="" value="1" name="filter[new][]"
                                            onchange="changeNext(this)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button"  class=" remove-tr  btn btn-danger  " ><i class="ion-minus"></i></button>
                            </div>
                        </div>
                    `);

                    select1.clone().attr('name', "title[new][]").attr('id', 'new').val('')
                        .appendTo(`.cloned_${x}`);
                    select2.clone().attr('name', "detail[new][]").attr('id', 'new').val('')
                        .appendTo(`.cloned2_${x}`);
                    $(".selectpicker").selectpicker('refresh');
                    $(".selectpicker2").selectpicker('refresh');
                    // console.log($('#title_0'));
                }



            });
        });
        $(document).on('click', '.remove-tr', function() {

            var id = $(this).data('id');
            var product_id = $(this).data('product_id');
            if (id != null) {
                var url = "{{ route('delete_detail') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        product_id: product_id
                    },
                    success: function(data) {
                        if (data == 'success')
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{ _i('Deleted Successfully !') }}",
                                showConfirmButton: false,
                                timer: 5000
                            })

                    }
                })
            }
            $(this).parent('div').parent().remove();
        });

        $(document).on('submit', '#saveDetail', function(e) {

            e.preventDefault();

            var id = $("#row_product_id").val();

            var url = "{{ route('save_detail') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {

                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "{{ _i('Saved Successfully !') }}",
                        showConfirmButton: false,
                        timer: 5000
                    })

                },
                error: function(res) {

                    Swal.fire({
                        icon: 'error',
                        title: '{{ _i('Error') }}',
                        html: '{{ _i('Please complete all required fields') }}',
                    });

                },
            })

        });
    </script>
      
@endpush
