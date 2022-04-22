@if( count($fieldsEn) > 0)

        @foreach($fieldsEn as $key => $field)
        <form action="#"  name="saveTranslateFields" onsubmit="saveTranslate_fields(this)">
            @csrf
            <input type="hidden" id="option_data_id" name="option_data_id" value="{{$field->id}}">
            {{--<input type="hidden" id="option_data_type" name="option_data_type" value="">--}}

            <div class="form-group">
                <div class="input-group mb-3 mt-3">
					<span class="input-group-prepend">
						<i class="ti-tag"></i>
						<label for=""> / {{$field->type}}</label>
					</span>
                </div>
            </div>


            <div class="form-group row">

                <div class="col-sm-4">
                    <label for="">{{_i('Name')}}</label>
                    <div class="input-group">
                        <input class="form-control load" type="text" name="title" value="{{$field->name}}" required id="title">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="">{{_i('Translate')}}</label>
                    <div class="input-group">
                        <input class="form-control load2" type="text" name="translate" id="translate" value="@if(isset($fieldsAr[$key])) @if(($fieldsAr[$key]->source_id == $field->id)){{$fieldsAr[$key]->name}}@endif @endif" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-sm-4">
                    <label for="">{{_i('Description')}}</label>
                    <div class="input-group">
                        <input class="form-control load" type="text" name="title" value="{{$field->desc}}" required id="title">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="">{{_i('Translate')}}</label>
                    <div class="input-group">
                        <input class="form-control load2" type="text" name="translateDesc" id="translateDesc" value="@if(isset($fieldsAr[$key])) @if(($fieldsAr[$key]->source_id == $field->id)){{$fieldsAr[$key]->desc}}@endif @endif" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-2" style="margin-top: 29px;">
                <button  class="btn btn-primary waves-effect waves-light ml-3">{{_i('Save')}}</button>
            </div>
        </form>
        @endforeach

@else
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">{{ _i('Alert') }}</h4>
        <p>{{ _i('No Fields Found') }}</p>
        <hr>
    </div>

@endif





