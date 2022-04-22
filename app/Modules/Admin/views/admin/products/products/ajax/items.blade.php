<?php use App\Modules\Admin\Models\Products\ProductTypeCode;$script = ''; ?>
@foreach ($products as $product)
    <?php
    if ($product->hidden == 1) {
        $script .= "ProductHide({$product->id});";
    }
    $type = $product->product_type()->first();
    $code = '';
    if ($type !== null) {
        $code = ProductTypeCode::where('code', $type->type_code)->first();
        if ($code !== null) {
            $code = $code->code;
        }
    }
    ?>

    @include("admin.products.products.ajax.new")

@endforeach

@push('js')
    <script type="text/javascript">
        $(function() {
            {{ $script }}
        })
    </script>
@endpush
@push('css')
    <style>
        span.fixed-badge {
            position: absolute;
            background: #ff000085;
            color: #FFF;
            padding: 5px 10px;
            z-index: 2;
            text-align: center;
            display: block;
            width: 92%;
            text-transform: uppercase;
        }

    </style>
@endpush
@include('admin.products.products.includes.productstatus')
@include('admin.products.products.includes.labels')
@include('admin.products.products.includes.TranslateFeature')
@include('admin.products.products.includes.TranslateCustomFields')
@include('admin.products.products.includes.trans')
@include('admin.products.products.includes.repeat')
@include('admin.products.products.includes.btn.delete')
