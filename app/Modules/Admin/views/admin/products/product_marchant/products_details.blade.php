@extends('admin.layout.index',[
'title' => _i('Products'),
'subtitle' => _i('Products'),
'activePageName' => _i('Products'),
'activePageUrl' => route('reports.index'),
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] )
@section('content')
    <section class="content">
        <div class="row">

            <!-- /.col -->
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#balance" data-toggle="tab"
                                aria-expanded="false">{{ _i('Orders') }}</a></li>

                    </ul>

                    <ul class="pull-left p-2">
                        <li>
                            <form method="post" action="googlesyncAll">
                                @csrf
                                <button type="submit" class="btn btn-primary">{{ _i('Sync All Now') }}</button>
                            </form>
                        </li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane active">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ _i('ID') }}</th>
                                        <td></td>
                                        <th>{{ _i('Name') }}</th>
                                        <th> {{ _i('Price') }}</th>
                                        <th>{{ _i('Last Update') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><img src='{{ asset($product->mainPhoto()) }}' width="100px" /></td>
                                            <td><a
                                                    href="{{ route('home_product.show', ['locale' => "en", 'product' => $product->id]) }}">{{ $product->title }}</a>
                                            </td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->google_update }}</td>

                                            <td>
                                                <form method="post" action="googlesync/{{ $product->id }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ _i('Sync Now') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $products->links() !!}


                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

@endsection
@push('js')

@endpush
