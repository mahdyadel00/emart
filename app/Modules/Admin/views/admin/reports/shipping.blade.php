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
                        <h5>{{_i('Shipping')}}</h5>
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
                                        <th> {{_i('Order number')}}</th>
                                        <th> {{_i('Shipping cost')}}</th>
                                        <th> {{_i('Shipping cost on')}}</th>
                                        <th> {{_i('Shipping cost on reason')}}</th>
                                        <th> {{_i('Order date')}}</th>
                                        <th> {{_i('Shpping date')}}</th>
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
				ajax: '{{ route('reports.shipping') }}',
				columns: [
					{data: 'id'},
					{data: 'order_number'},
					{data: 'shipping_cost'},
					{data: 'shipping_cost_on'},
					{data: 'shipping_cost_on_reason'},
					{data: 'order_date'},
					{data: 'shipping_date'},
				]
			});
		});
		</script>
	@endpush
	@endsection
