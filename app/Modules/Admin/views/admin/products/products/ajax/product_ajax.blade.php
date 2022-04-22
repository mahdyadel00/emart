@if(count($products) > 0)
@include("admin.products.products.ajax.items")
@push("js")
<script type="text/javascript">
	var page =2;
	function more(obj)
	{
		let filter = $('#filter_search').val();
		if((page)>={{$products->lastPage()}})
		{
			$(obj).hide();
		}
		$.ajax(
		{
			url: "products",
			data: {
				page:page,
				filter:filter
			},
			type: "get",
			datatype: "html"
		}).done(function (data) {
               $('#allProducts_div').append(data)
			//$( data ).insertBefore( $( obj ) );
			$('.selectpicker').selectpicker('refresh');
			page +=1;
		}).fail(function (jqXHR, ajaxOptions, thrownError) {
			alert('No response from server');
		});
	}
</script>
@endpush
<button onclick="more(this)" class="btn btn-tiffany btn-block">{{_i("Show More")}}</button>

@else

<div class="col-12" id='no-items'>
	<div class="alert alert-danger text-center">
		<p class="lead">{{ _i('No Products') }}</p>
	</div>
</div>

@endif

{{-- @include('admin.products.products.includes.productstatus')
@include('admin.products.products.includes.labels')
@include('admin.products.products.includes.TranslateFeature')
@include('admin.products.products.includes.TranslateCustomFields')
@include('admin.products.products.includes.trans')
@include('admin.products.products.includes.repeat')
@include('admin.products.products.includes.btn.delete') --}}
