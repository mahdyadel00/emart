<div class=" row">
    <div class="col-sm-3 title">
        <div class="input-group">
            <select name="title[new][]" id="title_0" class="form-control selectpicker  cloned  select2"
                data-live-search="true" data-toggle='tooltip' data-placement='top' title={{ _i('Label') }}>
                @foreach ($labels as $label)
                    <option value="{{ $label->lable_id }}" id="options_0">
                        {{ $label->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4 input_fields">
        <select name="detail[new][]" class=" selectpicker2 form-control" data-live-search="true" data-toggle='tooltip'
            data-placement='top' title={{ _i('Label') }} required id="detail_0">
            @foreach ($labelsData as $label)
                <option value="{{ $label->value }}" id="value_0">
                    {{ $label->value }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-2">
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="hidden" name="hide_filter[new][]" value="0">
                <input type="checkbox" checked="" value="1" name="filter[new][]" onchange="changeNext(this)">
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-2">
        <button type="button" class=" remove-tr  btn btn-danger  "><i class="ion-minus"></i></button>
    </div>
</div>
