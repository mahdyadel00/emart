<div class="orderList">
    <div class="card order-info-panel">
        <div class="card-body text-center row">
            <div class="col-sm-3">
                <span class="order-top-line">
                    {{_i("Order No")}}
                </span>
                <div class="order-second-line">
                    {{$number}}
                </div>
            </div>
            <div class="col-sm-3">
                <span class="order-top-line">
                    {{_i("Transaction no")}}
                </span>
                @if($order->transaction != NULL)
                <div class="order-second-line">
                    <a href="{{ url('admin/orders/online/' . $order->transaction->id . '/show') }}">
					{{$order->transaction->id}}</a>
                </div>
                @else
                <div class="order-second-line">
                    {{ _i('Not Found') }}
                </div>
                @endif
            </div>
            <div class="col-sm-3">
                <span class="order-top-line">
                    {{_i("Date")}}
                </span>
                <div class="order-second-line">
                    {{$order->created_at->format('d/m/Y')}}
                </div>
            </div>
            <div class="col-sm-3">
                <span class="order-top-line">
                    {{_i("Order Status")}}
                </span>
                <div class="order-second-line">
                    <button class="btn btn-success btn-sm" data-toggle="modal" id='btn_status'  data-target="#exampleModal">{{$text}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
