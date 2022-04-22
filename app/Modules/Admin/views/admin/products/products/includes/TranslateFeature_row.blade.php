
@if( count($features) > 0 && count($features[0]->optionsSourceNull) > 0)
        <form action="#"  name="saveTranslateFeatureType" onsubmit="saveTranslateFeature(this)">
            <div class="form-group row" id="get_new_data-1">
                <input type="hidden" id="id" name="id" value="{{$features[0]->features_data_id}}">
                <div class="col-sm-4">
                    <label for="">{{_i('Name feature')}}</label>
                    <div class="input-group">
                        <input class="form-control load" type="text" name="type" value="{{$features[0]->title}}" required id="type">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="">{{_i('Translate')}}</label>
                    <div class="input-group">
                        {{--<input class="form-control load2" type="text" name="translateType" id="translateType" value="@if(isset($featuresNotNull[0]))@if(($features[0]->features_data_id == $featuresNotNull[0]->source_id)){{$featuresNotNull[0]->title}} @endif @endif" required>--}}
                        <input class="form-control load2" type="text" name="translateType" id="translateType" value="{{ $features[0]->title == 'اللون' ? 'color':'size'}}" required>

                    </div>
                </div>

                <div class="col-sm-2" style="margin-top: 29px;">
                    <button  class="btn btn-primary waves-effect waves-light ml-3">{{_i('Save')}}</button>
                </div>


            </div>
        </form>


        @foreach($features[0]->optionsSourceNull as $key => $option)
        <form action="#"  name="saveTranslate" onsubmit="saveTranslate_feature(this)">
            @csrf


            <div class="form-group row" id="get_new_data-1">
                <input type="hidden" id="option_data_id" name="option_data_id" value="{{$option->option_data_id}}">
                <input type="hidden" id="option_data_type" name="option_data_type" value="{{$features[0]->type}}">

                <div class="col-sm-4">
                    <label for="">{{_i('Name')}}</label>
                    <div class="input-group">
                        <input class="form-control load" type="text" name="title" value="@if($option->source_id == null) @if($features[0]->type == 'color') {{$option->name}} @else {{$option->title}} @endif @endif" required id="title">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="">{{_i('Translate')}}</label>
                    <div class="input-group">
                        <input class="form-control load2" type="text" name="translate" id="translate" value="@if(isset($features[0]->optionsSourceNotNull[$key])) @if(($features[0]->optionsSourceNotNull[$key]->source_id == $option->option_data_id)){{$features[0]->optionsSourceNotNull[$key]->name}}@endif @endif" required>
                    </div>
                </div>

                <div class="col-sm-2" style="margin-top: 29px;">
                    <button  class="btn btn-primary waves-effect waves-light ml-3">{{_i('Save')}}</button>
                </div>


            </div>
        </form>
        @endforeach

@else
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">{{ _i('Alert') }}</h4>
        <p>{{ _i('No Feature Found') }}</p>
        <hr>
    </div>

@endif





