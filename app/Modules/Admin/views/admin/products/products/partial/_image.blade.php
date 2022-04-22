 <div class="modal fade" id="product-images" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ti-close"></i></span></button>
                    <h4 class="modal-title">{{_i("Product Image")}}</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="imageSubmit()" enctype="multipart/form-data">
                        <div class="product-image" id="product_image_1" data-image-id="">

                                    <label  for="product_photo">
                                        <img src="image.photo" class="img-responsive" style="height: 100%;margin: 0 auto;width: 100%;object-fit: cover;"></label>
                                    <label for="product_photo">{{_i("Click to upload")}}</label>

                            <input type="file" class="" name="product_image" id="product_photo" onchange="onImageChange()">
                        </div>

                        <button class="btn btn-tiffany"> {{_i("Save Main image")}}</button>
                    </form>
                    <br>
<!--                    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
                                  v-bind:dropzone-options="dropzoneOptions"
                                  v-on:vdropzone-error="failed"
                                  v-on:vdropzone-sending="sendingEvent"
                                  v-on:vdropzone-removed-file="imageRemoved">
                    </vue-dropzone>-->
                    <br>
                    <button class="btn btn-tiffany" onclick="uploadFiles()"> {{_i("Save Image")}}</button>

                    <div class="clearfix"></div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->