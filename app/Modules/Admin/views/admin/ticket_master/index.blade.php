@extends('admin.layout.index',[
	'title' => _i('Tickets'),
	'subtitle' => _i('Tickets'),
	'activePageName' => _i('Tickets'),
	'activePageUrl' => route('ticket.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
<div class="row">
	<!-- <div class="col-sm-12 ">
		<span class="pull-left">
			<a href="{{ route('user.create') }}" class="btn btn-primary create add-permission">
				<i class="ti-plus"></i>{{ _i('create new ticket') }}
			</a>
		</span>
	</div> -->
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('All Tickets') }}</h5>
				<div class="card-header-right">
					<i class="icofont icofont-rounded-down"></i>
					<i class="icofont icofont-refresh"></i>
					<i class="icofont icofont-close-circled"></i>
				</div>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive text-center">
					{!! $dataTable->table(['class'=> 'table table-bordered table-striped table-responsive'],true) !!}
				</div>
			</div>
		</div>
	</div>
</div>

@push('js')
	{!! $dataTable->scripts() !!}
@endpush
<style>
	.table {
		display: table !important;
	}
</style>
@endsection
