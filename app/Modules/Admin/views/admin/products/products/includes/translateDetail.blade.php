@extends('admin.layout.index',
[
'title' => _i('Translate Detail'),
'subtitle' => _i('Translate Detail'),
'activePageName' => _i('Translate Detail'),
'activePageUrl' => '',
'additionalPageName' => '',
'additionalPageUrl' => '',
])

@section('content')
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page">
            <form id="from_table">
                @csrf
                {{-- <input type="hidden" name="id" value="{{$id}}"> --}}
                <div class="card-block">
                    <table id="translateDetail" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ _i('Label') }}</th>
                                <th>{{ _i('Label Translation') }}</th>
                                <th>{{ _i('Value') }}</th>
                                <th>{{ _i('Value Translation') }}</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @php
                                $occur = [];
                            @endphp
                            @foreach ($rows as $key => $row)
                                @if ($row->Label->Data->where('lang_id', Lang::getSelectedLangId())->first() != null && $row->Data->where('lang_id', Lang::getSelectedLangId())->first() != null)
                                    <tr>
                                        <td>
                                            {{ $row->id }}
                                        </td>
                                        <td>
                                            {{ $row->Label->Data->where('lang_id', Lang::getSelectedLangId())->first()->title }}
                                        </td>
                                        <td>
                                            <input name="word[{{ $row->id }}][]"
                                                value="{{ $row->Label->Data->where('lang_id', '!=', Lang::getSelectedLangId())->first()->title ?? '' }}">
                                        </td>
                                        <td>
                                            {{ $row->Data->where('lang_id', Lang::getSelectedLangId())->first()->value ?? '' }}
                                        </td>
                                        <td>
                                            @if ($row->Data->where('lang_id', Lang::getSelectedLangId())->first() != null)
                                                <input name="value[{{ $row->id }}][]"
                                                    value="{{ $row->Data->where('lang_id', '!=', Lang::getSelectedLangId())->first()->value ?? '' }}"
                                                    id="{{ $row->id }}">
                                                <button class="btn btn-info btn-sm" id="btn-sync"
                                                    data-original="{{ $row->Data->where('lang_id', Lang::getSelectedLangId())->first()->value }}"
                                                    data-id="{{ $row->id }}"><i class="fa fa-refresh"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody> --}}
                    </table>

                </div>
                <div class="form-group">
                    <button id="submit_XoIaA21" type="submit"
                        class="btn btn-block btn-success submit">{{ _i('Translate') }}</button>
                    {{-- <a class="btn btn-block btn-danger" href="{{route('translation.index')}}" role="button">{{_i('Back')}}</a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var arr_labels = @json($labels);
        $(document).ready(function() {
            // $('#translateDetail').DataTable({

            // });
            // let id = window.location.href.split("/").pop();
            var url_string = window.location.href;
            var url = new URL(url_string);
            var id = url.searchParams.get("id");
            // console.log(id);
            var url = "{{ url('admin/getTranslateDetail') }}";
            var table = $('#translateDetail').DataTable({
                processing: true,
                "serverSide": true,
                "paging": true,
                "bSortable": true,
                ajax: {
                    url: url,
                    data: {
                        "id": id
                    },
                },
                pageLength: 10,
                columns:
                [
                    {
                        name: 'item_id',
                        data: 'item_id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                         name: 'trans_title',
                         data: 'trans_title',

                        render: function(data, type, row) {

                                let dataa = '';
                                key = row.lable_id;
                                 if (row.trans_title != null) {
                                 dataa = row.trans_title
                                } else {
                                    if (arr_labels.hasOwnProperty(key))
                                        dataa = arr_labels[key];
                                }
                                return `<input name="word[${row.item_id}][]" value="${dataa}">`

                        }


                    },
                    {
                        data: 'value',
                    },
                    {
                        name: 'trans_val',
                        data: 'value',
                        render: function(data, type, row) {

                            let dataa = '';
                            if (row.trans_val != null) {
                                dataa = row.trans_val
                                return `<input name="value[${row.item_id}][]" value="${dataa}" id="${row.item_id}"><button class="btn btn-info btn-sm" id="btn-sync" data-original="${row.value}" data-id="${row.item_id}"><i class="fa fa-refresh"></i></button>`
                            } else {
                                return `<input name="value[${row.item_id}][]" value="${dataa}" id="${row.item_id}">`
                            }
                        }
                    },

                ],

            });


            $(document).on('click', '#btn-sync', function(e) {
                e.preventDefault();
                let original = $(this).data('original');
                let id = $(this).data('id');
                let value = $(`#${id}`).val();
                // console.log(original, id, value);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('sync.translation') }}",
                    method: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: {
                        'original': original,
                        'value': value
                    },
                    success: function(res) {
                        if (res == 'success') {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{ _i('Synced Successfully!') }}",
                                showConfirmButton: false,
                                timer: 2000
                            })
                            table.ajax.reload(null, false);
                        }
                    },
                });
            });

            $('#from_table').on('submit', function(e) {
                e.preventDefault();
                form_data = $('#from_table').serialize();
                $.ajax({
                    "url": "{{ route('admin.translation.store') }}",
                    "type": "post",
                    "data": form_data,
                    success: function(res) {
                        if (res == 'success') {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{ _i('Saved Successfully !') }}",
                                showConfirmButton: false,
                                timer: 5000
                            })
                            table.ajax.reload(null, false);
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
