@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<div class="page-body">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Rewards points')}}</h5>
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
                                        <th> {{_i('Name')}}</th>
                                        <th> {{_i('Email')}}</th>
                                        <th> {{_i('Points count')}}</th>
                                        <th> {{_i('Points count rewarded')}}</th>
                                        <th> {{_i('Points count total')}}</th>
                                        <th> {{_i('Total purchased')}}</th>
                                        <th> {{_i('Points amount')}}</th>
                                        <th> {{_i('Details')}}</th>
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
				ajax: '{{ route('reports.rewards.points') }}',
				columns: [
					{data: 'id'},
					{data: 'name'},
					{data: 'email'},
					{data: 'points_count'},
					{data: 'points_count_rewarded'},
					{data: 'points_count_total'},
					{data: 'total_purchased'},
					{data: 'points_amount'},
					{data: 'details'},
				]
			});
		});
		</script>
	@endpush
	@endsection
