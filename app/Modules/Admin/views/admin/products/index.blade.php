@extends('admin.layout.index', [
'title' => _i('Products'),
'subtitle' => _i('Products'),
'activePageName' => _i('Products'),
'activePageUrl' => route('products.index'),
'additionalPageName' => '',
'additionalPageUrl' => '' ,
])
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
            .product-desc .dropdown-menu {
                /*position: static !important;*/
            }

            .dropdown-menu.open {
                left: 70px;
                overflow: visible;
            }

            input {
                padding-right: 30px !important;
            }

            .btn.btn-tiffany {
                cursor: pointer;
            }

            .dropdown-menu.open {
                left: -70px;
                overflow: visible;
                /*left: 0;*/
            }

            .product-desc .dropdown-item {
                display: block;
                width: 100%;
                padding: .25rem 0 .25rem 1.5rem;
                clear: both;
                font-weight: 400;
                color: #212529;
                text-align: right;
                white-space: nowrap;
                background: 0 0;
                border: 0;
            }

            .type .dropdown-item {
                text-align: right;
            }

            .product-desc .bootstrap-select.show-tick .dropdown-menu li a span.text {
                margin-left: 34px;
            }

            .dropdown-menu {
                z-index: 9999;
            }

        </style>
        <link rel="stylesheet" href="{{ asset('admin_dashboard/dropzone.css') }}">
        <style>
            .product-desc .dropdown-item {
                display: block;
                width: 100%;
                padding: .25rem 0 .25rem 1.5rem;
                clear: both;
                font-weight: 400;
                color: #212529;
                text-align: right;
                white-space: nowrap;
                background: 0 0;
                border: 0;
            }

            .type .dropdown-item {
                text-align: right;
            }

            .product-desc .bootstrap-select.show-tick .dropdown-menu li a span.text {
                margin-left: 34px;
            }

            .dropdown-menu {
                z-index: 9999;
            }

        </style>
    @endpush
{{--    @dd('hello')--}}
    <div class="products-lists">
        <div class="content row">
            <div class="row btns-row d-flex justify-content-between">
                <div class="col-xs-5 main-btn">
                    <a class="btn btn-tiffany btn-rounded btn-xlg" id="add-btn" onclick="addNewProduct()">
                        <i class="fa fa-plus"></i>{{ _i('Add Product') }}</a>
                </div>
{{--                <div class="col-xs-7 ">--}}
{{--                    @include('admin.products.products.includes.filter')--}}
{{--                </div>--}}
            </div>
            @include("admin.products.products.partial.product")
            @include("admin.products.products.partial.category")
            @include("admin.products.products.partial.modal")
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin_dashboard/dropzone.js') }}"></script>
    <script type="text/javascript">
        var $product_id = 0;
        $(function() {
            'use strict'
            $('.product-desc .selectpicker').on('change', function(e) {
                $(this).next().next().addClass('show');
            })
            $('body').click(function() {
                $('.product-desc .selectpicker').next().next().removeClass('show');
            })
        })

        function addNewProduct() {


            html = `@include("admin.products.products.ajax.new")`;
            $("#allProducts_div").prepend(html);
            $("#no-items").hide();
            $('.selectpicker').selectpicker();
        }

        function getDetails(obj) {

            var form = $(obj).closest("form");
            var product_id = form.find("input[name='product_id']").val();

            $('#metId').val(product_id);
            $product_id = product_id;

            $('.product_id').val(product_id);

            if (product_id == "-1") {
                Swal.fire({
                    title: "{{ _i('Alert') }}",
                    text: "{{ _i('Please save product first') }}",
                    icon: 'warning',
                });
                return;
            }

            $("#editdetails").modal("show");
            $("#editdetails").find('.nav-tabs a:first').tab('show');
        }

        function ProductHide(product_id) {
            $("input[name='product_id'][value=" + product_id + "]").closest(".product-box").addClass('product-hidden');
        }

        function getProdImgid(obj) {

            var form = $(obj).closest("form");
            var product_id = form.find("input[name='product_id']").val();

            if (product_id == "-1") {
                Swal.fire({
                    title: "{{ _i('Alert') }}",
                    text: "{{ _i('Please save product first') }}",
                    icon: 'warning',
                });
                return;
            }

            $("#frm_photo").find("input[name='product_id']").val(product_id);

            clearDrop();

            $.get('product/' + product_id + "/img").then(data => {

                for (var i = 0; i < data.length; i++) {

                    item = data[i];

                    if (item.main == 0) {
                        var file = {
                            id: item.id,
                            name: item.tag,
                            type: "image/*"
                        };
                        var url = '{{ url('/') }}' + item.photo;
                        drop[0].dropzone.emit("addedfile", file);
                        drop[0].dropzone.emit("thumbnail", file, url);
                        drop[0].dropzone.emit("complete", file);
                    } else {

                        $("#img_main").attr("src", ".." + item.photo);
                    }
                }
            });
            $.get('product/' + product_id + "/video").then(data => {
                for (var i = 0; i < data.length; i++) {
                    item = data[i];
                    $('.product-video').html(

					"<iframe width='350' height='300' src='" + item.video + "' ></iframe>"
					);

                }
            });
            $("#photoModal").modal("show");
        }

        function clearDrop() {
            $("#dropzonefield").html("");
            //(".dz-preview").remove();
            drop[0].dropzone.destroy();

            initDrop();
        }

        function saveMain(obj) {
            var product_id = $("#frm_photo").find("input[name='product_id']").val();
            //$('#metId').val(product_id);
            var fd = new FormData();
            var files = $("#product_photo")[0].files[0];
            fd.append('image', files);
            fd.append('product_id', product_id);
            fd.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: 'imageSubmit',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == "ok") {
                        var img = $("form[name='frm_product'] input[name='product_id'][value=" + product_id +
                            "]").parents("form").find(".product-img")
                        $(img).attr("src", ".." + response.data);

                        Swal.fire({
                            title: '{{ _i('Alert') }}',
                            text: "{{ _i('Image updated successfully') }}",
                            icon: 'success',
                        });

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ _i('Photo not uploaded') }}",
                            showConfirmButton: false,
                            timer: 5000
                        })
                    }
                }
            });
        }

        $(document).ready(function() {
            'use strict';
            initDrop();
        });


        function saveMainVideo(obj) {

            var product_id = $("#frm_photo").find("input[name='product_id']").val();
            // $('#metId').val(product_id);
          var files = $("#product_video").val();
            var fd = new FormData();
            fd.append('video', files);
            fd.append('product_id', product_id);
            fd.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: 'upload_video',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == "ok") {
                        Swal.fire({
                            title: '{{ _i('Alert') }}',
                            text: "{{ _i('Video updated successfully') }}",
                            icon: 'success',
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ _i('Error Uploading Product Video') }}",
                            showConfirmButton: false,
                            timer: 5000
                        })
                    }
                },
                error: function(response) {
                    console.log(response);
                    new Noty({
                        type: 'warning',
                        layout: 'topRight',
                        text: (response.responseJSON.message == "") ? response.statusText : response
                            .responseJSON.message,
                        timeout: 5000,
                        killer: true
                    }).show();
                }
            });
        }

        $(function() {
            $('.product-desc .selectpicker').on('change', function(e) {
                $(this).next().next().addClass('show');
            })
            $('body').click(function() {
                $('.product-desc .selectpicker').next().next().removeClass('show');
            })

        });
        Dropzone.autoDiscover = false;
        var drop;

        function initDrop() {
            drop = $('#dropzonefield').dropzone({
                url: "{{ route('product.imagespost') }}",
                paramName: 'file',
                uploadMultiple: true,
                maxFiles: 10,
                maxFilesize: 5,
                dictDefaultMessage: "{{ _i('Click here to upload files or drag and drop files here') }}",
                dictRemoveFile: "{{ _i('Delete') }}",
                acceptedFiles: 'image/*',
                autoProcessQueue: true,
                parallelUploads: 1,
                removeType: "server",
                params: {
                    _token: '{{ csrf_token() }}',
                    product_id: $("#frm_photo").find("input[name='product_id']").val(),

                },
                addRemoveLinks: true,
                removedfile: function(file) {
                    if (drop[0].dropzone.options.removeType == "server") {
                        console.log(file.id);
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',

                            url: '{{ route('product.imagesdel') }}',
                            data: {
                                file: file.name,
                                _token: '{{ csrf_token() }}',
                                id: file.id,
                            },
                        });
                        var fmock;

                        if ((fmock = file.previewElement) != null) {
                            if (fmock.parentNode !== null)
                                return fmock.parentNode.removeChild(file.previewElement);

                        }
                        return void 0;
                        //  return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;
                    } else {
                        file.previewElement.remove();
                    }
                },
                success: function(file, response) {
                    file.id = response.id;
                },
            });
        }


        function uploadFiles() {
            drop[0].dropzone.processQueue();
        }

        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                $('.image').attr('src', e.target.result).width(250).height(250);
            };
            filereader.readAsDataURL(input.files[0]);
        }

        function clearTabs() {
            $("#editdetails").find("[data-card='']").hide();
            $("#editdetails").find("[data-digital='']").hide();
            $("#editdetails").find("[data-donation='']").hide();
            $("#editdetails").find("[data-feature='']").hide();
        }

        function LoadCard() {
            var id = $('.product_id').val();
            $('#card_id').val(id);
            $.ajax({
                url: '{{ route('get_card') }}',
                method: "get",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        $('#get_new_data').empty();
                        for (var i = 0; i < response.data.length; i++) {
                            // $(html).find("input[name='code[]']").val(${response.data[i].code});
                            $('#get_new_data').append(
                                `<div class="row form-group" data-id="${response.data[i].id}">
								<div class="col-md-2">
									<label>{{ _i('Code Details') }}</label>
								</div>
								<div class="col-md-8">
									<input required type="number" name="code[]" class="form-control" required="" value="${response.data[i].code}" >
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-danger btn-sm delelete_card" onclick="deleteCard(${response.data[i].id})" >{{ _i('delete') }}</button>
								</div>
							</div>`
                            );
                        };
                    } else {
                        $('#get_new_data').empty();
                        $('#append_card').empty();
                        $('#get_new_data').append(
                            `<div class="row form-group">
							<div class="col-md-2">
								<label>{{ _i('Code Details') }}</label>
							</div>
							<div class="col-md-8">
								<input required type="number" name="code[]" class="form-control" required=""  >
							</div>
							<div class="col-md-2">
								<button class="btn btn-danger btn-sm del_card" >{{ _i('delete') }}</button>
							</div>
						</div>`
                        )
                    }
                },
            });
        }

        $('body').on('click', '.optional-category', function(e) {
            e.preventDefault();
            clearTabs();

            var id = $('.product_id').val();
            var code = $(this).data("code");

            if (code == "cards") {
                $("#editdetails").find("[data-card='']").show();
                LoadCard();
            } else if (code == "digital_product") {
                $("#editdetails").find("[data-digital='']").show();
            } else if (code == "donation") {
                $("#editdetails").find("[data-donation='']").show();
                $('#Donate_id').val(id);
            } else {
                $("#editdetails").find("[data-feature='']").show();
            }
            e.preventDefault();
            $.ajax({
                url: '{{ route('get-product-data') }}',
                method: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(response) {

                    if (response.status == 'success') {
                        //debugger;
                        console.log(response.data.brand_id);
                        $('#delivary').val(response.data.delivary);
                        $('#is_free_shipping').val(response.data.is_free_shipping);
                        $('#weight').val(response.data.weight);
                        $('#weight_unit').val(response.data.weight_unit);
                        $('#sku').val(response.data.sku);
                        $('#max_count').val(response.data.max_count);
                        $('#created_at').val(response.data.created_at);
                        $('#price').val(response.data.price);
                        $('#cost').val(response.data.cost);
                        $('#stock').val(response.data.stock);
                        $('#discount').val(response.data.discount);
                        // $('#brand').val(response.data.brand_id);
                        $('select[name=brand]').val(response.data.brand_id);
                        $('#points').val(response.data.points);
                        $('#refrence').val(response.data.ref_number);

                        $('#country_of_origin').val(response.data.country_of_origin).selectpicker();

                        //$('select[name=country_of_origin]').val(response.data.country_of_origin);
                        $('#description').val(response.data.description);
                        CKEDITOR.instances['text'].setData(response.data.text);


                        if (response.data.delivary == 1) {
                            $('.is-free-shipping-div').removeAttr('hidden');
                        }
                    }
                }
            });
        })

        var count_1 = 0;





        $('body').on('click', '.delete_feature_option_edit', function() {
            $(this).closest('.new-option_edit').remove();
        });

        $('body').on('click', '.delete_feature_option', function() {
            $(this).closest('.new_option').remove();
        })

        $('body').on('submit', '#form-details', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('product.savedetails') }}",
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function(response) {
                    // alert(response.errors);
                    if (response.errors) {
                        $('#masages_model1').empty();
                        $.each(response.errors, function(index, value) {
                            $('#masages_model1').show();
                            $('#masages_model1').append(value + "<br>");
                        });
                    }


                    if (response == 'success') {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: "{{ _i('Saved Successfully !') }}",
                            showConfirmButton: false,
                            timer: 5000
                        })
                        // location.reload();
                        $('#myModal').modal('hide')
                    }
                },
            });
        })



        $(function() {
            CKEDITOR.config.language = "{{ app()->getLocale() }}";
        })

        $('body').on('click', '.delete_feature', function(e) {
            var feature = $(this).closest('.product-features').remove();
        });

        $('body').on('click', '.delete_feature_edit', function(e) {
            var feature = $(this).closest('#new_feature_edit').remove();
        });

        $('body').on('click', '.delete_feature_product', function(e) {
            var feature = $(this).closest('#feature_product').remove();
        });

        var count = 1;




        $(document).on('change', '#delivary', function() {
            var _val = $(this).val();
            if (_val == 1) {
                $('.is-free-shipping-div').removeAttr('hidden');
            } else {
                $('.is-free-shipping-div').attr('hidden', true);
            }
        })

        $("#similar").on('click', function(e) {
            e.preventDefault();
            var id = $(".product_id").val();
            // $('#metId').val(id);

            $.ajax({
                url: '{{ route('similarProducts') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response.similar_products);
                    $("#similar_products").val(response.similar_products);
                    $(".selectpicker").selectpicker('refresh');

                }
            });
        });

        $('#form-similar-products').on('submit', function(e) {
            e.preventDefault();

            var id = $(".product_id").val();
            console.log(id);
            var similar_products = $("#similar_products").val();
            $.ajax({
                url: '{{ route('save.getSimilarProducts') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id,
                    similar_products: similar_products
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "{{ _i('Saved Successfully !') }}",
                        showConfirmButton: false,
                        timer: 5000
                    })
                }
            });
        });

        $('#meta').click(function(e) {
            //debugger;
            e.preventDefault();
            var product_id = $(".product_id").val();
            $('#metId').val(product_id);

            $.ajax({
                url: '{{ route('get-meta-data') }}',
                method: "get",
                data: {
                    id: product_id,
                    _token: '{{ csrf_token() }}',

                },
                success: function(response) {

                    // debugger;
                    if (response.status == 'success') {

                        $('#title').val(response.data[0]);
                        $('#des').val(response.data[1]);
                        $('#keyword').val(response.data[2]);

                    }
                }
            });

        });

        $('#form-meta-tags').on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: "{{ _i('Saved Successfully !') }}",
                            showConfirmButton: false,
                            timer: 5000
                        })
                        $('#metaTags').modal('hide');

                    }
                },
            });
        });

        function swalAlert(msg) {
            Swal.fire({
                position: 'top-end',
                type: 'error',
                title: msg,
                showConfirmButton: false,
                timer: 5000
            })
        }

        function validateInput(data, value, operataion) {
            let result = true

            data.each((i, obj) => {
                let input_value = $(obj).val()

                if (input_value.length > 0) {
                    if (operataion($(obj).val(), value)) result = false;
                }
            })

            return result
        }



        // $(".colororsize").click(function() {
        //     var id = $(".product_id").val();
        //     $("#saveFeature").show();
        //     var vpp = $(this).val();
        //     var url = '{{ route('features.check', 'id') }}';
        //     url = url.replace('id', id)
        //     $.ajax({
        //         url: url,
        //         success: function(res) {



        //             if (res.type == '{{ _i('Color') }}') {
        //                 console.log('test1');
        //                 $("#static_feature_size").css("display", "none");


        //             } else if (res.type == '{{ _i('Size') }}') {
        //                 console.log('test2');
        //                 $("#static_feature_color").css("display", "none");

        //             } else {
        //                 $("#saveFeature").show();
        //             }
        //         }
        //     })



        // });

        $(document).on('click', '.detaPro', function() {
            var id = $(this).attr('data-id');

            $('#row_product_id').val(id)
        });


        //});

        $(document).on('click', '.detaPro', function() {
            var id = $(this).attr('data-id');

            $('#row_product_id').val(id)
        });
    </script>
@endpush
