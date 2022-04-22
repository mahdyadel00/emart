@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@push('js')
	<script>
	$(document).ready(function(){
		$("#type-report").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".report").not("." + optionValue).hide();
					$("." + optionValue).show();
				} else{
					$(".report").hide();
				}
			});
		}).change();
	});
	</script>
@endpush
@section('content')
<div class="page-body">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form method="post" id="reports-form" class='mb-5' hidden>
                    @csrf
                    <div class="dropdown-inverse dropdown open mr-3">
                        <select id="type-report" name="type-report" class="form-control form-control-primary">
                            <option value="all">{{_i('All')}}</option>
                            <option value="day">{{_i('Daily')}}</option>
                            <option value="week">{{_i('Weekly')}}</option>
                            <option value="month">{{_i('Monthly')}}</option>
                            <option value="year">{{_i('Yearly')}}</option>
                        </select>
                    </div>
                    <div id="report-day" class="dropdown-inverse dropdown open day report mr-3">
                        {{Form::date('date', \Carbon\Carbon::today(),['class' => 'form-control mb-2 mr-sm-2 mb-sm-0','id' => 'date'])}}
                        {{-- <select id="day" name="day" class="form-control form-control-primary">
                            @foreach (\App\Bll\Utility::allDays() as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div id="report-week" class="dropdown-inverse dropdown open week report">
                        <select id="week" name="week" class="form-control form-control-primary">
                            <option value="1">الأسبوع الحالي ({{Carbon\Carbon::now()->startOfWeek()->format('Y/m/d')}} / {{Carbon\Carbon::now()->endOfWeek()->format('Y/m/d')}})</option>
                            <option value="2">الأسبوع الماضي ({{\App\Bll\Utility::LastWeek()[0]}} / {{\App\Bll\Utility::LastWeek()[1]}})</option>
                        </select>
                    </div>
                    <div id="report-month" class="dropdown-inverse dropdown open month report">
                        <div class="report-filter-month">
                            <select id="month" name="month" class="form-control form-control-primary">
                                @foreach (\App\Bll\Utility::allMonths() as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="report-month-year">
                            <select id="month-year" name="month-year" class="form-control form-control-primary">
                                @foreach (\App\Bll\Utility::allyears() as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="report-year" class="dropdown-inverse dropdown open year report">
                        <select id="year" name="year" class="form-control form-control-primary">
                            @foreach (\App\Bll\Utility::allyears() as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary waves-effect waves-light ml-3" value="Submit">
                </form>

                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Product prices report')}}</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="slider_table" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr role="row">
                                        <th> {{_i('ID')}}</th>
                                        <th> {{_i('Title')}}</th>
                                        <th> {{_i('Price')}}</th>
                                        <th> {{_i('Cost')}}</th>
                                        <th> {{_i('Profit')}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	@push('js')
		<script type="text/javascript">

		$(function () {
			$('.dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('reports.products.prices') }}',
				columns: [
					{data: 'id'},
					{data: 'title', name: 'product_details.title'},
					{data: 'price'},
					{data: 'cost'},
					{data: 'profit'},
				]
			});
		});
		</script>
	@endpush
	@endsection
