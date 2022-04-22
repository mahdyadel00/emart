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
			<a href="#" class='btn btn-primary mb-2' data-toggle='modal' data-target='#add-Modal'>
				{{ _i('Create new Country') }}
			</a>
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
									<th class="text-center">{{_i('Cities')}}</th>
									<th class="text-center">{{_i('Status')}}</th>
									<th class="text-center">{{_i('Code')}}</th>
									<th></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admin.settings.countries.trans')
@endsection
@push('js')
<script  type="text/javascript">
	$(function () {
	    var table = $('#countries_table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: "{{ route('countries.index') }}",
	        columns: [
	            {data: 'id'},
	            {data: 'title', name:'countries_data.title'},
	            {data: 'cities', searchable: false},
	            {data: 'status'},
				{data: 'calling_code'},
				{data: 'options'},
	        ]
		});
		table.on( 'draw', function () {
			console.log( 'Redraw occurred at: '+new Date().getTime() );
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-table'));
			elems.forEach(function(html) {
				var switchery = new Switchery(html, { size: 'small' });
			});
		});
	});

    $(document).on('click', '.edit-row', function(){
        var url = $(this).data('url');
        $.ajax({
            url: url,
            method: "get",
            success: function (response) {

				$('#edit-form .modal-title').val(response.data['title']);
				$('#edit-form .modal-code').val(response.calling_code);
                $('#edit-form .modal-order').val(response.order)
                $('#modal-id').val(response.id)
            }
        });
    });
    $('body').on('submit', '#add-form', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: "post",
            data: new FormData(this),
            dataType: 'json',
            cache       : false,
            contentType : false,
            processData : false,
            success: function (response) {
                $('.modal').modal('hide');
                $('#countries_table').DataTable().draw(false);
            },
        });
    });
    $('body').on('submit', '#edit-form', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: "post",
            data: new FormData(this),
            dataType: 'json',
            cache       : false,
            contentType : false,
            processData : false,
            success: function (response) {
                $('.modal').modal('hide');
                $('#countries_table').DataTable().draw(false);
            },
        });
    });
    $('#countries_table').on('click', '.btn-delete[data-url]', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true}
        }).always(function (data) {
            $('#countries_table').DataTable().draw(true);
        });
    });


    $('body').on('click', '.lang_ex', function (e) {
        e.preventDefault();
        var transRowId = $(this).data('id');
        var lang_id = $(this).data('lang');
        $.ajax({
            url: '{{route('countries.get.translation')}}',
            method: "get",
            "_token": "{{ csrf_token() }}",
            data: {
                'lang_id': lang_id,
                'transRow': transRowId,
            },
            success: function (response) {
                if (response.data == 'false'){
                    $('#titletrans').val('');
                    $('#editor1').val('');
                } else{
                    // console.log(response);
                    $('#titletrans').val(response.data.title);
                    $('#id_data').val(transRowId);
                    $('#lang_id_data').val(lang_id);
                    // CKEDITOR.instances.editor1.setData(response.data.name);
                }
            }
        });
    });

    $('body').on('submit', '#lang_submit', function (e) {
        //alert('test');
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
                    // new Noty({
                    // 	type: 'success',
                    // 	layout: 'topRight',
                    // 	text: "{{ _i('Translated Successfully')}}",
                    // 	timeout: 2000,
                    // 	killer: true
                    // }).show();
                    $('#countries_table').DataTable().draw(true);
                    $('.modal.modal_create').modal('hide');
                }
            },
        });
    });

	$(document).on('change', '.change_status_country' , function() {
		var url = '{{route('change.status.country.and.store')}}';
		var country_id = $(this).data('countryid');

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
			data: {'checked' : checked , 'country_id' :  country_id },
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
