<div class="col-md-4 col-sm-3">
    @if (isset($product))
        @if ($product->hasStock() <= 0)<span class="fixed-badge">{{ _i('Not avaialable') }}</span>@endif
    @endif
{{--{{dd($product->features)}}--}}
    <div class="product-box">
        <form name="frm_product">
            @csrf
            <select name="types" class="hidden" placeholder="{{ _i('Product type') }}" data-toggle="tooltip"
                data-placement="top" title="{{ _i('Product type') }}">
                @foreach ($product_type as $row)
                    <option value="{{ $row->id }}" @if (isset($product)) {{ $row->id == $product->product_type ? 'selected' : '' }} @endif
                        data-subtext="{{ $row->description }}">
                        {{ $row->title }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="visits" value="20">
            <div class="product-img-details">
                <img src="{{ isset($product) ? asset($product->mainPhoto()) : asset('/images/placeholder.png') }}"
                    alt="#" class="product-img">
                <button type="button" class="bt btn-tiffany add-img" onclick="getProdImgid(this)">
                    {{ _i('Add Photo') }}
                </button>
            </div>
            <div class="inputs-product-body">
                <div class="form-group">
                    <span class="addon-tag"><i class="ti-shopping-cart-full"></i></span>
                    <input type="text" id="product_name" class="form-control product_name input" @if (isset($product))	   value="{{ $product->detailes != null ? $product->detailes->title : '' }}" readonly @endif
                        name="product_name" placeholder="{{ _i('Product Name') }}" required=""
                        class="input border-danger">
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="product-desc input-group">
                        <span class="addon-tag">
                            <i class="fa fa-tag"></i>
                        </span>
                        @php
                            $selected = [];
                        @endphp
                        @if (isset($product))
                            @php
                                $selected = $product->Category()->pluck('id')->toArray();
                            @endphp
                        @endif

                        {{-- @foreach ($cats as $i => $item)
                                    {{ $item }}
                                     @if(isset($categories[$i][Lang::getSelectedLangId()]))
                                    {{($categories[$i][Lang::getSelectedLangId()])->title}}
                                    @elseif(isset($categories[$i]))
                                     {{(array_first($categories[$i]))->title}}  @endif

                            @endforeach--}}

						{{-- @dd($cats,$categories); --}}

{{--                        <select name="categories[]" multiple="multiple" class="selectpicker" data-live-search="true"--}}
                        <select name="categories[]"  class="selectpicker" data-live-search="true"
                            data-toggle='tooltip' data-placement='top' title={{ _i('Category') }}>

							@foreach ($cats as $i => $item)

                                <option @if(in_array($i,$selected)) selected @endif value="{{ $i }}">
                                    {{ $item }}
                                    {{-- @if(isset($categories[$i][Lang::getSelectedLangId()]))
                                   {{($categories[$i][Lang::getSelectedLangId()])->title}}
                                   @elseif(isset($categories[$i]))
                                    {{(array_first($categories[$i]))->title}}  @endif  --}}

								</option>

                            @endforeach
                        </select>
                        {{-- @if (isset($product))


                            {!! Form::select('categories[]', $cats, $product->Category()->pluck('id'), ['multiple' => 'multiple', 'class' => 'selectpicker', 'data-live-search' => 'true', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => _i('Category')]) !!}
                        @else
                            {!! Form::select('categories[]', $cats, null, ['multiple' => 'multiple', 'class' => 'selectpicker', 'data-live-search' => 'true', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => _i('Category')]) !!}
                        @endif --}}


                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Cost') }}">
                        <div class="form-group">
                            <span class="addon-tag pl-1">{{ \App\Bll\Utility::currencies()->first()->code }}</span>
                            <input type="number" min="0.10" max="1000000" step="0.001" class="form-control cost mr-2"
                                @if (isset($product))    value="{{ $product->cost }}" @endif name="cost" required="" placeholder="{{ _i('Cost') }}"
                                class="input border-danger">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Price') }}">
                        <div class="form-group">
                            <span class="addon-tag pl-1">{{ App\Bll\Utility::currencies()->first()->code }}</span>
                            <input type="number" min="0.10" max="1000000" step="0.001" class="form-control price mr-2"
                                @if (isset($product))  value="{{ $product->price }}"  @endif name="price" required="" placeholder="{{ _i('Price') }}"
                                class="input border-danger">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">

                    <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Stock') }}">
                        <div class="form-group">
                            <span class="addon-tag pl-1"></span>
                            <input type="number" min="0.10" max="1000000" step="0.001" class="form-control price"
                                @if (isset($product)) value="{{ $product->hasStock() }}" readonly @endif name="max_count" placeholder="{{ _i('amount') }}"
                                class="input border-danger">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Code') }}">
                        <div class="form-group">
{{--                            <span class="addon-tag pl-1">{{ App\Bll\Utility::currencies()->first()->code }}</span>--}}
                            <input type="text" class="form-control price mr-2 input"
                                   @if (isset($product))  value="{{ $product->code }}"  @endif
                                   name="code" required="" placeholder="{{ _i('Code') }}"
                            class="border-danger">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

{{--                <div class="row form-group">--}}

{{--                    <div class="col-md-12" data-toggle="tooltip" data-placement="top"--}}
{{--                        title="{{ _i('shipping') }}">--}}
{{--                        <div class="form-group">--}}


{{--                            <div class="form-radio">--}}

{{--                                <div class="radio radiofill radio-primary radio-inline">--}}
{{--                                    <label>--}}
{{--                                        <input class="is_free_shipping" type="radio" name="is_free_shipping" value="0"--}}
{{--                                            @if (isset($product)) {{ $product->is_free_shipping == 0 ? 'checked' : '' }} @endif>--}}
{{--                                        <i class="helper"></i> {{ _i('Paid Shipping') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="radio radiofill radio-primary radio-inline">--}}
{{--                                    <label>--}}
{{--                                        <input class="is_free_shipping" type="radio" name="is_free_shipping" value="1"--}}
{{--                                            @if (isset($product)) {{ $product->is_free_shipping == 1 ? 'checked' : '' }} @else checked @endif>--}}
{{--                                        <i class="helper"></i>{{ _i('Free Shipping') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row">
                    <div class="col-lg-4 ">
                        <input type="hidden" name="product_id" value="{{ isset($product) ? $product->id : '-1' }}">
                        <input type="hidden" name="is_free_shipping" value="1">
                        <button class="btn btn-tiffany save save-product w-100 p-2" type="button"
                            onclick="saveProduct(this)">
                            {{ _i('Save') }}
                        </button>
                    </div>

{{--                    <div class="col-lg-4 ">--}}
{{--                        <div class="category-select  ">--}}
{{--                            <button class="btn btn-default  optional-category p-2 w-100" type="button"--}}
{{--                                onclick="getDetails(this)" @if (isset($product)) data-code="{{ $code }}" @endif>{{ _i('Details') }}--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    @if (isset($product))
					{{-- @dd($features) --}}
                        <div class="col-lg-4">
                            <a data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 p-2"
                                href="#">{{ _i('More') }}

                            </a>
                            <ul class="dropdown-menu active">
                                @foreach (\App\Bll\Lang::getLanguages() as $lang)
                                    <li>
                                        <a href="#" class="lang_ex dropdown-item" @if (isset($product)) data-id="{{ $product->id }}" @endif
                                            data-lang="{{ $lang->id }}" data-toggle="modal"
                                            data-target="#langedit">
                                            <i class="icofont icofont-law-document"></i>
                                            {{ _i('Translate to') }} ({{ $lang->title }})
                                        </a>
                                    </li>
                                @endforeach
                                <li hidden>
                                    <a href="javascript:void(0)" onclick="productdel(this)">{{ _i('delete') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item get_link" href="#id-{{ $product->id }}" id="id-{{ $product->id }}" data-id="{{ $product->id }}"
                                        data-clipboard-action="copy"
                                        data-clipboard-text="{{ url('/product/' . $product->id) }}">
                                        <i class="icofont icofont-link"></i>
                                        {{ _i('Get URL') }}
                                    </a>
                                </li>
{{--                                <li>--}}
{{--                                    <a class="dropdown-item repeat" href="#id-{{ $product->id }}" id="id-{{ $product->id }}" data-id="{{ $product->id }}"--}}
{{--                                        data-toggle="modal" data-url="{{ route('product_dublicate', $product->id) }}"--}}
{{--                                        data-target="#repeatProduct">--}}
{{--                                        <i class="icofont icofont-page"></i>--}}
{{--                                        {{ _i('Duplicate') }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a class="dropdown-item stats" href="#" data-id="{{ $product->id }}"--}}
{{--                                        data-toggle="modal" data-target="#statsProduct">--}}
{{--                                        <i class="icofont icofont-chart-line-alt"></i>--}}
{{--                                        {{ _i('Statistics') }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a class="dropdown-item orders"--}}
{{--                                         href="{{ route('product.customers', $product->id) }}"--}}
{{--                                        data-id="{{ $product->id }}">--}}
{{--                                        <i class="icofont icofont-law-document"></i>--}}
{{--                                        {{ _i('Product orders') }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                                <li>
                                    <a class="dropdown-item" href="#id-{{ $product->id }}" data-id="{{ $product->id }}" id="id-{{ $product->id }}"
                                        onclick="hideProduct(this)">
                                        @if($product->hidden === 0)
                                             <i class="icofonts icofont-eye-alt"></i>  {{_i('Show')}}
                                            @else
                                            <i class="icofonts icofont-eye-blocked"></i> {{_i('hide')}}
                                        @endif
                                    </a>
                                </li>

{{--                                <li>--}}
{{--                                    <a class="dropdown-item detaPro" href="#" data-id="{{ $product->id }}"--}}
{{--                                        data-toggle="modal" data-target="#detailProduct">--}}
{{--                                        <i class="icofont icofont-chart-line-alt"></i>--}}
{{--                                        {{ _i('Labels') }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--									@if(!$product->features->isEmpty() && in_array($product->id, $features) )--}}
{{--                                        <li>--}}
{{--                                            <a class="dropdown-item TransFeature" href="#" data-id="{{ $product->id }}"--}}
{{--                                                data-toggle="modal" data-target="#TranslateFeature">--}}
{{--                                                <i class="icofont icofont-chart-line-alt"></i>--}}
{{--                                                {{ _i('Translate Feature') }}--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--									@endif--}}
									{{-- @if(in_array($product->id, $features))
                                <li>
                                    <a class="dropdown-item TranslateCustomFields" href="#"
                                        data-id="{{ $product->id }}" data-toggle="modal"
                                        data-target="#TranslateCustomFields">
                                        <i class="icofont icofont-chart-line-alt"></i>
                                        {{ _i('Translate Custom Fields') }}
                                    </a>
                                </li>
								@endif --}}


{{--                                    <li>--}}
{{--                                        <a class="dropdown-item get_link" href="{{ route('admin.getTranslateDetail.index') }}/?id={{$product->id}}"--}}
{{--                                           >--}}
{{--                                            <i class="icofont icofont-link"></i>--}}
{{--                                            {{ _i('Translate Labels') }}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}

                                <li>
                                    <a class="dropdown-item deletepro text-danger" href="#"
                                        data-id="{{ $product->id }}" onclick="confirmBeforeDelete(this)">
                                        <i class="icofont icofont-basket"></i>
                                        {{ _i('Final deletion') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>
