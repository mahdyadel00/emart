<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new job') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jobs.store') }}" method='post' id='add-form' data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ _i('Title') }}</label>
                                <input class="form-control modal-title" name='title' required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ _i('Description') }}</label>
                                <textarea class="form-control modal-description" name='description' required=""></textarea>
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
                <form action="{{ route('jobs.attach') }}" method='post' id='add-attach-form' enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputOrder1">{{ _i('File:') }}</label>
                                <input type="hidden" name="job_id" id="job-attach-id">
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
                <h4 class="modal-title">{{ _i('Edit Job') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jobs.update') }}" method='post' id='edit-form' data-parsley-validate>
                    @method('post')
                    @csrf
                    <input type="hidden" name='id' id='modal-id'>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit-title">{{ _i('Title') }}</label>
                                <input id='edit-title' class="form-control modal-title" name='title' required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit-desc">{{ _i('Description') }}</label>
                                <textarea id='edit-desc' class="form-control modal-description" name='description' required=""></textarea>
                            </div>
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
                    <form action="{{route('jobs.store.translation')}}" method="post" class="form-horizontal"
                          id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id_data" value="">
                        <div class="form-group">
                            <label for="trans-title">{{ _i('Title') }}</label>
                            <input type="text" class="form-control modal-title chek" name='title' id='trans-title' required="">
                        </div>
                        <div class="form-group">
                            <label for="trans-desc">{{ _i('Description') }}</label>
                            <textarea class="form-control modal-body" name='description' id='trans-desc' required=""></textarea>
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
