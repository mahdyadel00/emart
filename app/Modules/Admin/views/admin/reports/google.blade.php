@extends('admin.layout.index',[
	'title' => _i('Google Analaytics'),

'subtitle' => '<a href="../">Reports</a> | '._i('Google Analytics'),

	'activePageName' => _i('Google'),
	'activePageUrl' => '',
	'additionalPageUrl' => '../reports' ,
	'additionalPageName' => 'Reports',
] )


@section('content')
<div class="page-body">


                <form action="{{url('admin/reports/google')}}" method="get">
                    <div class="container">
                        <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Start Date:</label>
                            <input name="startDate" type="datetime-local" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>End Date:</label>
                            <input name="endDate" type="datetime-local" class="form-control">
                        </div>
                    </div>

                            <div class="">
                                <button class="btn btn-success sub-search-btn">Submit</button>
                            </div>

                        </div>
                    </div>

                </form>





	<div class="row">

        @include('admin.reports.layouts_Google.VisitorsPageViews')

        @include('admin.reports.layouts_Google.total_visitors')

        @include('admin.reports.layouts_Google.Mostvisited')

        @include('admin.reports.layouts_Google.TopReferrers')

        @include('admin.reports.layouts_Google.UserTypes')

        @include('admin.reports.layouts_Google.TopBrowsers')










	</div>
</div>
	@endsection

	@push("js")
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.esm.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.esm.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/helpers.esm.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/helpers.esm.min.js"></script>
     @yield('myChart')
     @yield('myChartTotal')
     @yield('myChartMost')
     @yield('myChartTopReferrers')
     @yield('myChartUserTypes')
     @yield('myChartTopBrowsers')
    @endpush


