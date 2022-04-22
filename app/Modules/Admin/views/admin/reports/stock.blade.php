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
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="category" class='form-control custom-select reload-datatable category'>
                    <option value=0>{{ _i('Category') }}</option>
                    @foreach( $categories as $category )
                    <option value="{{ $category->category_id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
                        <h5>{{_i('Stock')}}</h5>
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
										<th> {{_i('Category')}}</th>
										<th> {{_i('Type')}}</th>
										<th> {{_i('Available quantity')}}</th>
										<th> {{_i('Total quantity added')}}</th>
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
			var table = $('.dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('reports.stock') }}',
				columns: [
					{data: 'id'},
					{data: 'title'},
					{data: 'category'},
					{data: 'type'},
					{data: 'max_count'},
					{data: 'stock'},
					{data: 'details'},
				]
            });

            $('.reload-datatable').change(function(){
                var category = $('.category').find('option:selected').val();
				table.ajax.url( '{{ route('reports.stock') }}?category=' + category ).load();
			})
		});
		</script>
	@endpush
	@endsection
