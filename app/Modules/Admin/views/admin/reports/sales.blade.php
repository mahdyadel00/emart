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
            <div class="col-md-12 mb-3" hidden>
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="" id="" class='form-control'>
                                <option value="product_performance">{{ _i('Product performance') }}</option>
                                <option value="sales_by_category">{{ _i('Sales by category') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Sales')}}</h5>
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
                                        <th> {{_i('Month')}}</th>
                                        <th> {{_i('Products count')}}</th>
                                        <th> {{_i('Sales total')}}</th>
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
				ajax: '{{ route('reports.sales') }}',
				columns: [
					{data: 'id'},
					{data: 'month'},
					{data: 'products_count'},
					{data: 'sales_total'},
					{data: 'details'},
				]
			});
		});
		</script>
	@endpush
	@endsection
