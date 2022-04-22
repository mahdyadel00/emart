<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new Blog Category') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blogs_categories.store') }}" method='post' id='add-form' enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="checkbox">
                                {{_i('Active')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox" name="active" value="1" class='status'>
                                    <span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class=" col-sm-3 col-form-label">{{ _i('Image') }} </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control modal-price imageadd" name='photo'>
                                <img style="width: 150px" id="image_service" class="img-thumbnail " src="" alt="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ _i('Name') }}</label>
                                <input type="text"  class="form-control modal-title  nameadd" name='name' required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ _i('Description') }}</label>
                                <textarea id="editor1" class="form-control modal-description ckeditor descriptionadd"  name='description' required=""></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='add-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="default-Modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Upload Attachment') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blogs_categories.attach') }}" method='post' id='add-attach-form' enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputOrder1">{{ _i('File:') }}</label>
                                <input type="hidden" name="blog_cat_id" id="job-attach-id">
                                <input type="file" class="form-control modal-title" name='file'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='add-attach-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="default-Modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit Blog Category') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blogs_categories.update') }}" method='post' id='edit-form'>
                    @method('post')
                    @csrf
                    <input type="hidden" name='id' id='modal-id'>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="checkbox">
                            {{_i('Active')}}
                        </label>
                        <div class="checkbox-fade fade-in-primary col-sm-6">
                            <label>
                                <input id="blog-cat-active" type="checkbox" name="active" class='status'>
                                <span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class=" col-sm-3 col-form-label">{{ _i('Image') }} </label>
                        <div class="col-sm-9">
                            <input type="file" id="input-photo" class="form-control" name='photo'>
                            <img class="img-fluid" id="blog-cat-photo" src="" alt="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='edit-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade modal_create" id="langedit">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('blogs_categories.store.translation')}}" method="post" class="form-horizontal"
                          id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id_data" value="">
                        <div class="form-group">
                            <label for="trans-title">{{ _i('Name') }}</label>
{{--                            <textarea type="text" class="form-control modal-title ckeditor" name='name' id='trans-title'></textarea>--}}
                            <input type="text" class="form-control modal-title" name='name' id='trans-name' required="">
                        </div>
                        <div class="form-group">
                            <label for="desclangtrans">{{ _i('Description') }}</label>
                            <textarea class="form-control modal-body" name='description' id='desclangtrans' ></textarea>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary">
                                {{_i('Save')}}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
