<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
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
                    <form  action="{{url('admin/affiliate/settings/methods/lang/store')}}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >

                        <div class="box-body">
                            <div class="form-group row">
                                <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Name')?> <span style="color: #F00;">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" class="form-control" name="name" required="" placeholder="{{_i('Place Enter Name')}}">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{_i('Save')}}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>