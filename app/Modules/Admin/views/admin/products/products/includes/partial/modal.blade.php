@include("admin.products.products.partial.tab.photo")
<!-- Modal -->
<div class="modal fade modal_donate" id="editdetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{_i('Edit the product details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item ">
                            <a href="#productDetail" class="nav-link active" data-toggle="tab">
                                {{_i('Product Details')}}
                            </a>
                        </li>
                        <li class="nav-item" data-feature style="display: none">
                            <a href="#productFeature" class="nav-link productFeature" data-toggle="tab">
                                {{_i('Product Features')}}
                            </a>
                        </li>
                        <li class="nav-item " style="display: none" data-card=''>
                            <a href="#productCard" class="nav-link " data-toggle="tab">
                                {{_i('Product Codes')}}
                            </a>
                        </li>
                        <li class="nav-item " style="display: none" data-digital=''>
                            <a href="#digitalProduct" class="nav-link " data-toggle="tab">
                                {{_i('Attatch Files')}}
                            </a>
                        </li>
                        <li class="nav-item " style="display: none" data-donation=''>
                            <a href="#dontateProduct" class="nav-link producDnation" data-toggle="tab">
                                {{_i('Donation')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        @include("admin.products.products.partial.tab.details")
                        @include("admin.products.products.partial.tab.feature")
                        @include("admin.products.products.partial.tab.cards")
                        @include("admin.products.products.partial.tab.digital")
                        @include("admin.products.products.partial.tab.donation")
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push("js")
<script type="text/javascript">

    // product type / Card
    $(function () {

    $('body').on('click', '.del_card', function (e) {
    var id = $('.product_id').val();
    e.preventDefault();
     $(this).closest('.donate_group').remove();

    });


    });
</script>
@endpush
