@extends('admin.layout.index',[
'title' => _i('Requested products'),
'subtitle' => _i('Requested products'),
'activePageName' => _i('Requested products'),
'activePageUrl' => '',
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] )

@section('content')
    <div class="row">
		<a class="nav-link  btn btn-primary mr-3"  href="{{route('allProductsQr')}}">{{ _i('Print All Qr') }}
		</a>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ _i('Requested products') }}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                        <table id="dataTable" class="table table-bordered table-striped dataTable text-center">
                            <thead>
                                <tr role="row">
                                    <th> {{ _i('ID') }}</th>
                                    <th> {{ _i('Title') }}</th>
                                    <th> {{ _i('image') }}</th>

                                </tr>
                            </thead>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        /* body .img-rounded  {
                         display: none;
                         } */
        @media print {
            body * {
                display: none;
            }

            body .img-rounded {
                display: block;
            }
        }

    </style>
@endpush
@push('js')
    <script type="text/javascript">
        function printMe(id) {
            var src = $("#img-" + id).attr("src");
            popup = window.open(src, "print");
             $(popup).off("load").on("load", function() {
                this.print();
            });
            setTimeout(function() {
                popup.close();
            }, 3000);
        }
        $(function() {

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.qr') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'product_details '
                    },
                    {
                        data: 'photo',
                        name: 'title'
                    },

                ]
            });
        });
    </script>
@endpush
