@extends('admin.layout.index',
[
'title' => _i('Order Request'),
'subtitle' => _i('Order Request'),
'activePageName' => _i('Order Request'),
'activePageUrl' => route('order_request.index'),
'additionalPageName' => _i('Order Request'),
'additionalPageUrl' => route('order_request.index')
])
@section('content')
    <div class="box-body">
        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ _i('Orders') }}</h5>
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
                                        <th>{{ _i('Price') }}</th>
                                        <th>{{ _i('Cost ') }}</th>
                                        <th>{{ _i('Code') }}</th>
                                        <th>{{ _i('Discount') }}</th>
                                        <th>{{ _i('Delivary') }}</th>
                                        <th>{{ _i('Created at') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_request->products as $product)
                                        <tr>

                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->detailes ? $product->detailes->title : '' }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->cost }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->discount }}</td>
                                            <td>{{ $product->delivary }}</td>
                                            <td>{{ $product->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
