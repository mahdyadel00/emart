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
                        <h5>{{_i('Refund products')}}</h5>
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
                                        <th> {{_i('Product')}}</th>
                                        <th> {{_i('Refund reason')}}</th>
                                        <th> {{_i('Refund amount')}}</th>
                                        <th> {{_i('Cost on')}}</th>
                                        <th> {{_i('Refund date')}}</th>
                                        <th> {{_i('Order date')}}</th>
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
				ajax: '{{ route('reports.refund') }}',
				columns: [
					{data: 'id'},
					{data: 'product'},
					{data: 'refund_reason'},
					{data: 'refund_amount'},
					{data: 'cost_on'},
					{data: 'refund_date'},
					{data: 'order_date'},
					{data: 'details'},
				]
			});
		});
		</script>
	@endpush
	@endsection
