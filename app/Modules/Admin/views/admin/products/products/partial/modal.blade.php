@include("admin.products.products.partial.tab.photo")

<div class="modal fade modal_donate" id="editdetails" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{_i('Edit Product Details')}}</h5>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-fill w-100">
                        <li class="nav-item ">
                            <a href="#productDetail" class="nav-link active" data-toggle="tab">
								<i class="ti-settings"></i>
								{{_i('Product Details')}}
							</a>
                        </li>
                        <li class="nav-item" data-feature style="display: none">
                            <a href="#productFeature" class="nav-link productFeature" data-toggle="tab">
								<i class="ti-paint-roller"></i>
								{{_i('Product Features')}}
							</a>
						</li>
                        <li class="nav-item" data-feature style="display: none">
                            <a href="#productAddition" class="nav-link product-order-form" data-toggle="tab">
								<i class="ti-medall-alt"></i>
								{{_i('Product order form')}}
							</a>
						</li>
                        <li class="nav-item" data-similar>
                            <a href="#similarProducts" class="nav-link similarProducts" id="similar" data-toggle="tab">
								<i class="ti-settings"></i>
								{{ _i('Similar products') }}
							</a>
                        </li>
						<li class="nav-item" data-similar>
							<a href="#metaTags" class="nav-link metaTags" id="meta" data-toggle="tab">
								<i class="ti-settings"></i>
								{{ _i('Meta Tags') }}
							</a>
						</li>
                        <li class="nav-item" data-card style="display: none">
                            <a href="#productCard" class="nav-link product-cards" data-toggle="tab">
								<i class="ti-settings"></i>
								{{_i('Product Codes')}}
                            </a>
                        </li>
                        <li class="nav-item product-digital" data-digital style="display: none">
                            <a href="#digitalProduct" class="nav-link " data-toggle="tab">
								<i class="ti-settings"></i>
								{{_i('Attatch Files')}}
                            </a>
                        </li>
                        <li class="nav-item" data-donation style="display: none">
                            <a href="#dontateProduct" class="nav-link product-donation" data-toggle="tab">
								<i class="ti-settings"></i>
								{{_i('Donation')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include("admin.products.products.partial.tab.details")
                        @include("admin.products.products.partial.tab.feature")
                        @include("admin.products.products.partial.tab.additions")
                        @include("admin.products.products.partial.tab.similar_products")
						@include("admin.products.products.partial.tab.meta_tags")
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
function makeid(length) {
    var result           = [];
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result.push(characters.charAt(Math.floor(Math.random() *
 charactersLength)));
   }
   return result.join('');
}
    $(function () {
        $('body').on('click', '.del_card', function (e) {
            var id = $('.product_id').val();
            e.preventDefault();
            $(this).closest('.donate_group').remove();
        });
    });
</script>
@endpush
