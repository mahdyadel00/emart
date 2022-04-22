@extends('admin.layout.index',
[
	'title' => _i('Products update Stock'),
	'subtitle' => _i('Products update Stock'),
	'activePageName' => _i('Products update Stock'),
	'activePageUrl' => route('stocks.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('All Products Stock')}}</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">

                        <form id="form_add" class="form-horizontal" action="{{url('admin/stock/change')}}" method="POST"
                              data-parsley-validate="" enctype="multipart/form-data">
                            {{method_field('post')}}
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group row">
                                    <label class=" col-sm-2 col-form-label"><?=_i('product')?> </label>
                                    <div class="col-sm-10">
                                        <select class="form-control selectpicker" name="product_id" id="product_id"
                                                data-live-search='true'>
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

                                <div class="form-group row avilable_quantity">

                                </div>


                                <div class="form-group row">
                                    <label class=" col-sm-2 col-form-label"><?=_i('Total Quantity')?> <span
                                                style="color: #F00;">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number" id="title_add" class="form-control" name="quantity">
                                    </div>
                                </div>

                                <div class="form-group row tabel_feature">

                                </div>

                                <div class="form-group row">
                                    <label class=" col-sm-2 col-form-label"><?=_i('Details')?> <span
                                                style="color: #F00;">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea id="description_add" class="form-control" name="details"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <button class="btn btn-info" type="submit" id="s_form_1"
                                form='form_add'> {{_i('Save')}} </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

        // {{--$('body').on('change', '.pro_id', function (e) {--}}
        //     {{--e.preventDefault();--}}
        //     {{--var id = $(this).val();--}}
        //     {{--var url = '{{route('stocks.stockProduct')}}';--}}
        //     {{--// alert(url);--}}
        //     {{--$.ajax({--}}
        //         {{--url: url,--}}
        //         {{--method: "get",--}}
        //         {{--data: {--}}
        //             {{--id: id--}}
        //         {{--},--}}
        //         {{--success: function (response) {--}}

        //             {{--$('.avilable_quantity').empty();--}}
        //             {{--if (response == null)--}}
        //                 {{--response.quantity = 0;--}}

        //             {{--$('.avilable_quantity').append(`--}}

        //                     {{--<label class=" col-sm-2 col-form-label">{{ _i('Avilable Quantity') }}</label>--}}
        //                     {{--<div class="col-sm-10">--}}
        //                         {{--<div class="input-group">--}}
        //                             {{--<input class="form-control" type="text" name="name" readonly  id="test"--}}
        //                                 {{--value="`+response.quantity+`">--}}
        //                         {{--</div>--}}

        //                     {{--</div>--}}

        //                 {{--`)--}}
        //         {{--}--}}
        //     {{--});--}}
        // {{--})--}}


        $('body').on('change', '#product_id', function (e) {
            e.preventDefault();
            var id = $(this).val();
            var url = '{{route('getFeatures')}}';
            // alert(url);
            $.ajax({
                url: url,
                method: "get",
                data: {
                    id: id
                },
                success: function (response) {
                    $('.avilable_quantity').empty();
                    $('.tabel_feature').empty();
                    console.log(response)
                    if (response.totalStock != null) {
                        $('.avilable_quantity').append(`

                            <label class=" col-sm-2 col-form-label">{{ _i('Available Quantity') }}</label>
                                        <div class="col-sm-10">
                                        <div class="input-group">
                                        <input class="form-control" type="text" name="name" readonly  id="total-stock"
                                        value="`+response.totalStock+`">
                                        </div>

                                        </div>

                                        `)
                    }

                    if (response.option != null) {

                        $.each(response.option, function (i, item) {
                            if (item.name){
                                var name = item.name
                            }else {
                                var name = item.title
                            }

                            $('.tabel_feature').append(`
							<div class="row">
                            <label class=" col-sm-2 col-form-label">    {{ _i('Color') }} / {{ _i('Size') }} </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="name" readonly  id="test"
                                        value="`+name+`">
                                </div>

                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control" type="number" name="count_feature" id="count_feature_`+item.id+`"  value="`+item.count+`">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input class="form-control" type="number" name="sold" readonly value="`+item.sold+`">
                                </div>
                            </div>
							<div class="col-sm-2">
                            <a class="btn btn-info form-control" onclick = "updatefeature(`+item.id+`)"> {{_i('Save')}} </a>
                            </div>
							</div>
                            `)
                        })
                    }





                }
            });
        })

    </script>

    <script>

        function updatefeature(id) {
            var url = '{{route('stocks.updateFeature')}}';
            var featureCount = $('#count_feature_'+id).val();
            var product_id = $('#product_id').val();
            $.ajax({
                url: url,
                method: "post",
                data: {
                    id: id,
                    featureCount:featureCount,
                    product_id:product_id
                },
                success: function (response) {
                    if (response == 'SUCCESS'){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: response.error,

                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                }
            });
        }



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
                        console.log(response.errors)
                        if (response.errors){
                            $.each(response.errors, function(index, value) {
                                new Noty({
                                    type: 'error',
                                    layout: 'topRight',
                                    text: value,

                                    timeout: 2000,
                                    killer: true
                                }).show();
                            });
                        }

                        if (response.success == 'SUCCESS'){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('#total-stock').val(response.data);
                            $('#title_add').val('');
                        }
                    }
                });
            });
        });



    </script>
@endpush
