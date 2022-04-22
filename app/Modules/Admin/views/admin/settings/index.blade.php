@extends('admin.layout.index',
[
'title' => _i('Settings'),
'subtitle' => _i('Settings'),
'activePageName' => _i('Settings'),
'activePageUrl' => route('settings.index'),
'additionalPageName' => '',
'additionalPageUrl' => route('settings.index') ,
])

@push('css')
    <style>
        .blog-page {
            margin: 43px;
            height: 200px;
        }

        h3 i {
            font-size: 45px !important;
        }

        .counter-card-1 [class*="card-"] div>i,
        .counter-card-2 [class*="card-"] div>i,
        .counter-card-3 [class*="card-"] div>i {
            font-size: 30px;
            color: #1abc9c !important;
        }

    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ url('admin/settings/get') }}"
                                    class="text-primary">{{ _i('Basic Settings') }}</a></h3>
                            <p>{{ _i('Link, logo, name, location') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                    role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @can('Shipping') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/shipping') }}" --}}
            {{-- class="text-primary">{{_i('Shipping Settings') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Connect with shipping companies') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-truck-loaded"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Banks') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/transferBank') }}" --}}
            {{-- class="text-primary">{{_i('bank transfer') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Activating bank transfers') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-money-bag"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/payment/gates') }}" --}}
            {{-- class="text-primary">{{_i('Payment Gates') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Payment Gateways') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-money-bag"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}

            {{-- @can('Settings') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ route('storeOptions.index') }}" --}}
            {{-- class="text-primary">{{_i('Store Options') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Site control options') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-circuit"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Brands') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/brands') }}" --}}
            {{-- class="text-primary">{{  _i('Brands') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('View and control brands') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-gift-box"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}



            {{-- @can('Settings') --}}
            {{-- <div class="col-md-12 col-xl-4" hidden> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/newsletters') }}" --}}
            {{-- class="text-primary">{{  _i('NewsLetters') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('NewsLetters Control') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-envelope-open"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Settings') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/settings/products') }}" --}}
            {{-- class="text-primary">{{  _i('Products') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Products Control') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-listing-box"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Points') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/settings/points') }}" --}}
            {{-- class="text-primary">{{  _i('points') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('points Control') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-listing-box"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Chat') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ url('admin/settings/chat') }}" --}}
            {{-- class="text-primary">{{  _i('Chat') }}</a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Chat Plugin Code') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-ui-messaging"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}







            {{-- @can('Settings') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ route('smtp_settings.index') }}" class="text-primary "> --}}
            {{-- {{  _i('SMTP Settings') }} --}}
            {{-- </a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Mail host, port, username, password') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-gear"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}

            {{-- @can('Countries') --}}
            {{-- <div class="col-md-12 col-xl-4"> --}}
            {{-- <div class="card counter-card-1"> --}}
            {{-- <div class="card-block-big d-flex justify-content-between"> --}}
            {{-- <div> --}}
            {{-- <h3> --}}
            {{-- <a href="{{ route('countries.index') }}" class="text-primary "> --}}
            {{-- {{  _i('Countries') }} --}}
            {{-- </a> --}}
            {{-- </h3> --}}
            {{-- <p>{{ _i('Countries') }}</p> --}}
            {{-- <div class="progress "> --}}
            {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
            {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
            {{-- aria-valuemax="100"></div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div> --}}
            {{-- <i class="icofont icofont-gear"></i> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endcan --}}



            {{-- <div class="page-header">
        <div class="page-header-title">
            <h4>{{_i('Cities')}}</h4>
        </div>
    </div>
    <div class="page-body">
        <div class="row"> --}}
            <div class="hidden col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('/admin/all_users') }}" class="text-primary">{{ _i('Users') }}</a>
                            </h3>
                            <p>{{ _i('Control Users') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-user"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('/admin/cities') }}" class="text-primary">{{ _i('Cities') }}</a>
                            </h3>
                            <p>{{ _i('Control Cities') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                    role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-train-steam"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('/admin/pages') }}" class="text-primary">{{ _i('Pages') }}</a>
                            </h3>
                            <p>{{ _i('Manage static pages') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                    role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-page"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('/admin/settings/section/home_sections') }}"
                                    class="text-primary">{{ _i('Home Sections') }}</a>
                            </h3>
                            <p>{{ _i('Manage Home Sections') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                    role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-page"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('/admin/settings/section') }}"
                                    class="text-primary">{{ _i('Mobile Sections') }}</a>
                            </h3>
                            <p>{{ _i('Manage Mobile Sections') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                    role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-page"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- banner --}}
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('admin/settings/banners') }}"
                                   class="text-primary">{{  _i('Banners') }}</a>
                            </h3>
                            <p>{{ _i('Show banners to customers in the store') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-file-image"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- <div class="page-header">
		<div class="page-header-title">
			<h4>{{_i('Content Sections')}}</h4>
		</div>
	</div>
	<div class="page-body">
		<div class="row"> --}}
    {{-- @can('Sections') --}}
    {{-- <div class="col-md-12 col-xl-4"> --}}
    {{-- <div class="card counter-card-1"> --}}
    {{-- <div class="card-block-big d-flex justify-content-between"> --}}
    {{-- <div> --}}
    {{-- <h3> --}}
    {{-- <a href="{{ route('section.index', 'home_sections') }}" --}}
    {{-- class="text-primary">{{  _i('Home Sections') }}</a> --}}
    {{-- </h3> --}}
    {{-- <p>{{ _i('Control Home Page Sections') }}</p> --}}
    {{-- <div class="progress "> --}}
    {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
    {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
    {{-- aria-valuemax="100"></div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div> --}}
    {{-- <i class="icofont icofont-pencil-alt-5"></i> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- @endcan --}}

    {{-- <div class="col-md-12 col-xl-4"> --}}
    {{-- <div class="card counter-card-1"> --}}
    {{-- <div class="card-block-big d-flex justify-content-between"> --}}
    {{-- <div> --}}
    {{-- <h3> --}}
    {{-- <a href="{{ route('section.index', 'categories_sections') }}" --}}
    {{-- class="text-primary">{{  _i('Categories Sections') }}</a> --}}
    {{-- </h3> --}}
    {{-- <p>{{ _i('Control Categories Page Sections') }}</p> --}}
    {{-- <div class="progress "> --}}
    {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
    {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
    {{-- aria-valuemax="100"></div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div> --}}
    {{-- <i class="icofont icofont-pencil-alt-5"></i> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}

    {{-- @can('Content management') --}}
    {{-- <div class="col-md-12 col-xl-4"> --}}
    {{-- <div class="card counter-card-1"> --}}
    {{-- <div class="card-block-big d-flex justify-content-between"> --}}
    {{-- <div> --}}
    {{-- <h3> --}}
    {{-- <a href="{{ url('/admin/content_management') }}" --}}
    {{-- class="text-primary">{{  _i('Content') }}</a> --}}
    {{-- </h3> --}}
    {{-- <p>{{ _i('Content Management') }}</p> --}}
    {{-- <div class="progress "> --}}
    {{-- <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" --}}
    {{-- role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" --}}
    {{-- aria-valuemax="100"></div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div> --}}
    {{-- <i class="icofont icofont-pencil-alt-5"></i> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- @endcan --}}

    {{-- </div>
	</div> --}}
@endsection
