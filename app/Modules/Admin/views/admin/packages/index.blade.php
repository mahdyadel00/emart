@extends('admin.layout.index',[
	'title' => _i('Packages'),
	'subtitle' => _i('Packages'),
	'activePageName' => _i('Packages'),
	'activePageUrl' => route('admin.packages.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
] )

@push('css')
	<style>
		.card-header h5 {
			color: #5cd5c4;
			font-size: 1.5rem;
			font-weight: 700;
			margin-top: 0;
		}
		.plan-top {
			background-position: top 16px center;
			background-size: 60px;
			background-repeat: no-repeat;
			border-bottom: 1px solid #f5f5f5;
			padding: 16px;
			/*padding-top: 72px;*/
		}
		.plan-title {
			color: #29abe2;
			font-size: 25px;
			font-weight: 200;
		}
		.plan-bottom {
			padding: 16px;
		}
		.plan-top {
			background-position: top 16px center;
			background-size: 60px;
			background-repeat: no-repeat;
			border-bottom: 1px solid #f5f5f5;
			padding: 16px;
			padding-top: 72px;
		}
		.plan-title, .plan-price, .plan-period, .plan-currency {
			color: #764aaf !important;
		}
		.plan-price {
			font-size: 80px;
		}
		.text-tiffany {
			color: #5dd5c4;
		}
	</style>
@endpush

@section('content')
	<div class="row">
		<div class="col-sm-12 ">
			<div class="card">
				<div class="card-header">
					<h5>
						<i class="ti-layout position-left"></i>
						{{ _i('Packages') }}
					</h5>
					<div class="card-header-right">
					</div>
					<div class="plan-bottom">
						<div class="">{{_i("You are currently on")}}
							<b>
								@if($store_package != null)
								@php
								$package = \App\Models\Site\Admin\PackageData::where('package_id', $store_package->package_id)->where('lang_id', Lang::getSelectedLangId())->first();
								@endphp
									{{$package->title}}
								@endif
							</b>
							{{_i("Package")}}
						</div>
						<span class="plan-price">
                        	<i class="ti ti-money"></i>
                        	@if($store_package != null)
								{{$store_package->package_plan_price}}
							@endif
						</span>
						<span class="text-tiffany">
                        	<i class="ti ti-check"></i>
                        	{{_i('Expire at')}}
							@if($store_package != null)
							{{$store_package->package_ends_at}}
							@endif
                    </span>
					</div>
				</div>
				<div class="card-block">
					<div class="row users-card">
						@foreach($packages as $package)
							<div class="col-lg-6 col-xl-3 col-md-6">
								<div class="card rounded-card user-card">
									<div class="card-block text-center">
										<div class="plan-top">
											<img src="{{asset('images/star.PNG')}}">
											<h6 class="plan-title">
												<strong>{{$package->title}}</strong>
											</h6>
										</div>
										<div class="plan-bottom">
											@php
											$item = $package;
											$package_plans = \App\Models\Site\Admin\PackagePlan::where('package_id', $item->package_id)->orderby("price")->get();
											@endphp
											@if (count($package_plans) > 0)
											<form action="{{route('admin.packages.buyPackage')}}" method="post">
												@csrf
												<input type="hidden" name="package_id" value="{{$item->package_id}}">
												<div class="p-cell p-price p-package team row">
													@foreach($package_plans as $row)
														@php
														$every = _i('Every') . " " . $row->duration . " " . "Month";
														if ($row->duration == 1)
														{
															$every = _i('Monthly');
														}
														elseif ($row->duration == 3)
														{
															$every = _i('Quarterly');
														}
														elseif ($row->duration == 6)
														{
															$every = _i('Half a year');
														}
														elseif ($row->duration == 12)
														{
															$every = _i('Yearly');
														}
														$price = $row->price . " " . \App\Bll\MyFatoorah::$currency;
														if ($row->price == 0)
															$price = _i("free");
														@endphp
														<button class='btn btn-success col-md-12' name='package_plan_id' type='submit' value='{{ $row->id }}'>
															{{$every}} - {{$price}}
														</button>
													@endforeach
												</div>
											</form>
											@endif
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
