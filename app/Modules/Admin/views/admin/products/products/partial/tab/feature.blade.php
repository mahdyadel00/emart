<div class="tab-pane" id="productFeature">

    <div class="form-group row apply" id="div_items" style="display: none">
        <label class="col-sm-2">{{ _i('Color or Size') }}</label>
        <div class="col-sm-10">
            <div class="form-radio">
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="colororsize" class="colororsize" checked value="0"
                            data-bv-field="member">
                        <i class="helper"></i>{{ _i('Color') }}
                    </label>
                </div>
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="colororsize" class="colororsize" value="1" data-bv-field="member">
                        <i class="helper"></i>{{ _i('Size') }}
                    </label>
                </div>
            </div>
            <span class="messages"></span>
        </div>
    </div>


    <div class="product-features" id="static_feature_color" style="display: none;">
        <div class="form-group">
            <div class="input-group mb-3 mt-3">
                <span class="input-group-prepend">
                    <i class="ti-tag"></i>
                    <label for=""> / {{ _i('Color') }}</label>
                </span>
            </div>
        </div>

        <form action=""  method="POST" name="save-features" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <input type="hidden" name="type" id="frm_type" value="color">
            <input type="hidden" name="id" class="product_id" value="">
            <input type="hidden" data-color="color" class="form-control feature_title" placeholder="{{ _i('Color') }}"
                name="feature_title_color" value="{{ _i('Color') }}">
            @include("admin.products.products.partial.tab.features.new_color")
        </form>


    </div>

    <br>

    <div class="product-features" id="static_feature_size" style="display: none;">
        <div class="form-group">
            <div class="input-group ">
                <span class="input-group-prepend">
                    <i class="ti-tag"></i>
                    <label for=""> / {{ _i('Size') }}</label>
                </span>

            </div>
        </div>

        <form action="" method="POST" name="save-features" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <input type="hidden" name="type" id="frm_type" value="size">
            <input type="hidden" name="id" class="product_id" value="">
            <input type="hidden" data-size="size" class="form-control feature_title" placeholder="{{ _i('Size') }}"
                name="feature_title_size" value='{{ _i('Size') }}'>
            @include("admin.products.products.partial.tab.features.new_size")
        </form>
        <div class="new_option_one"></div>


        <br>
    </div>


</div>


@push('js')
    <script>


