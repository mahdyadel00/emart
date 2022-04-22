<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title left" id="exampleModalLabel">{{ _i('Product Image') }}</h5>
                <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class='col-md-6'>
                        <form action="{{ url('admin/imageSubmit') }}" id="frm_photo" method="post"
                            enctype="multipart/form-data" data-parsley-validate="">
                            {{ csrf_field() }}
                            {{ method_field('post') }}
                            <div class="product-image" id="product_image_1" name="id">
                                <input type="hidden" name="product_id" value="">
                                <label for="product_photo">{{ _i('click to choose the image') }}.</label>
                                <input type="file" class="form-control" name="image" id="product_photo"
                                    data-parsley-required="true" onchange="showImg(this)" accept="image/*">
                                <img id="img_main" src="{{ asset('images/placeholder.png') }}" class="image"
                                    style="height: 250px; width: 250px;">
                            </div>
                            <button class="btn btn-tiffany" type="button"
                                onclick="saveMain(this)">{{ _i('save main image') }}</button>
                        </form>
                    </div>
                    {{-- <div class='col-md-6'> --}}
                    {{-- <form action="{{url('admin/upload_video')}}" id="frm_video" method="post" enctype="multipart/form-data" data-parsley-validate=""> --}}
                    {{-- {{csrf_field()}} --}}
                    {{-- {{method_field('post')}} --}}
                    {{-- <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> --}}
                    {{-- <div class="product-image mb-1"> --}}
                    {{-- <label for="product_video">{{_i('Add Url video')}}.</label> --}}
                    {{-- <input type="text" class="form-control" name="video" id="product_video" data-parsley-required="true"  > --}}
                    {{-- </div> --}}
                    {{-- <div class="product-video"></div> --}}
                    {{-- <button class="btn btn-tiffany mt-3" type="button" onclick="saveMainVideo(this)">{{_i('Save Product Video')}}</button> --}}
                    {{-- </form> --}}
                    {{-- </div> --}}
                </div>
                <br>
                <div class="form-group">
                    <label>{{ _i('banner') }}</label>
                    <div class="dropzone options" id="dropzonefield" style="border: 1px solid #452A6F;margin: 10px">
                    </div>
                </div>
                <br>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('close') }}</button>
            </div>
        </div>
    </div>
</div>
