@extends('admin.layout.index')
@section('title')
    {{ _i('Color Group') }}
@endsection
@section('page_header_name')
    {{ _i('Color Group') }}
@endsection


<style>
    .bt_colorGroup{
        margin-right: 61%;
    }
</style>


@section('content')

    <!-- Page-body start -->

    <div class="row">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ _i('Color Group') }}</h5>

                    <a href="{{ route('admin.colorGroup.getData') }}" class="btn btn-primary bt_colorGroup">
                        {{ _i('Translate Color Group') }}
                    </a>

                </div>
                <div class="card-block">

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.colorGroup.store') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-5">

                                        <input class="form-control load" placeholder="{{ _i('Color Group name ...') }}"
                                            type="text" name="title" required>

                                    </div>
                                    <div class="col-sm-5 m-b-30">
                                        <input type="text" id="text-field" style="width:200px;height:35px"
                                            class="form-control demo" value="#70c24a" name="color">
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-info">
                                                {{ _i('Add') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">

                                            @foreach ($feature_oprions as $feature)
                                                @if ($feature !== null)
                                                    <div class="custom-control custom-checkbox">

                                                        <label class="custom-
                                -label"
                                                            for="filterCheck{{ $feature->id }}">
                                                            <span class="coloring-options">
                                                                <div class="backGround-colorGroup"
                                                                    style="background-color: {{ $feature->title }};">
                                                                </div>
                                                            </span>
                                                            {{ $feature->name ?? $feature->title }}
                                                            <input type="checkbox" name='filter[]'
                                                                class="checkbox-colorGroup"
                                                                id="filterCheck{{ $feature->id }}"
                                                                value="{{ $feature->id }}">
                                                        </label>

                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class=" col-md-4">
            <div class="card">
                <div class="card-block">

                    <div class="row">

                        @foreach ($colorGroups as $group)
                            <div class="row" id="group_{{ $group->id }}">

                                <div class="col-sm-4 ">
                                    <div style="background:  {{ $group->color }}" class="">&nbsp;</div>
                                </div>
                                <div class="col-sm-4">


                                    <a class="dropdown-item groupColorDetail" href="#" data-id="{{ $group->id }}"
                                        data-toggle="modal" data-target="#groupColor">

                                        {{ $group->data->title ?? '' }}
                                    </a>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <button class="btn btn-info remove" data-id="{{ $group->id }}">
                                            {{ _i('Remove') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>

    </div>



    <div id="groupColor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content" style="width:140%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                    <h4 class="modal-title" id="custom-width-modalLabel" style="color: white;">
                        {{ _i('Edit Color Group') }}</h4>
                    <span id="pro_id"></span>
                </div>
                <div class="modal-body" id="appendDiv">

                </div>

            </div>
        </div>
    </div>


@endsection

@push('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin_dashboard/assets/pages/jquery-minicolors/css/jquery.minicolors.css') }}" />
    <!-- Style.css -->

@endpush
@push('js')
    <script type="text/javascript"
        src="{{ asset('admin_dashboard/assets/pages/jquery-minicolors/js/jquery.minicolors.min.js') }}"></script>
    <script>
        $('body').on('click', '.remove[data-id]', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('admin.colorGroup.delete', '/id') }}";
            url = url.replace('/id', id)
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                // data: {method: '_DELETE', submit: true},
                success: function(response) {
                    if (response == 'success') {
                        $('#group_' + id).remove();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('detail deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }

                },
            })
        });


        $('body').on('click', '.groupColorDetail[data-id]', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('admin.colorGroup.getAjax', '/id') }}";
            url = url.replace('/id', id)
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                // data: {method: '_DELETE', submit: true},
                success: function(response) {
                    console.log(response)
                    $('#appendDiv').empty()
                    $('#appendDiv').html(response)
                    $('#row_product_id').val(id)
                    $(".demo").each(function() {
                        $(this).minicolors();
                    });

                },
            })
        });



        $(document).ready(function() {

            $(".demo").each(function() {
                $(this).minicolors();
            });
            //.minicolors();
            $("#submitBtn").click(function() {
                $("#myForm").submit(); // Submit the form
            });
        });
    </script>
@endpush
