<div class="tab-pane" id="similarProducts">
    {{--{{dd($products)}}--}}
    <form method="POST" id="form-similar-products" action="{{route('save.getSimilarProducts')}}">
        @csrf
        <input type="hidden" form="form-similar-products" name="id" class="product_id" value="">

        <div class="row">
            <div class="col-md-12 form-group">
                <select name="similar_products[]" class="form-control selectpicker" id="similar_products" multiple
                        data-live-search='true'>
                    @foreach($all_products as $s_product)
                        <option value="{{$s_product->id}}">
                            @if($s_product->product_details != [])
                                @if($s_product->product_details->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first() != [])
                                    {{$s_product->product_details->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title}}
                                @endif
                            @endif
                        </option>
                    @endforeach

                </select>
            </div>
            <div class="col-md-12 form-group">
                <button type="submit" form="form-similar-products"
                        class="form-control btn btn-primary">{{_i('save')}}</button>
            </div>
        </div>
    </form>


</div>