function updateFeatureOptionSaved(optionId, obj) {
            let complete = true

            var url2 = '{{ route('features.update', 'id') }}';


            url2 = url2.replace('id', optionId);
            var dataimg = new FormData();

            if ($("#name-" + optionId).val() != null) {
                dataimg.append('name', $("#name-" + optionId).val());

            }

            dataimg.append('title', $("#title-" + optionId).val());
            dataimg.append('price', $("#price-" + optionId).val());
            dataimg.append('count', $("#quantity-" + optionId).val());
            if ($("#bbb-" + optionId).val() != null) {
                dataimg.append('image2', $("#bbb-" + optionId)[0].files[0]);

            }




            $.ajax({
                url: url2,
                method: "POST",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: dataimg,

                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            text: "{{ _i('updated Successfully') }}",
                            showConfirmButton: false,
                            timer: 5000
                        })
                    }
                    if (response.error) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: response.error,
                            showConfirmButton: false,
                            timer: 5000
                        })

                    }
                },
            });
        }
        function deleteFeatureOptionSaved(optionId, obj) {
            //console.log(optionId)

            if (optionId == 0) {
                // console.log("ddddddddddddddddddddd") ;
                $(obj).parents('.new_option:first').remove();
            } else {
                $.ajax({
                    url: '{{ route('deleteFeatureOption') }}',
                    method: "post",
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        optionId: optionId
                    },
                    success: function(response) {
                        if (response.data == 'success') {
                            $(obj).closest('.saved_option').remove();
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Delete Successfly') }}",
                                timeout: 2000,
                                killer: true
                            }).show();

                            loadFeatures();
                        }

                    },
					error :function(){
						new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: "{{ _i('Can not delete with relational data') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
					},
                });
            }
        }
        $(function() {
            $(".colororsize").click(function() {
                var vpp = $(this).val();
                if (vpp == 1) {

                    $("#static_feature_size").find("form").find("#frm_type").val("size");
                    $("#static_feature_size").css("display", "block");
                    $("#static_feature_color").css("display", "none");

                } else {


                    $("#static_feature_color").find("form").find("#frm_type").val("color");
                    $("#static_feature_color").css("display", "block");
                    $("#static_feature_size").css("display", "none");

                }


            });

            $("form[name='save-features']").each(function(i, f) {
                $(f).on('submit', function(e) {
                    e.preventDefault();

                    var feature_price = $(this).find('.feature_option_price');
                    var feature_quantity = $(this).find('.feature_option_count');

                    if (!validateInput(feature_quantity, 1, (x, y) => x < y)) return swalAlert(
                        "{{ _i('Quantity should be greater or equal 1') }}")


                    var id = $(this).find(".product_id").val();

                    var url = '{{ route('features.store', 'id') }}';
                    url = url.replace('id', id);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: new FormData(this),
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(res, e) {


                            if (res == 'error') {

                                Swal.fire({
                                    position: 'top-end',
                                    type: 'error',
                                    title: "{{ _i('Feature quantity more than product stock') }}",
                                    showConfirmButton: false,
                                    timer: 5000
                                })
                            }

                            if (res.status == 'ok') {
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: "{{ _i('Saved Successfully !') }}",
                                    showConfirmButton: false,
                                    timer: 5000
                                })
                                //$("#save-features")[0].reset();
                                if (res.data.type == "color") {
                                    $("#static_feature_color").find("form")[0].reset();
                                } else {
                                    $("#static_feature_size").find("form")[0].reset();

                                }
                                loadFeatures();
                            }

                        }
                    })


                });

            });
        });


        $('body').on('submit', '#form-features', function(e) {
            e.preventDefault();

            var radioCheck = $("input[type='radio']:checked").val();

            if (radioCheck == 0) {
                var color = $("#static_feature_color").find('input[data-color="color"]');
                $.each(color, function() {
                    $(this).prop('required', true);
                });
                var size = $("#static_feature_size").find('input[data-size="size"]');
                $.each(size, function() {
                    $(this).prop('required', false);
                });
            } else {
                var size = $("#static_feature_size").find('input[data-size="size"]');
                $.each(size, function() {
                    $(this).prop('required', true)
                });

                var color = $("#static_feature_color").find('input[data-color="color"]');
                $.each(color, function() {
                    $(this).prop('required', false);
                });

            }

            if ($("#form-features")[0].checkValidity()) {
                $.ajax({
                    url: "{{ route('product.savefeatures') }}",
                    method: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(response) {
                        if (response == 'success') {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{ _i('Saved Successfully !') }}",
                                showConfirmButton: false,
                                timer: 5000
                            })
                            $('#myModal').modal('hide')
                            location.reload();
                        }
                    },

                });
            } else console.log("invalid form");


        });
        $('body').on('click', '.productFeature', function(e) {
            e.preventDefault();
            loadFeatures();

        });

        function loadFeatures() {
            $('#static_feature_color').find('.new_option_one').html('');
            $('#static_feature_color').find('.saved_option').remove();
            $('#static_feature_size').find('.new_option_one').html('');
            $('#static_feature_size').find('.saved_option').remove();
            $('#feature_product').html('');
            var id = $('.product_id').val();


            $.ajax({
                url: "{{ route('getFeatures') }}",
                method: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(response) {
                    //reset
                    $("#div_items").hide();
                    $("#static_feature_color").hide();
                    $("#static_feature_size").hide();
                    var type = "color";
                    if (response.type != "") {
                        //alert(0);
                        type = response.type;
                    }
                    $("#frm_type").val(type);
                    if (response.data == null) {
						$($("input[name='colororsize']")[0]).prop("checked","checked")

                        if (response.status != 'error') {

                            $('a[href="#productFeature"], #productFeature')
                                .removeClass('active')
                                .attr('aria-expanded', false)

                            $('a[href="#productFeature"], #productFeature')
                                .siblings()
                                .removeClass('active')
                                .attr('aria-expanded', false)

                            $('a[href="#productDetail"], #productDetail')
                                .addClass('active')
                                .attr('aria-expanded', true)

                            Swal.fire({
                                position: 'top-end',
                                type: 'error',
                                title: response.status,
                                showConfirmButton: false,
                                timer: 5000
                            })
                        }
                        // $('#new_feature').empty();
                    }


                    //clear choices
                    if (response.status == 'success') {
						$($("input[name='colororsize']")[0]).prop("checked","checked")

                        if (response.type == "size") {
                            $("#static_feature_size").show();
							$($("input[name='colororsize']")[1]).prop("checked","checked")



                        } else if (response.type == "color") {

                            $("#static_feature_color").show();
                        }

                        $('.new_feature_one').empty();
                        $('#new_feature').empty();
                        $('.add_new_feature').removeAttr('onclick');
                        $('.add_new_feature').attr('onclick', 'myJsFuncEdit();');
                        for (var ii = 0; ii < response.data.length; ii++) {

                            if (response.data[ii].type == 'color' || response.data[ii].type == 'size') {

						    var _key = response.data[ii].type;

                                var input_type = _key == 'color' ? 'color' : 'text';
                                $('input[name="feature_title[' + _key + ']"]').val(response.data[ii]
                                    .title);

                                for (var i = 0; i < response.data[ii].options.length; i++) {
									var opt = response.data[ii].options[i];
                                    var option_name = opt.name;
                                    if (opt.name == null) {
                                        var option_name = '';
                                    }
                                    var option_price = opt.price;
                                    if (opt.price == null) {
                                        var option_price = '';
                                    }
                                    var option_quantity = opt.count;


                                    if (opt.count == null) {
                                        var option_quantity = '';
                                    }
                                    var image = " ";
                                    var name = "";
                                    if (_key == 'color') {
										//alert(0);
										opt_img =response.data[ii].images[opt.id];
                                        if (opt_img !== undefined) {
                                            if (opt_img.url !== null) {
                                                var image_id = opt_img.id;
                                                 console.log(opt_img);

                                                image = `
													<span class="input-group-prepend">
													<img style="height:40px; width:40px; " src="{{ url('uploads/products/features') }}/${opt_img}">
														</span>

														<input  type="file" id="bbb-${opt.id}"  class="form-control feature_option_count "  name="image2"> `;


                                            } else {
                                                image = `<span class="input-group-prepend">
															<i class="ti ti-export "> </i>
														</span>
														<input  type="file" id="bbb-${opt.id}"  class="form-control feature_option_count col-md-8 test"  name="image2">`;
                                            }
                                        }


                                    }

									$('.new_option_' + _key).before(`
										@include("admin.products.products.partial.tab.features.edit_color")`);


                                    // if (response.data[ii].options[i].name) {
                                    //     name = `<div class="col-md-3">
									// 	<div class="input-group mb-3"><span class="input-group-prepend">
									// 			<i class="ti-tag"></i>
									// 		</span><input type="text" id="name-${opt.id}" class="form-control feature_option_name" value="${opt.name}"  placeholder="{{ _i('Name') }}" name="name"></div>
									// 	</div>`;
									// 	$('.new_option_' + _key).before(name);

                                    // } else {
                                    //     name = '';
                                    // }


                                }


                            }

                            ++count_1;
                        }
                    } else if (response.status == 'error') {
                        if (response.type == "size") {
                            $("#static_feature_size").show();
                        } else if (response.type == "color") {
                            $("#static_feature_color").show();
                        } else {
                            //alert(0);
                            $("#div_items").show();
                            $("#static_feature_color").show();
                            //  $("#static_feature_size").show();
                        }
                        return;


                    }



                }
            });
        }
    </script>

@endpush
