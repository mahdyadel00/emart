@extends('admin.layout.index',
[
	'title' => _i('Order Request'),
	'subtitle' => _i('Order Request'),
	'activePageName' => _i('Order Request'),
	'activePageUrl' => route('order_request.index'),
	'additionalPageName' =>  _i('Order Request'),
	'additionalPageUrl' => route('order_request.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		{{-- <div class="col-sm-12 mb-3">
			<span class="pull-left">
			<button id="create_new" class="btn btn-primary create add-permissiont" type="button" data-toggle="modal"
				data-target="#modal-default">
				<span><i class="ti-plus"></i> {{_i('Create new job')}} </span>
			</button>
			</span>
		</div> --}}
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Orders')}}</h5>
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
									<th>#</th>
									<th>{{ _i('First Name') }}</th>
                                   <th>{{ _i('Last Name') }}</th>
                                   <th>{{ _i('Mobile') }}</th>
                                   <th>{{ _i('Address') }}</th>
                                   <th>{{ _i('Tax Number') }}</th>
                                   <th>{{ _i('CR Number') }}</th>
                                   <th>{{ _i('Is Company') }}</th>
									<th>{{ _i('Created at') }}</th>
									<th>{{ _i('Options') }}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	let table = $('.dataTable').DataTable({
		order: [],
		processing: true,
		serverSide: true,
		ajax: '{{route('order_request.index')}}',
		columns: [
			{data: 'id', name: 'id'},
			{data: 'first_name', name: 'first_name'},
			{data: 'last_name', name: 'last_name'},
			{data: 'mobile', name: 'mobile'},
			{data: 'address', name: 'address'},
			{data: 'tax_number', name: 'tax_number'},
			{data: 'cr_number', name: 'cr_number'},
			{data: 'is_company', name: 'is_company'},
			{data: 'created_at', name: 'created_at'},
			{data: 'options', name: 'options'}
		]
	});

	$(document).on('click', '#create_new', function()
	{
		$('#add-form').find('textarea').val('');
		$('#add-form').find('select').val('');
		$('input[name="status"]').prop('checked', true);
	});


	$(document).on('click', '.edit-row', function()
	{
		let url = $(this).data('url');
        let id = $(this).data('id')
        let title = $(this).data('title')
        let description = $(this).data('description')
        $('#modal-id').val(id)
        $('#edit-title').val(title)
        $('#edit-desc').val(description)
	});

	$(document).on('submit', '#add-form', function (e)
	{
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				if( response === 'success' )
				{
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Saved successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal').modal('hide');
					$('.dataTable').DataTable().draw(false);
				}
			},
		});
	});



	$(document).on('submit', '#edit-form', function (e)
	{
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				if( response==='success' )
				{
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal').modal('hide');
					$('.dataTable').DataTable().draw(false);
				}
			},
		});
	});

	$(document).on('click', '#btn-delete-job', function (e)
	{
        e.preventDefault();
        let id = $(this).data('id')
        let url = "{{route('jobs.delete', 'id')}}"
        url = url.replace('id', id)
        $.ajax({
            url: url,
            method: 'get',
            success: function (res){
                new Noty({
                    type: 'success',
                    layout: 'topRight',
                    text: "{{ _i('Deleted successfully')}}",
                    timeout: 2000,
                    killer: true
                }).show();
                $('.dataTable').DataTable().draw(false);
            }
        })
	});

	$(document).on('click', '.lang_ex', function (e) {
		e.preventDefault();
        $('#lang_submit').find('textarea').val('');

            let transRowId = $(this).data('id');
		let lang_id = $(this).data('lang');
        let desc = $(this).data('description');
        let title = $(this).data('title');
        $('#id_data').val(transRowId)
        $('#lang_id_data').val(lang_id)
        $('#trans-title').val(title)
        $('#trans-desc').val(desc)

        // get lang title
        $.ajax({
            url: '{{route('all_langs')}}',
            method: "get",
            data: {
                lang_id: lang_id,
            },
            success: function (response) {
                $('#header').empty();
                $('#header').text('Translate to : ' + response);
            }
        }); // end get language title
	});

	$(document).on('submit', '#lang_submit', function (e)
	{
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				if (response.errors){
					$('#masages_model').empty();
					$.each(response.errors, function(index, value) {
						$('#masages_model').show();
						$('#masages_model').append(value + "<br>");
					});
				}
				if (response==='SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Translated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.dataTable').DataTable().draw(false);
					$('.modal.modal_create').modal('hide');
                    $('#trans-title').val('')
                    $('#trans-desc').val('')
				}
			},
		});
	});
</script>
@endpush
