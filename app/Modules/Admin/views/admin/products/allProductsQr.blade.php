
	<table style="border: 0px">
		<tbody>
			<tr>
			@foreach($allProducts as $product)
				@if ($loop->iteration % 6 == 0)
					<td style="width: 200px">
						<img id="img" src="{{asset('uploads/qrCodes/'.$product->id.'.png')}}" border="0" width="100" class="img-rounded img" align="center" />
						<div >{{$product->sku ?? ''}}</div>
					</td>
				</tr>
				<tr>
				@else
					<td style="width: 200px">
						<img href="javascript:printMe()" id="img" src="{{asset('uploads/qrCodes/'.$product->id.'.png')}}" border="0" width="100" class="img-rounded img" align="center" />
			     		<div >{{$product->sku ?? ''}}</div>
					</td>
				@endif
			@endforeach
			</tr>
		</tbody>
	</table>


    <script type="text/javascript">

		window.onload = function() { window.print(); }
    </script>

