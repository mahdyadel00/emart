<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_create " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{ _i('Trans To') }} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('countries.store.translation') }}" method="post" class="form-horizontal"
                        id="lang_submit" data-parsley-validate="">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id_data" value="">
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 control-label "> {{ _i('Country') }} </label>
                                <div class="col-md-10">
                                    <input type="text" placeholder="{{ _i('name') }}" name="name" value=""
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        required="" id="titletrans">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ _i('Close') }}</button>
                            <button type="submit" class="btn btn-primary">
                                {{ _i('Save') }}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit country') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('site.admin.countries.update', 1) }}" method='post' id='edit-form'>
                    @method('patch')
                    @csrf
                    <input type="hidden" name='id' id='modal-id'>
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ _i('Title') }}</label>
                        <input type="text" class="form-control modal-title" name='title'>
                    </div>
					<div class="form-group">
                        <label for="exampleInputOrder1">{{ _i('Code') }}</label>
                        <input type="number" class="form-control modal-code" name='code'>
                    </div>
                    {{-- <div class="form-group">
                        <label for="exampleInputOrder1">{{ _i('Order') }}</label>
                        <input type="number" class="form-control modal-order" name='order'>
                    </div> --}}


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


<div class="modal fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new country') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('site.admin.countries.store') }}" method='post' id='add-form'>
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ _i('Name') }}</label>
                        <input type="text" class="form-control modal-name" name='name'>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputOrder1">{{ _i('Order') }}</label>
                        <input type="number" class="form-control modal-name" name='order'>
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
