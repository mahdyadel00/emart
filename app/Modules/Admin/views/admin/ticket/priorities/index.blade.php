@extends('admin.layout.index',[
	'title' => _i('Ticket Priorities'),
	'subtitle' => _i('Ticket Priorities'),
	'activePageName' => _i('Ticket Priorities'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('ticket.index') ,
	'additionalPageName' => _i('Tickets'),
] )
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
				<button class="btn btn-primary create add-permissiont" type="button" data-toggle="modal" data-target="#create-modal">
					<span><i class="ti-plus"></i> {{_i('Create New Priority')}} </span>
				</button>
			</span>
		</div>
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Ticket Priorities')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
					{!! $dataTable->table([
						'class'=> 'table table-bordered table-striped table-responsive text-center'
					],true) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admin.ticket.priorities.modals')
@push('js')
	{!! $dataTable->scripts() !!}
@endpush
<style>
	.table{
		display: table !important;
	}
	tfoot{
		display: none;
	}
	#dataTableBuilder_length{
		float: left;
	}
</style>
@endsection
@push('js')
<script  type="text/javascript">
	$('body').on('click','.reorder',function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		var order = $(this).data('order');	
		var type = $(this).data('type');	
		$.ajax({
			url: '{{ route('ticket.priority.reorder') }}',
			method: "post",
			data: {
				id: id,
				order: order,
				type: type,
				_token: "{{ csrf_token() }}"
			},
			success: function (response) {
				if (response == 'success'){
	                new Noty({
	                    type: 'success',
	                    layout: 'topRight',
	                    text: "{{ _i('Re-arranged successfully')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                window.LaravelDataTables["dataTableBuilder"].ajax.reload();
				}
			}
		});	    
	})
	$('body').on('click','.lang_ex',function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		var lang_id = $(this).data('lang');	
		$.ajax({
			url: '{{ route('ticket.priority.get_translation') }}',
			method: "get",
			data: {
				lang_id: lang_id,
				id: id,
			},
			success: function (response) {
				if (response.data == 'false'){
					$('#langedit #name').val('');
					$('#langedit #description').val('');
				}else{
					$('#langedit #name').val(response.data.name);
					$('#langedit #description').val(response.data.description);
				}
			}
		});
		$.ajax({
			url: "{{ url('admin/get/lang') }}",
			method: "get",
			data: {
				{{--_token: '{{ csrf_token() }}',--}}
				lang_id: lang_id,
			},
			success: function (response) {
				$('#langedit #header').empty();
				$('#langedit #header').text('Translate to : '+response);
	
				$('#id_data').val(id);
				$('#lang_id_data').val(lang_id);
			}
		});
	});
	
	$('body').on('submit','#lang_submit',function (e) {
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
				console.log(response);
				if (response.errors){
					$('#masages_model').empty();
					$.each(response.errors, function( index, value ) {
						$('#masages_model').show();
						$('#masages_model').append(value + "<br>");
					});
				}
				if (response == 'SUCCESS'){
					new Noty({
						type: 'warning',
						layout: 'topRight',
						text: "{{ _i('Translated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal.modal_trans').modal('hide');
					window.LaravelDataTables["dataTableBuilder"].ajax.reload();
				}
			},
		});
	});
	$('body').on('submit','.remove-record-model',function (e) {
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
				if (response.status == 'deleted'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Deleted Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					window.LaravelDataTables["dataTableBuilder"].ajax.reload();
					$('#delete-modal').modal('hide');
				}
			}
		});
	})
</script>
@endpush