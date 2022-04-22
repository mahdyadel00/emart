<div class="modal fade" id="modal-default-review">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new Review') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reviews.index') }}" method='post' id='add-review-form'>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mtn-2">
                                <label for="rev-published">{{ _i('Publish') }}</label>
                                <input type="checkbox" class="js-switch" name='published' id="rev-published" checked>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rev-star">{{ _i('Stars') }}</label>
                                <select id="rev-stars" name="stars">
                                    <option value="5" selected>5</option>
                                    @for($i = 4; $i >= 1; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rev">{{ _i('Review') }}</label>
                                <textarea id="rev" class="form-control modal-name ckeditor" name='comment'></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='add-review-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="default-Modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit Review') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reviews.update') }}" method='post' id='edit-review-form'>
                    @csrf
                    <div class="row">
                        <div class="form-group row">
                            <label class="mx-2 col-form-label" for="checkbox">
                                {{_i('Status')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="hidden" id="id" class="js-switch" name='id'>
                                    <input type="checkbox" name="published" value="1" class='status'>
                                    <span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="stars">{{ _i('Stars') }}</label>
                                <select name="stars" id="stars">
                                    <option value="5" selected>5</option>
                                    @for($i = 4; $i >= 1; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comment">{{ _i('Review') }}</label>
                                <textarea id="editor1" class="form-control modal-name" name='comment'></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='edit-review-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>
