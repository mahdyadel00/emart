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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Inactive customers')}}</h5>
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
                                        <th> {{_i('Name')}}</th>
                                        <th> {{_i('Email')}}</th>
                                        <th> {{_i('Phone')}}</th>
                                        <th> {{_i('Last purchased date')}}</th>
                                        <th> {{_i('Last seen date')}}</th>
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

    <div class="modal fade" id="add-balance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _i('Send email') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='{{ route('reports.inactive.customers.send.email') }}' id='add-balance-form' method='post'>
                        @csrf
                        <input type="hidden" name='user_id' class='inactive-user-id'>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{ _i('Subject') }}:</label>
                            <input type="text" name='subject' class="form-control">
                            <label for="recipient-body" class="col-form-label">{{ _i('Body') }}:</label>
                            <textarea name='body' class="form-control" rows=7></textarea>
                            {{-- <input type="checkbox" name='select_all' id='send-to-all'> --}}
                            {{-- <label for="send-to-all" class="col-form-label">{{ _i('Send to all users') }}</label> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary" form='add-balance-form'>{{ _i('Send') }}</button>
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
				ajax: '{{ route('reports.inactive.customers') }}',
				columns: [
					{data: 'id'},
					{data: 'name'},
					{data: 'email'},
					{data: 'phone'},
					{data: 'last_purchased_date'},
					{data: 'last_seen_date'},
					{data: 'details'},
				]
			});
        });

        $('body').on('click', '.inactive-send-mail', function(){
            var id = $(this).data('id');
            $('.inactive-user-id').val(id);
        })

        $('body').on('submit','#add-balance-form',function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: '{{ route('mail.coupon') }}',
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache       : false,
                contentType : false,
                processData : false,
                error: function( response ){
                    new Noty({
                            type: 'warning',
                            layout: 'topRight',
                            text: response.responseJSON.message,
                            timeout: 5000,
                            killer: true
                        }).show();
                },
                success: function (response) {
                    if (response == 'success'){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
							text: "{{ _i('Mail sent successfully')}}",
                            timeout: 2000,
                            killer: true
						}).show();
						$('.modal').modal('hide');
                    }
                },
            });
        });
		</script>
	@endpush
	@endsection
