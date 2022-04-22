@extends('admin.layout.index',
[
'title' => _i('Shipping'),
'subtitle' => _i('Shipping'),
'activePageName' => _i('Shipping'),
'activePageUrl' => route('shipping.index'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index') ,
])

@push('css')
    <style>
        .modal-header {
            background-color: #5cd5c4;
            border-color: #5cd5c4;
            color: #fff;
        }

    </style>
@endpush

@section('content')
    <div class="col-xs-5 form-group">
        <a class="btn btn-primary  btn-round col-sm-3 create" id="add-btn" href="{{ route('shipping.create') }}">
            <i class="fa fa-plus"></i>{{ _i('New shipping company') }}</a>
        {{ _i('Number of registeed comapny') }} :{{ $companies->count() }}
    </div>
    <div class="page-body">
        <div class="row">

            @if (count($companies) > 0)
                @foreach ($companies as $company)
                    <div class="col-sm-4 ">
                        <div class="card">
                            <div class="card-block">
                                <div class="card-body card-block text-center">
                                    <div class="component-image">

                                        <img src="{{ $company['logo'] != null ? asset($company['logo']) : asset('images/placeholder.png') }}"
                                            style="max-width: 150px;">
                                    </div>
                                    <p class="component-desc">
                                        <b>{{ $company['title'] }}</b>
                                    </p>

                                    <input type="checkbox" class="js-switch" value="free"
                                        onchange="status(this,{{ $company->id }})" title="{{ _i('Free Shipping') }}"
                                        @if ($company->shipping_type == 'free') checked @endif name="free_shipping" id="free_shipping" />

                                    {{ _i('Free Shipping') }}

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <div class="dropdown-default dropdown open">
                                    <button class="btn btn-warning  dropdown-toggle waves-effect waves-light " type="button"
                                        id="dropdown1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true"><span class="ti ti-settings"></span></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown1" data-dropdown-in="fadeIn"
                                        data-dropdown-out="fadeOut">
                                        @foreach ($languages as $lang)

                                                <a href="#" data-toggle="modal" data-target="#langedit"
                                                    class="lang_ex dropdown-item waves-light waves-effect" data-id="{{ $company->id }}"
                                                    data-lang="{{ $lang->id }}"
                                                   >{{ $lang->title }}</a>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- <button type="button" class="btn btn-warning dropdown-toggle  float-none"
                                    data-toggle="dropdown" title="Translation">
                                    <span class="ti ti-settings"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($languages as $lang)
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex"
                                                data-id="{{ $company->id }}" data-lang="{{ $lang->id }}"
                                                style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a>
                                        </li>
                                    @endforeach
                                </ul> --}}
                                <a class="btn text-white bg-success "
                                    href="{{ route('shipping.edit', $company->id) }}"><i
                                        class="ti ti-clipboard">{{ _i('Edit') }}</i>
                                </a>
                                <a class="btn btn-danger " href="{{ url('admin/shipping/company/delete/' . $company->id) }}">

                                    <i class="ti ti-trash">{{ _i('Delete') }}</i>

                                </a>

                            </div>
                        </div>
                    </div>


                @endforeach
            @endif
        </div>
    </div>

    {{-- <a href="#" data-toggle="modal" data-target="#free_shipping" class="btn btn-default get_link"  >
		<i class="ti-link"></i>ssssssssss</a> --}}
    {{-- @include('admin.shipping.companies.free_shipping') --}}

    @include('admin.shipping.companies.translate')

@endsection
@push('js')
    <script type="text/javascript">
        function status(obj, id) {

            var bol = $(obj).is(":checked");
            $.ajax({
                url: "shipping/" + id,
                type: "Post",
                data: {
                    status: bol,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    if (response.status == 'ok') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "Saved Successfully",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_edit').modal('hide');
                        //table.ajax.reload();
                    }
                }
            });
        }
    </script>

@endpush
