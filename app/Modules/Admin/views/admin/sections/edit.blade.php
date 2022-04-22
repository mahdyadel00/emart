@extends('admin.layout.index',
[
'title' => _i('Sections'),
'subtitle' => _i('Sections'),
'activePageName' => _i('Sections'),
'activePageUrl' => route('section.index', 'home_sections'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index')
])
 @section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <h5>{{ _i('Sections') }}</h5>
                        <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Display Title') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="is_title_displayed" {{ $section->is_title_displayed == 1 ? 'checked' : "" }} value="{{ $section->is_title_displayed }}"
                                                class='is_title_displayed'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
                                    <div class="col-sm-9">
                                        <select class="form-control type" name="type" disabled>
                                            {{-- <option selected disabled><?= _i('Select Type') ?></option>
									<option value="latest_products">{{ _i('Latest Products') }}</option>
									<option value="best_selling_products">{{ _i('Best Selling Products') }}</option>
									<option value="most_visited_products">{{ _i('Most Visited Products') }}</option>
									<option value="random_products">{{ _i('Random Products') }}</option> --}}
                                            <option value="image_video"  {{ $section->type == 'image_video' ? 'selected' : '' }}>{{ _i('Image + Video') }}</option>
                                            <option value="image_content"  {{ $section->type == 'image_content' ? 'selected' : '' }}>{{ _i('image content') }}</option>
                                            <option value="random_products"  {{ $section->type == 'random_products' ? 'selected' : '' }}>{{ _i('Random Products') }}</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row image22" hidden>
                                    <label class="col-sm-3 col-form-label" for="image">{{ _i('Image') }}</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image" class="btn btn-default image" accept="image/*">
                                        <img style="width: 150px" id="image_service"
                                            class="img-thumbnail image_service old_img" src="{{ $section->image }}"  >

                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row image_video" hidden>
                                    <label class="col-sm-3 col-form-label" for="video">{{ _i('Video') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="video" class="form-control video1"
                                            placeholder="{{ _i('Youtube Link') }}" value="{{ $section->video }}">
                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('video') }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row success_Products"  >
                                    <label class="col-sm-3 col-form-label">{{ _i('Products') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control myselecttt" name="products[]" data-live-search="true"
                                            multiple>

                                            @foreach ($section->sectionProducts as $product)
                                                @if ($product->detailes != null && $product)
                                                    <option value="{{ $product->id }}" selected>
                                                        {{ $product->detailes->title ?? '' }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Publish') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="published"  {{ $section->published == 1 ? 'checked' : "" }} value="{{ $section->published }}" class='checkbox'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button class="btn btn-info col-md-12" type="submit" id="s_form_1"> {{ _i('Save') }} </button>
                            </div>
                            <input type="hidden" name="section_id" class='section_id' value="{{ $section->id }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $('.myselecttt').select2({
            minimumInputLength: 2,
            placeholder: "{{ _i('Select products') }}",
            ajax: {
                url: "{{ url('admin/settings/sections/autocomplete') }}",

                data: function(params) {
                    var query = {
                        q: params.term,
                    }
                    return query;
                },

                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item);

                            return {
                                text: item.title + ' >> ' + item.cat,
                                id: item.product_id,
                            }
                        })
                    };
                },
                cache: true,
            }


        });
         $(document).ready( function(e) {


           var type ='{{ $section->type }}';
            if (type == 'image_video') {

                $('.image_video').removeAttr('hidden').show();
                $('.image22').removeAttr('hidden').show();
                $('.success_Products ').hide();

            } else if (type == 'image_content') {
                $('.image22').removeAttr('hidden').show();
                 $('.image_video').hide();
                 $('.success_Products ').hide();
            } else if (type == 'header') {
                $('.image22').removeAttr('hidden').show();
                $('.image_video').hide();

            } else {
                // $('.products').removeAttr('hidden').show();
                ///$('.image_video').hide();
                //$('.banner').hide();
                // $('.services').hide();
                // $('.success_partners').hide();
            }

            $('#modal-edit .section_id').val(section_id);
            if (is_title_displayed == 1) {
                $('#modal-edit .is_title_displayed').prop('checked', true);
            } else {
                $('#modal-edit .is_title_displayed').prop('checked', false);
            }
            if (published == 1) {
                $('#modal-edit .checkbox').prop('checked', true);
            } else {
                $('#modal-edit .checkbox').prop('checked', false);
            }

            $('#modal-edit .display_order').val(display_order);
            $('#modal-edit .total').val(total);
            $('#modal-edit .type').val(type);
            $('#modal-edit .categories').val(categories);
            $('#modal-edit .banners').val(banners);
            $('#modal-edit .services').val(services);
            $('#modal-edit .partners').val(partners);
            $("#modal-edit .old_img").attr('src', "{{ asset('') }}/" + image);
            //$("#modal-edit .old_video").attr('src', "{{ asset('') }}/" + video);
            $('#modal-edit .master').val(master);
            $('#modal-edit .video1').val(video);

            $('.selectpicker').selectpicker('refresh');
        });

        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                console.log(e);
                $("#old_img").attr('src', e.target.result).width(100).height(100);
            };
            console.log(input.files);
            filereader.readAsDataURL(input.files[0]);
        }

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('admin/settings/sections/update') }}",
                    type: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_edit').modal('hide');
                            table.ajax.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush
