@extends('admin.layout.index',
[
'title' => _i('Show Order'),
'subtitle' => _i('Show Order'),
'activePageName' => _i('Show Order'),
'activePageUrl' => '',
'additionalPageName' => _i('Orders'),
'additionalPageUrl' => route('admin.orders.index')
])

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
            .dropdown-menu {
                z-index: 9999;
            }

        </style>
    @endpush
@section('content')
    <div class="box box-info">
        <div class="box-body">
            @include("admin.orders.partial.info")
        </div>
    </div>

    <div class="row order-column">
        <div class="col-md-4">
            <div class="card user">
                <div class="card-header">
                    <h5>{{ _i('Client') }}</h5>
                </div>
                <div class="card-footer userIcon ">
                    <img src="@if ($order->user && $order->user->image != null) {{ asset('uploads/users/' . $order->user->id . '/' . $order->user->image) }}@else {{ asset('default_images/avatar_male.png') }} @endif" border="0" style="max-width:80px; max-height:50px;"
                        class="img-responsive img-rounded">
                    <div class="card-block-big text-center " style="display: inline-block; margin-top:-50px;">
                        <?php
                        $number = $order->user ? $order->user->phone : $order->phone;
                        $masked = str_pad(substr($number, -4), strlen($number), '*', STR_PAD_LEFT);
                        ?>
                        <span> {{ $order->user ? $order->user->name : $order->name }}</span>
                        <p>{{ $order->user ? $order->user->email : $order->email }}</p>
                        <p>{{ $masked }}</p>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="notification">
                            <span> <i class="icofont icofont-notification"></i> {{ _i('Notification') }} </span>
                        </a>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="sms">
                            <span> <i class="icofont icofont-ui-messaging"></i> {{ _i('Text message') }} </span>
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="email">
                            <span> <i class="icofont icofont-ui-message"></i> {{ _i('Email') }} </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card user">
                <div class="card-header">
                    <h5>{{ _i('Shipping Information') }} </h5>
                </div>
                <div class="card-footer userIcon ">
                    <div class="card-block-big text-center">
                        @php
                            $company = null;
                            if ($order->shipping_option != null) {
                                $company = \App\Models\Shipping\ShippingCompaniesData::where('shipping_company_id', $order->shipping_option->company_id)
                                    ->where('lang_id', Lang::getSelectedLangId())
                                    ->first();
                            }
                        @endphp
                        @if ($company != null)
                            <p><span>{{ _i('Company') }} : </span>{{ $company->title }} </p>
                            <p><span>{{ _i('Delay') }} : </span>{{ $order->shipping_option->delay }}
                                <span>{{ _i('Day') }} </span></p>
                            <p><span>{{ _i('Cost') }} : </span>{{ $order->shipping_option->cost }} </p>
                            <p><span>{{ _i('Country') }} :
                                </span>{{ $order->shipping->country ? $order->shipping->country->data->title : '' }}</p>
                            <p><span>{{ _i('Governorate') }} :
                                </span>{{ $order->shipping->city ? $order->shipping->city->data->title : '' }}</p>
                            <p><span>{{ _i('Region') }} :
                                </span>{{ $order->shipping->region && $order->shipping->region->data->first() != null ? $order->shipping->region->data->first()->title : '' }}
                            </p>
                            <p><span>{{ _i('Street') }} : </span>{{ $order->shipping->street }}</p>
                            <p><span>{{ _i('El Gada') }} : </span>{{ $order->shipping->address }}</p>
                            <p><span>{{ _i('Home number') }} : </span>{{ $order->shipping->Neighborhood }}</p>
                        @else
                            @php
                                $address = $order
                                    ->addresses()
                                    ->orderBy('id', 'DESC')
                                    ->first();
                            @endphp
                            @if ($order->user_id == 0 && $address)
                                {{-- {{dd($address)}} --}}
                                <p><span>{{ _i('Country') }} :
                                        {{ \App\Models\countries::find($address->country_id) ? \App\Models\countries::find($address->country_id)->data->title : '' }}
                                    </span></p>
                                <p><span>{{ _i('Governorate') }} :
                                        {{ \App\Models\cities::find($address->city_id) ? \App\Models\cities::find($address->city_id)->data->title : '' }}
                                    </span></p>
                                <p><span>{{ _i('Region') }} :
                                        {{ \App\Site\Region::find($address->region_id) &&
\App\Site\Region::find($address->region_id)->data()->first()
    ? \App\Site\Region::find($address->region_id)->data()->first()->title
    : '' }}
                                    </span></p>
                                <p><span>{{ _i('Street') }} :
                                        {{ $address->street }}
                                    </span></p>
                                <p><span>{{ _i('El Gada') }} :
                                        {{ $address->address }}
                                    </span></p>
                                <p><span>{{ _i('Home Number') }} :
                                        {{ $address->Neighborhood }}
                                    </span></p>
                                <p><span>{{ _i('Block') }} :
                                        {{ $address->block }}
                                    </span></p>
                                <p><span>{{ _i('note') }} :
                                        {{ $address->note }}
                                    </span></p>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @include("admin.orders.partial.payment")

        <div class="order-table col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ _i('products') }}</h3>
                    <div class="heading-elements">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    @if ($order->orderProducts->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ _i('product') }}</th>

                                    <th>{{ _i('price') }}</th>
                                    <th>{{ _i('qty') }}</th>
                                    <th>{{ _i('total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderProducts as $product)
                                    <tr class="productRowOne">
                                        <td data-th="Product">
                                            <div class="row">
                                                @if ($product->product)
                                                    <div class="col-sm-3 hidden-xs">
                                                        <img src="{{ $product->product->product_photos()->where('main', 1)->first()
    ? asset(
        $product->product->product_photos()->where('main', 1)->first()->photo,
    )
    : '' }}"
                                                            width="100" height="100" class="img-responsive">
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <h4 class="nomargin">
                                                            {{
															$product->product->detailes!=null ?
															$product->product->detailes->title : ""
															 }}</h4>
                                                        @php

                                                            $options = $order
                                                                ->options()
                                                                ->where('product_id', $product->product_id)
                                                                ->get();

                                                        @endphp
                                                        <table style="width:100%">
                                                            @foreach ($options as $option)

                                                                @php
                                                                    $feature = \DB::select(
                                                                        'SELECT features_data.* FROM features_data join feature_options on features_data.feature_id = feature_options.feature_id where feature_options.id=' .
                                                                            $option->feature_option_id .
                                                                            "
                                                                    ",
                                                                    );


                                                                @endphp

                                                                <tr>
                                                                    <td>{{ $feature[0]->title }}</td>
                                                                    <td>{{ $option->Data() ? $option->Data()->name : '' }}</td>
                                                                    <td
                                                                        style="background-color:{{ $option->Data()->title }};">
                                                                    </td>
                                                                    <td>{{ $option->price }}</td>


                                                                </tr>



                                                            @endforeach
                                                        </table>

                                                    </div>
                                                @else
                                                    <p>{{ _i('Product Not Found Or Deleted') }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-th="Price" class="price">{{ $product->price }}</td>
                                        <td data-th="Quantity">
                                            <input type="text" class="form-control" disabled
                                                value="{{ $product->count }}" />
                                        </td>
                                        <td data-th="Subtotal">{{ $product->count * $product->price }}</td>
                                    </tr>

                                    @if (!empty($product->product->fields))
                                        @php
                                            $custom_fields = json_decode($product->custom_fields, true);
                                        @endphp
                                        @foreach ($product->product->fields as $field)
                                            @if (!isset($custom_fields[$field->id]))
                                                @continue
                                            @endif
                                            <tr class="productRowOne">
                                                <td></td>
                                                <td></td>
                                                <td data-th="Quantity"> {{ $field->name }} </td>
                                                <td data-th="Subtotal" class="text-center">
                                                    @if ($field->type == 'image')
                                                        <a target='_blank'
                                                            href='{{ asset("uploads/custom_fields/{$product->product_id}/{$custom_fields[$field->id]}") }}'>
                                                            <img src="{{ asset("uploads/custom_fields/{$product->product_id}/{$custom_fields[$field->id]}") }}"
                                                                class='img-thumbnail' alt="" style='width: 100px'>
                                                        </a>
                                                    @elseif( $field->type == 'radio' or $field->type == 'checkbox' )
                                                        @foreach ($field->options as $option)
                                                            @if (is_array($custom_fields[$field->id]['options']))
                                                                @if (in_array($option->id, $custom_fields[$field->id]['options']))
                                                                    <label
                                                                        class='label label-info'>{{ $option->name }}</label>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{ $custom_fields[$field->id] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                <tr class="productRowOne">
                                    <td></td>
                                    <td></td>
                                    <td>{{ _i('Cart Total') }}</td>
                                    <td class="total__befor">{{ $order->total - $order->shipping_cost }}</td>
                                </tr>
                                <tr class="productRowOne">
                                    <td></td>
                                    <td></td>
                                    <td>{{ _i('Tax') }}</td>
                                    <td class="total__befor">{{ $order->tax_cost ?? 0 }}</td>
                                </tr>
                                <tr class="productRowOne">
                                    <td></td>
                                    <td></td>
                                    <td>{{ _i('Shipping cost') }}</td>
                                    <td class="Shipping__cost">{{ $order->shipping_cost }}</td>
                                </tr>
                                <tr class="productRowOne">
                                    <td></td>
                                    <td></td>
                                    <td>{{ _i('Order Total') }}</td>
                                    <td class="total">{{ $order->total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <h3>{{ _i('dont find product this order') }}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $number }}#{{ _i('order Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="form-sub" data-parsley-validate="">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-group">
                                {!! Form::select('status_id', $status->pluck('title', 'id'), $status_id, ['name' => 'status_id', 'class' => 'form-control selectpicker', 'required' => '']) !!}
                            </div>
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="row form-group">
                                <textarea name="comments" class="form-control"
                                    placeholder="{{ _i('note by client') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ _i('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.orders.show_includes.send_modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#color-pic").colorpicker();
        })

        $(function() {
            'use strict'
            $('.selectpicker').on('change', function(e) {
                $(this).next().next().addClass('show');
            })
            $('body').click(function() {
                $('.selectpicker').next().next().removeClass('show');
            })
        })
        $(function() {
            $('body').on('submit', '#form-sub', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('review-order') }}",
                    method: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(response) {
                        if (response.status == 'ok') {
                            $("#btn_status").text($("select[name='status_id'] option:selected")
                                .text());
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Added is Successfly') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $modal = $('#exampleModal');
                            $modal.find('form')[0].reset();
                        }
                        if (response.status == 'false') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Order Was Rejected Or Canceled') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $modal = $('#exampleModal');
                            $modal.find('form')[0].reset();
                        }
                    },
                });
            });
        })
    </script>
@endpush
