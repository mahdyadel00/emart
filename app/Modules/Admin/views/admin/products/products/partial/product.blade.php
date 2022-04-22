<div id="allProducts_div" class="row">
    @include('admin.products.products.ajax.product_ajax')
</div>

<div class="pace-demo d-none">
    <div class="theme_tail_circle">
        <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
        <div class="pace_activity"></div>
    </div>
    <p> {{ _i('Saving') }}</p>
</div>
@push('js')
    <script type="text/javascript" src="{{ asset('AdminFlatAble/dist/clipboard.min.js') }}"></script>
    <script type="text/javascript">
        function confirmBeforeDelete(obj) {
            var confirm_delete = $(obj).data("id");
            $('#custom-width-modal [name="btn_del_product"]').first().attr("data-id", confirm_delete);
            $('#custom-width-modal').modal("show")
        }

        function hideProduct(obj) {
            let element = $(obj)
            var id = element.data('id');
            var hide = element;

            $.ajax({
                url: "{{ route('get_hidden') }}",
                method: "get",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        if (response.pro_hidden == 1) {
                            hide.html('<i class="icofont icofont-eye-blocked"></i>' +
                                "{{ _i('hide') }}");
                            ProductHide(id);
                        } else {
                            hide.html('<i class="icofont icofont-eye-alt"></i>' + "{{ _i('Show') }}");
                            var obj = hide.closest('.product-box');
                            obj.fadeIn("slow", function() {
								$(obj).removeClass("product-hidden");
                            });
                        }
                    }
                },
            });
        }

        function productdel(obj) {
            var product_id = $(obj).data("id");
            $.post('product/productdel', {
                id: product_id,
                '_token': '{{ csrf_token() }}'
            }).then((data) => {
                if (data.status == "ok") {
                    var t = $("form[name='frm_product'] input[name='product_id'][value=" + product_id + "]")
                        .parents(".product-box").parent(); //.remove()
                    $(t).fadeTo(1000, 0.01, function() {
                        $(this).slideUp(150, function() {
                            $(this).remove();
                        });
                    });
                    $('.modal').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "{{ _i('Deleted Successfully') }}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload(true);
                } else
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 2000
                    });
            })
        }

        function saveProduct(obj) {
            var form = $(obj).closest("form");
            var details = $(obj).closest("form").find(".optional-category");
            result = $(form).parsley().validate();
            if (result) {
                var product_id = form.find("input[name='product_id']").val();
                var product_name = form.find("input[name='product_name']").val();
                var product_type = form.find("select[name='types']").val();
                var product_price = form.find("input[name='price']").val();
                var product_count = form.find("input[name='count']").val();
                var product_cats = form.find("select[name='categories[]']").val();

                if (product_type == 49) {
                    var product_type_name = 'product';
                } else if (product_type == 50) {
                    var product_type_name = 'service';
                } else if (product_type == 51) {
                    var product_type_name = 'food';
                } else if (product_type == 52) {
                    var product_type_name = 'digital_product';
                } else if (product_type == 53) {
                    var product_type_name = 'cards';
                } else if (product_type == 54) {
                    var product_type_name = 'donation';
                } else if (product_type == 55) {
                    var product_type_name = 'multi_products';
                }

                details.data('code', product_type_name);
                details.attr('data-code', product_type_name);

                if (product_price == '') {
                    Swal.fire({
                        title: '{{ _i('alert') }}',
                        text: "{{ _i('Please enter product price') }}",
                        icon: 'warning',
                    });
                    return;
                }
                if (product_type == '') {
                    Swal.fire({
                        title: '{{ _i('alert') }}',
                        text: "{{ _i('Please select product type') }}",
                        icon: 'warning',
                    });
                    return;
                }

                if (product_cats.length == 0) {
                    Swal.fire({
                        title: '{{ _i('alert') }}',
                        text: "{{ _i('Please select product category') }}",
                        icon: 'warning',
                    });
                    return;
                }
                var data = $(form).serialize();
                if (product_id !== "") {
                    $('.pace-demo').removeClass('hidden');
                    $.post('updateproduct', data).then(data => {
                        if (data.success) {
                            if (data.success.id) {
                                form.find("input[name='product_id']").val(data.success.id);
                            }
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: '{{ _i('Saved Successfully') }}',
                                showConfirmButton: false,
                                timer: 5000
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.fail,
                                showConfirmButton: false,
                                timer: 5000
                            });
                        }
                        $('.pace-demo').addClass('hidden');
                    }).catch(err => {
                        $('.pace-demo').addClass('hidden');
                    });
                } else {
                    $('.pace-demo').removeClass('hidden');
                    $.post('saveproduct', data).then((data) => {
                        $(form).find("input[name='product_id']").val(data.product_id);
                        $('.pace-demo').addClass('hidden');
                        // console.log('success');
                    });
                    //  this.form.type = null;
                }
                return;
            }
        }

        var clipboard = new ClipboardJS('.get_link');

        clipboard.on('success', function(e) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ _i('Copied Url Successfully') }}',
                showConfirmButton: false,
                timer: 5000
            });

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });

        $(document).ready(function() {
            $('.repeat').click(function() {
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                var token = '{{ csrf_token() }}';

                $(".dublicate-record-model").attr("action", url);
                $('body').find('.dublicate-record-model').append(
                    '<input name="_token" type="hidden" value="' + token + '">');
                $('body').find('.dublicate-record-model').append('<input name="id" type="hidden" value="' +
                    id + '">');
            });
            $('.dublicate-data-from-dublicate-form').click(function() {
                $('body').find('.dublicate-record-model').find("input").remove();
            });
            $('.modal').click(function() {
                // $('body').find('.remove-record-model').find( "input" ).remove();
            });

            $('.repeat').on('click', function() {
                var name = $(this).closest('.inputs-product-body').find('.product_name').val();
                $('.product_name_double').text(name);
            });
        });

        $(document).ready(function() {
            $("#type-report").change(function() {
                $(this).find("option:selected").each(function() {
                    var optionValue = $(this).attr("value");
                    if (optionValue) {
                        $(".report").not("." + optionValue).hide();
                        $("." + optionValue).show();
                    } else {
                        $(".report").hide();
                    }
                });
            }).change();
        });

        $(document).ready(function() {
            $('.stats').click(function() {
                var id = $(this).attr('data-id');
                $('#statsProduct').val(id);
                $('#statsProduct').modal('show');
            });
        });

        $('body').on('click', '.stats', function(e) {
            e.preventDefault()
            var id = $(this).data('id');
            $('#pro_id').val(id);

            $.ajax({
                url: '{{ route('get_status') }}',
                method: "get",
                data: {
                    id: id
                },
                dataType: 'json',

                success: function(response) {
                    if (response.status == 'success') {
                        console.log(response.sum)
                        $('#sales').text(response.sum);
                        $('#ord_num').text(response.order_num);
                        $('#pen').text(response.penfit);
                    }
                },
            });
        });

        $(document).ready(function() {



            // $(document).on('click', '.hide_product', function(e) {

            // });

            $('.deletepro').click(function(e) {
                e.preventDefault()
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                var token = '{{ csrf_token() }}';
                $(".remove-record-model").attr("action", url);
                $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="' +
                    token + '">');
                $('body').find('.remove-record-model').append(
                    '<input name="_method" type="hidden" value="DELETE">');
                $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="' +
                    id + '">');
            });
            $('.remove-data-from-delete-form').click(function() {
                $('body').find('.remove-record-model').find("input").remove();
            });
            $('.modal').click(function() {
                // $('body').find('.remove-record-model').find( "input" ).remove();
            });
        });

        $(function() {
            // if (CKEDITOR.instances.editor1) {
            //     CKEDITOR.instances.editor1.destroy();
            // }
            CKEDITOR.editorConfig = function(config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",
                filebrowserUploadMethod: 'form'
            });
        });

        $(document).on('click', '.lang_ex', function(e) {
            e.preventDefault();
            // console.log('test2');
            var transRowId = $(this).data('id');
            var lang_id = $(this).data('lang');
            if (CKEDITOR.instances.editor1) {
                CKEDITOR.instances.editor1.destroy();
            }
            $.ajax({
                url: "{{ route('Product_lang_value') }}",
                method: "get",
                "_token": "{{ csrf_token() }}",
                data: {
                    'lang': lang_id,
                    'transRow': transRowId,
                },
                success: function(response) {
                    if (response.data == 'false') {
                        $('#titletrans').val('');
                        $('#information').val('');
                        $('#editor1').val('');
                    } else {
                        $('#titletrans').val(response.data.title);
                        $('#information').val(response.data.info);
                        $('#editor1').val(response.data.description);
                        CKEDITOR.replace('editor1', {
                            extraPlugins: 'colorbutton,colordialog',
                            filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",
                            filebrowserUploadMethod: 'form'
                        });

                    }
                }
            });

            $.ajax({
                url: '{{ route('all_langs') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function(response) {
                    $('#header').empty();
                    $('#header').text('Translate to : ' + response);
                    $('#id_data').val(transRowId);
                    $('#lang_id_data').val(lang_id);
                }
            });

            $('body').on('submit', '#lang_submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: "post",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(response) {
                        if (response.errors) {
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
                        }
                        if (response.status === 'SUCCESS'){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Translated Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_create').modal('hide');
                        }
                    },
                });
            })
        });
    </script>
@endpush
