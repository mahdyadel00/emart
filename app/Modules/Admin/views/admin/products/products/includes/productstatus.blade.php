<div id="statsProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                <h4 class="modal-title" id="custom-width-modalLabel">{{_i('Product Report')}}</h4>
                <span id="pro_id"></span>
            </div>
            <div class="modal-body">
{{--                <div class="col-md-12 mb-3">--}}
{{--                    <form method="post" id="reports-form">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="report_row_product_id" id="report_row_product_id">--}}
{{--                        <div class="dropdown-inverse dropdown open mr-3">--}}
{{--                            <select id="type-report" name="type-report" class="form-control form-control-primary">--}}
{{--                                <option value="all">{{_i('All')}}</option>--}}
{{--                                <option value="day">{{_i('Daily')}}</option>--}}
{{--                                <option value="week">{{_i('Weekly')}}</option>--}}
{{--                                <option value="month" selected>{{_i('Monthly')}}</option>--}}
{{--                                <option value="year">{{_i('Yearly')}}</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}


{{--                        <div id="report-day" class="dropdown-inverse dropdown open day report mr-3">--}}

{{--                            {{Form::date('date', \Carbon\Carbon::today(),['class' => 'form-control mb-2 mr-sm-2 mb-sm-0','id' => 'date'])}}--}}
{{--                            --}}{{-- <select id="day" name="day" class="form-control form-control-primary">--}}
{{--                                @foreach (\App\Bll\Utility::allDays() as $key => $value)--}}
{{--                            <option value="{{$key}}">{{$value}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select> --}}
{{--                        </div>--}}

{{--                        <div id="report-week" class="dropdown-inverse dropdown open week report">--}}
{{--                            <select id="week" name="week" class="form-control form-control-primary">--}}
{{--                                <option--}}
{{--                                    value="{{Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')}}/{{Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')}}">--}}
{{--                                    {{_i("Current week")}} ({{Carbon\Carbon::now()->startOfWeek()->format('Y/m/d')}}--}}
{{--                                    / {{Carbon\Carbon::now()->endOfWeek()->format('Y/m/d')}})--}}
{{--                                </option>--}}
{{--                                <option value="{{\App\Bll\Utility::LastWeek()[0]}}/{{\App\Bll\Utility::LastWeek()[1]}}">--}}
{{--                                    {{_i("Last week")}} ({{\App\Bll\Utility::LastWeek()[0]}}--}}
{{--                                    / {{\App\Bll\Utility::LastWeek()[1]}})--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div id="report-month" class="dropdown-inverse dropdown open month report">--}}
{{--                            <div class="row">--}}
{{--                                <div class="report-filter-month mr-2">--}}
{{--                                    <select id="month" name="month" class="form-control form-control-primary">--}}
{{--                                        @foreach (\App\Bll\Utility::AllMonths() as $key => $value)--}}
{{--                                            <option value="{{$key}}">{{$value}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="report-month-year">--}}
{{--                                    <select id="month-year" name="month-year" class="form-control form-control-primary">--}}
{{--                                        @foreach (\App\Bll\Utility::allyears() as $key => $value)--}}
{{--                                            <option value="{{$value}}">{{$value}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div id="report-year" class="dropdown-inverse dropdown open year report">--}}
{{--                            <select id="year" name="year" class="form-control form-control-primary">--}}
{{--                                @foreach (\App\Bll\Utility::allyears() as $key => $value)--}}
{{--                                    <option value="{{$value}}">{{$value}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <input type="button" id="" onclick="getStatus(this)" id=""--}}
{{--                               class="btn btn-primary waves-effect waves-light ml-3" value="Submit">--}}
{{--                        <img src="{{asset('loading.gif')}}" style="display:none" id="img_load"></form>--}}


{{--                </div>--}}

                <div class="col-md-12 col-xl-12" id="div_report">

                    <div class="card table-card group-widget mr-4">
                        <div class="row-table">
                            <div class="col-sm-4 bg-primary card-block-big mr-3">
                                <i class="icofont icofont-music"></i>
                                <span class="pen">{{_i('Sales')}}</span>
                                <p id="sales" class="count"></p>
                            </div>
                            <div class="col-sm-4 bg-dark-primary card-block-big mr-3">
                                <i class="icofont icofont-video-clapper"></i>
                                <span class="pen">{{_i('Orders')}}</span>
                                <p id="ord_num" class="count"></p>
                            </div>
                            <div class="col-sm-4 bg-darkest-primary card-block-big mr-3">
                                <i class="icofont icofont-email"></i>
                                <span class="pen">{{_i('Benefits')}}</span>
                                <p id="pen" class="count"></p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

@push('js')
    <script>
        function getStatus(obj) {
            $("#div_report").css("opacity", ".3");
            $("#img_load").css("display", "inline");
            // var id = $(obj).data('id');
            // $('#pro_id').val(id);

            var id = $('#report_row_product_id').val();
            var type = $('#type-report').val();
            var day = $('#date').val();
            var week = $('#week').val();
            var month = $('#month').val();
            var month_year = $('#month-year').val();
            var year = $('#year').val();
            //console.log(type)

            $.ajax({
                url: '{{route('get_status')}}',
                method: "get",
                data: {id: id, type: type, day: day, week: week, month: month, month_year: month_year, year: year},
                dataType: 'json',

                success: function (response) {
                    if (response.status == 'success') {
                        console.log(response.sum)
                        $('#sales').text(response.sum);
                        $('#ord_num').text(response.order_num);
                        $('#pen').text(response.penfit);

                    }
                    $("#div_report").css("opacity", "1");
                    $("#img_load").css("display", "none");


                },

            });
        }
    </script>
@endpush
