@extends('admin.layout.index',[
	'title' => _i('Sounds Playlist'),
	'subtitle' => _i('Sounds Playlist'),
	'activePageName' => _i('Sounds Playlist'),
	'activePageUrl' => route('sounds.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
] )

@section('content')

<div style="clear:both;"></div>
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
			<a href="{{route('sounds.create')}}" class="btn btn-primary create add-permissiont" data-toggle="modal" data-target="#modal_create" type="button"><span><i class="ti-plus"></i> {{_i('Add New sound')}} </span></a>
			</span>
		</div>
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Types')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="sorting"> {{_i('Name')}}</th>
									<th class="sorting"> {{_i('Order')}}</th>
									<th class="sorting"> {{_i('Sound Track')}}</th>
									<th class="sorting"> {{_i('Status')}}</th>
									<th class="sorting"> {{_i('Created At')}}</th>
									<th class="sorting"> {{_i('Control')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('admin.sounds.create')
	@include('admin.sounds.edit')
	@include('admin.sounds.translate')

</div>

@endsection
@push('js')
<script>
	$(function () {
		$('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('sounds.index')}}',
			columns: [
				{data: 'name', name: 'name'},
				{data: 'order', name: 'order'},
				{data: 'sound_track', name: 'sound_track'},
				{data: 'published', name: 'published'},
				{data: 'created_at', name: 'created_at'},
				{data: 'action', name: 'action', orderable: true, searchable: true}
			]
		});
	});
	$(document).on('click', '.set-default', function(e){
		e.preventDefault();
		url = $(this).data('url');
		$.ajax({
			url: url,
			method: "patch",
			data: {
				_token: '{{ csrf_token() }}',
			},
			success: function (response) {
				if (response.data === true){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('#dataTable').DataTable().draw(false);
				}
			}
		});
	})
	$('body').on('click', '.lang_ex', function (e) {
		e.preventDefault();
		var transRowId = $(this).data('id');
		var lang_id = $(this).data('lang');
		$.ajax({
			url: '{{route('sounds.get.translation')}}',
			method: "get",
			"_token": "{{ csrf_token() }}",
			data: {
				'lang_id': lang_id,
				'transRow': transRowId,
			},
			success: function (response) {
				if (response.data == 'false'){
					$('#langedit #name').val('');
				} else{
					$('#langedit #name').val(response.data.name);
				}
			}
		});
		$.ajax({
			url: '{{route('admin.get.lang')}}',
			method: "get",
			data: {
				lang_id: lang_id,
			},
			success: function (response) {
				$('#header').empty();
				$('#langedit #header').text('Translate to : ' + response);
				$('#id_data').val(transRowId);
				$('#lang_id_data').val(lang_id);
			}
		});
	});
	$('body').on('submit', '#lang_submit', function (e) {
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
				if (response == 'SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Translated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal').modal('hide');
				}
			},
		});
	});
	$(document).ready(function () {
		$('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var url = $(this).data('remote');
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE', submit: true}
			}).always(function (data) {
				$('#dataTable').DataTable().draw(false);
			});
		});
	});
</script>
@endpush
