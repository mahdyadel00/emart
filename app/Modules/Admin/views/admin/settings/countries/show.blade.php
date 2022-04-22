@extends('admin.layout.index',
[
	'title' => _i('Countries'),
	'subtitle' => _i('Countries'),
	'activePageName' => _i('Countries'),
	'activePageUrl' => route('countries.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('All countries')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="countries_table" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="text-center">{{_i('ID')}}</th>
									<th class="text-center">{{_i('Title')}}</th>
									<th class="text-center">{{_i('Country')}}</th>
									<th class="text-center">{{_i('Status')}}</th>
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
<script  type="text/javascript">
	$(function () {
	    var table = $('#countries_table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: "{{ route('countries.show', $country->id) }}",
	        columns: [
	            {data: 'id'},
	            {data: 'title', name:'city_datas.title'},
	            {data: 'ctitle', name: 'countries_data.title', searchable: false},
	            {data: 'status'},
	        ]
		});
		table.on( 'draw', function () {
			console.log( 'Redraw occurred at: '+new Date().getTime() );
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-country'));
			elems.forEach(function(html) {
				var switchery = new Switchery(html, { size: 'small' });
			});
		});
	});

	$('body').on('click','.lang_ex',function (e) {
	    e.preventDefault();
	    var id = $(this).data('id');
	    var lang_id = $(this).data('lang');
	    $.ajax({
	        url: '{{ url('admin/settings/banners/get/lang/value') }}',
	        method: "get",
	        data: {
	            lang_id: lang_id,
	            id: id,
	        },
	        success: function (response) {
	            if (response.data == 'false'){
	                $('#langedit #titletrans').val('');
	                $('#langedit #description_trans').val('');
	            }else{
	                $('#langedit #titletrans').val(response.data.title);
	                $('#langedit #description_trans').val(response.data.description);
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
	                table.ajax.reload();
	            }
	        },
	    });
	});
$(document).on('change', '.change_status_city', function() {
		var url = '{{route('change.status.city.and.store')}}';
		var city_id = $(this).data('cityid');

		if($(this).prop("checked") == true){
			var checked = 1;
		}
		else if($(this).prop("checked") == false){
			var checked = 0;
		}
		$.ajax({
			url: url,
			method: "get",
			"_token": "{{ csrf_token() }}",
			data: {'checked' : checked , 'city_id' :  city_id },
			success: function (response) {
				if (response == 'SUCCESS'){
	                new Noty({
	                    type: 'warning',
	                    layout: 'topRight',
	                    text: "{{ _i('Updated Successfully')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
					$('#countries_table').DataTable().draw(false);
				}
			},
		});
});
</script>
@endpush
