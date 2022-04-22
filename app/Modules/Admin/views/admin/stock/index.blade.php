@extends('admin.layout.index',
[
	'title' => _i('Products Stock'),
	'subtitle' => _i('Products Stock'),
	'activePageName' => _i('Products Stock'),
	'activePageUrl' => route('stocks.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
			{{--<button class="btn btn-primary create add-permissiont" type="button" data-toggle="modal"--}}
				{{--data-target="#modal-in">--}}
			{{--<span><i class="ti-control-forward"></i> {{_i('Update Stock')}} </span>--}}
			{{--</button>--}}

				<a href="{{route('stocks.updateStock')}}"  class="btn btn-primary create add-permissiont" type="button">
					<span><i class="ti-control-forward"></i> {{_i('Update Stock')}} </span>
				</a>

			</span>
		</div>
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
					<div class="dt-responsive table-responsive text-center">
						<table id="slider_table" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="text-center"> {{_i('ID')}}</th>
									<th class="text-center"> {{_i('Product')}}</th>
									<th class="text-center"> {{_i('Quantity')}}</th>
									<th class="text-center"> {{_i('User')}}</th>
									<th class="text-center"> {{_i('Details')}}</th>
									<th class="text-center"> {{_i('Create Time')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admin.stock.create')
{{--@include('admin.stock.edit')--}}
@endsection
@push('js')
<script  type="text/javascript">
	var table;
	$(function () {
	    table = $('#slider_table').DataTable({
			order: [[ 0, "desc" ]],
			order : [[ 0, "desc" ]],
	        processing: true,
	        serverSide: true,
	        ajax: '{{url('admin/stocks')}}',
	        columns: [
	            {data: 'id'},
	            {
					data: 'title',
					name: 'product_details.title'
				},
	            {data: 'quantity'},
				{
					data: 'user_name',
					name: 'users.name'
				},
	            {data: 'details'},
	            {data: 'created_at'},
	        ]
	    });
	});


	$('body').on('submit','#delform',function (e) {
	    e.preventDefault();
	    var url = $(this).attr('action');
	    // alert(url);
	    $.ajax({
	        url: url,
	        method: "delete",
	        data: {
	            _token: '{{ csrf_token() }}',
	        },
	        success: function (response) {
	            // console.log(response);
	            if (response.data === true){
	                new Noty({
	                    type: 'error',
	                    layout: 'topRight',
	                    text: "{{ _i('Deleted Successfully')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                table.ajax.reload();
	            }
	        }
	    });
	})
</script>
@endpush
