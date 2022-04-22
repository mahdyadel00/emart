
@php
    $settings = \App\Bll\Site::getSettings();
    $categories = \App\Bll\Site::getProCategories();

@endphp

<div class="col-md-4">
    <div class="search-form">
        <form action="{{route('search')}}" method="get"  data-parsley-validate="">
            @csrf
        <input type="text" class="form-control" name="search_key" required="" placeholder="{{_i('Search')}}..">
        <button type="submit" class="btn btn-orange"><i class="fa fa-search"></i></button>
        </form>
    </div>

{{--    <div class="download-catalog mt-3">--}}
{{--        <a href="" class="d-flex justify-content-between align-items-center">--}}
{{--            <p>--}}
{{--                <img src="images/pdf-icon.webp" alt="" class="img-fluid" loading="lazy">--}}
{{--                {{_i('Download file')}}--}}
{{--            </p>--}}
{{--            <i class="fas fa-download"></i>--}}
{{--        </a>--}}
{{--    </div>--}}

    <div class="cats-list bg-light-blue   p-2 mt-3">
        <div class="title bg-blue text-white fw-bold rounded p-3 fz21">{{_i('Categories')}}</div>
        <ul class="list-unstyled p-2 pb-0 mb-0">
            @foreach($categories as $cat_item)
                <li><a href="{{route('cat_product', $cat_item->category_id)}}">{{$cat_item->title}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="support-box mt-3">
        <div class="fw-bold fz30">{{_i('Can us help you')}}?</div>
        <div class="fz21">{{_i('Technical Support Number')}}</div>
        @if($settings != null)
            <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
            <a href="tel:{{$settings->phone2}}">{{$settings->phone2 }}</a>
        @endif
    </div>

    @include('site.layout.sale_point')
</div>
