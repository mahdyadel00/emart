@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports').' | <a href="reports/google">Google Analytics</a>',
	'activePageName' => _i('Reports'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
<div class="page-body">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>1</h3>
					<p>{{ _i('Products prices') }}</p>
				</div>
				<div class="icon">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<a href="{{ route('reports.products.prices') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>3</h3>
					<p>{{ _i('Customers log') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="{{ route('reports.customers.log') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>4</h3>
					<p>{{ _i('Customers balances') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.customers.balances') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>5</h3>
					<p>{{ _i('Customers orders') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.customers.orders') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>6</h3>
					<p>{{ _i('Customers search') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.customers.search') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>7</h3>
					<p>{{ _i('Rewards points') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.rewards.points') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>8</h3>
					<p>{{ _i('Taxes') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.taxes') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>9</h3>
					<p>{{ _i('Shipping') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.shipping') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>10</h3>
					<p>{{ _i('Refund products') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.refund') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>11</h3>
					<p>{{ _i('Sales') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.sales') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>12</h3>
					<p>{{ _i('Discount codes') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.discount') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>13</h3>
					<p>{{ _i('Products visits') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.products.visits') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>14</h3>
					<p>{{ _i('Products purchased') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.products.purchased') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>15</h3>
					<p>{{ _i('Abandoned carts') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.abandoned.carts') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>16</h3>
					<p>{{ _i('Inactive customers') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.inactive.customers') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>17</h3>
					<p>{{ _i('Stock') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.stock') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>18</h3>
					<p>{{ _i('New products') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.new.products') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>19</h3>
					<p>{{ _i('Comments') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.comments') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>21</h3>
					<p>{{ _i('Payments') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.payments') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>{{$countFavorites}}</h3>
					<p>{{ _i('Favorites') }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ route('reports.Fav.products') }}" class="small-box-footer">{{ _i('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
	@endsection
