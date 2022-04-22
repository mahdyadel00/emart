
<div class="row">
    <div class="col-sm-3 title">
        <label for="">{{ _i('Name') }}</label>

    </div>

    <div class="col-sm-4">
        <label for="">{{ _i('Value') }}</label>

    </div>

    <div class="col-sm-2">
        <label for="">{{ _i('Active') }}</label>
    </div>
    <div class="col-sm-3">
        <button type="button" class="btn btn-success  plusss" data-id=""><i class="ion-plus-round"></i>
        </button>
    </div>

</div>
@if (count($rowsData) > 0)


    @foreach ($rowsData as $key => $items)


        <!-- Tab panes -->
        <div class="row mt-3">
            <div class="col-sm-3 title">
                <select name="title[{{ $items->id }}][]" id="title_{{ $key }}"
                    class="form-control selectpicker select-append selects_{{ $key }}" data-live-search="true"
                    data-toggle='tooltip' data-placement='top' title="{{ _i('Label') }}"
                    style="display: block!important;" required>
                    @foreach ($labels as $label)
                        <option value="{{ $label->id }}" id="options_{{ $key }}" @if ($items->lable_id == $label->id) selected @endif>
                            {{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title ?? $label->Data->first()->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4">
                <select name="detail[{{ $items->id }}][]"
                    class="selectpicker2 select-append2 form-control values_{{ $key }}"
                    data-live-search="true" data-toggle='tooltip' data-placement='top' title="{{ _i('Label') }}"
                    style="display: block!important;" required id="detail_{{ $key }}">
                    @foreach ($labelsData as $label)
                        <option
                            value="{{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->value ?? $label->Data->first()->value }}"
                            id="value_{{ $key }}" @if ($items->id == $label->Data->first()->item_id) selected @endif>
                            {{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->value ?? $label->Data->first()->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-2">

                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name=" @if ($items->active == 0) filter[{{ $items->id }}][] @else hide_filter[{{ $items->id }}][] @endif" value="0">

                        <input type="checkbox" @if ($items->active == 1) checked @endif value="1" name="filter[{{ $items->id }}][]"
                            onchange="changeNext(this)">

                        <span class="cr">
                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                        </span>
                    </label>
                </div>

            </div>
            <div class="col-sm-3">
                <button type="button" class=" remove-tr btn btn-danger" data-id="{{ $items->id }}"
                    data-product_id="{{ $items->product_id }}"><i class="ion-minus"></i></button>

            </div>

        </div>
    @endforeach
@else

    <div class=" row">
        <div class="col-sm-3 title">
            <div class="input-group">
                <select name="title[new][]" id="title_0" class="form-control selectpicker cloned select2"
                    data-live-search="true" data-toggle='tooltip' data-placement='top' title={{ _i('Label') }} required>
                    @foreach ($labels as $label)
                        <option value="{{ $label->id }}" id="options_0">
                            {{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title ?? $label->Data->first()->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4 input_fields">
            <select name="detail[new][]" class=" selectpicker2 form-control" data-live-search="true"
                data-toggle='tooltip' data-placement='top' title={{ _i('Label') }} required id="detail_0">
                @foreach ($labelsData as $label)
                    <option value="{{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->value ?? $label->Data->first()->value }}" id="value_0">
                        {{ $label->Data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->value ?? $label->Data->first()->value }}
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
@endif
