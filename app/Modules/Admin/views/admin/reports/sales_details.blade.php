@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#balance" data-toggle="tab" aria-expanded="false">{{ _i('History') }}</a></li>
                </ul>
				<div class="tab-content">
					<div class="tab-pane active" id="balance">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>{{ _i('ID') }}</td>
                                <td>{{ _i('Day') }}</td>
                                <td>{{ _i('Product') }}</td>
                                <td>{{ _i('price') }}</td>
                            </tr>
                            @foreach( $orders AS $order )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->day }}</td>
                                <td>{{ product_name($order->product_id) }}</td>
                                <td>{{ $order->price }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
