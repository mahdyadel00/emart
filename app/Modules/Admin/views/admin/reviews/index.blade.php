@extends('admin.layout.index',
[
	'title' => _i('Reviews'),
	'subtitle' => _i('Reviews'),
	'activePageName' => _i('Reviews'),
	'activePageUrl' => route('reviews.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('reviews.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
			<button class="btn btn-primary create-review add-permissiont" type="button" data-toggle="modal"
				data-target="#modal-default-review">
				<span><i class="ti-plus"></i> {{_i('Create new review')}} </span>
			</button>
			</span>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Reviews')}}</h5>
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
									<th>{{ _i('Stars') }}</th>
									<th>{{ _i('Comment') }}</th>
									<th>{{ _i('Published') }}</th>
									<th>{{ _i('User Name') }}</th>
                                    <th>{{ _i('Time Created') }}</th>
                                    <th>{{ _i('Last Edition') }}</th>
                                    <th>{{ _i('Action') }}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade modal_create" id="read-more" aria-hidden="true">
        <div class="modal-dialog" style="top: 50% !important;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>{{ _i('Message Content')}}</b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="cursor: pointer" aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body read_more_body">
                    <span></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ _i('close') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
@include('admin.reviews.modal')
@endsection
@push('js')
<script>
	var table = $('.dataTable').DataTable({
		order: [],
		processing: true,
		serverSide: true,
		ajax: '{{route('reviews.index')}}',
		columns: [
			{data: 'id', name: 'id'},
			{data: 'stars', name: 'stars'},
			{
                data: function (o) {
                    if (o.comment.length < 17){
                        return o.comment
                    }
                    else {
                        return  '<a href class="text-decoration-none read-more" data-fulldata="'+o.comment+'" data-toggle="modal" data-target="#read-more">' + o.comment.substring(0, 15) + '...more</a>';
                    }
                    // return '<a href="" data-comment="' + o.comment + '" class="text-decoration-none read-more">' + o.comment.substring(0, 20) + '...more</a>'
                }
            },
            {data: 'published', name: 'published'},
            {data: 'username', name: 'username'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
			{data: 'action', name: 'action'}
		]
	});

	$(document).on('click', '.create-review', function()
	{
        if (CKEDITOR.instances.editor2) {
            CKEDITOR.instances.editor2.destroy();
        }
		$('input[name="status"]').prop('checked', true);
	});
    $(document).on('click', '.read-more', function (event) {
        let body = $(this).data('fulldata')
        $('.read_more_body span').empty().text(body)
    })
	$(document).on('click', '.edit-row', function()
	{
        if (CKEDITOR.instances.editor1) {
            CKEDITOR.instances.editor1.destroy();
        }
        let id = $(this).data('id')
        let comment = $(this).data('comment')
        let status = $(this).data('status')
        let stars = $(this).data('stars')
        if(status === 1){
            $('input[name="published"]').prop('checked', true);
        }else {
            $('input[name="published"]').prop('checked', false);
        }
        $('#stars').val(stars).change()
        $('#id').val(id)
        $('#editor1').val(comment);
        CKEDITOR.replace('editor1', {
            extraPlugins: 'colorbutton,colordialog',
            filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",
            filebrowserUploadMethod: 'form'
        });
    });

	$('body').on('submit', '#add-review-form', function (e)
	{
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
                    $('#rev-stars').val(5).change()
                    $('input[name="published"]').prop('checked', true);
                    if (CKEDITOR.instances.rev) {
                        CKEDITOR.instances.rev.setData('');
                    }
					$('.dataTable').DataTable().draw(false);
				}
			},
		});
	});
	$('body').on('submit', '#edit-review-form', function (e)
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

	$(document).on('click', '.btn-delete-review', function (e)
	{
		e.preventDefault();
        let id = $(this).data('id')
		{{--let url = "{{url('reviews/destroy')}}/"+id;--}}
        // url = url.replace('id', id)
        let url = "{{route('reviews.destroy', 'id')}}"
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

</script>
@endpush
