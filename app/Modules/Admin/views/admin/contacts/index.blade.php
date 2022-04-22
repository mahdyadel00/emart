@extends('admin.layout.index',
[
	'title' => _i('Contacts'),
	'subtitle' => _i('Contacts'),
	'activePageName' => _i('Contacts'),
	'activePageUrl' => route('contacts.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('contacts.index')
])
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-3">
            </div>
            <div class="col-sm-12">
                @if(session('message'))
                    <div class="alert alert-success" role="alert">{{session()->get('message')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Contacts')}}</h5>
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
                                    <th>{{ _i('Name') }}</th>
                                    <th>{{ _i('Type') }}</th>
                                    <th>{{ _i('Email') }}</th>
                                    <th>{{ _i('Phone') }}</th>
                                    <th>{{ _i('City') }}</th>
                                    <th>{{ _i('Message') }}</th>
                                    <th>{{ _i('Created at') }}</th>
                                    <th>{{ _i('option') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_create" id="modal_create" aria-hidden="true">
            <div class="modal-dialog" style="top: 50% !important;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b>{{ _i('Message Content')}}</b>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="cursor: pointer" aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <span></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ _i('close') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        $('.dataTable').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: "{{route('contacts.index')}}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'city', name: 'city'},
                {
                    data: function (o) {
                        if (o.message.length < 17){
                            return o.message
                        }
                        else {
                            return  '<a href class="text-decoration-none read-more" data-fulldata="'+o.message+'" data-toggle="modal" data-target="#modal_create">' + o.message.substring(0, 15) + '...more</a>';
                        }
                        // return '<a href="" data-comment="' + o.comment + '" class="text-decoration-none read-more">' + o.comment.substring(0, 20) + '...more</a>'
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'option', name: 'option'}
            ]
        });
        $(document).on('click', '.read-more', function (event) {
            let body = $(this).data('fulldata')
            $('.modal-body span').empty().text(body)
        })
    </script>
@endpush
