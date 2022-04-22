@extends('admin.layout.index',
[
    'title' => _i('Translate Color Group'),
    'subtitle' => _i('Translate Color Group'),
    'activePageName' => _i('Translate Color Group'),
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
                <div class="card-block">
                    <table id="translateColor" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>translate Label</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($rowData as $key =>$row)
                                @if($row->data != null)

                                    <tr>
                                    <th>{{$row->data->id}}</th>
                                    <td>{{$row->data->title}}</td>
                                    <td><input name="word[{{$row->data->id}}]" value="@if ($rowsDataOtherLang[$key]->data !=null)@if ($row->data->id == $rowsDataOtherLang[$key]->data->source_id){{$rowsDataOtherLang[$key]->data->title}}@endif @endif">
                                    </td>
                                </tr>
                                    @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="form-group">
                    <button id="submit_XoIaA21" type="submit"
                            class="btn btn-block btn-success submit">{{_i('Translate')}}</button>
                    {{--<a class="btn btn-block btn-danger" href="{{route('translation.index')}}" role="button">{{_i('Back')}}</a>--}}
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#translateColor').DataTable({});
        });


        $('#from_table').on('submit', function (e) {
            e.preventDefault();
            form_data = $('#from_table').serialize();
            $.ajax({
                "url": "{{route('admin.colorGroup.translate')}}",
                "type": "post",
                "data": form_data,
                success: function (res) {
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>
@endpush