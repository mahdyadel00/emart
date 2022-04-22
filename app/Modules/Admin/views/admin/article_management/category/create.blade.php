@extends('admin.layout.index',[
    'title' => _i('Create Blog Category'),
    'subtitle' => _i('Create Blog Category'),
    'activePageName' => _i('Create Blog Category'),
    'activePageUrl' => route('blog_categories.index'),
    'additionalPageName' => _i('Settings'),
    'additionalPageUrl' => route('settings.index') ,
] )
@section('content')
    <div class="page-body">
        <div class="card blog-page" id="blog">
            <div class="card-block">
                <form method="POST" action="{{ route('blog_categories.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body card-block">
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 control-label" >{{ _i('Language') }} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="lang_id" id="language_addform" required="">
                                    <option selected disabled="">{{_i('CHOOSE')}}</option>
                                    @foreach($langs as $lang)
                                        <option value="{{$lang->id}}">{{_i($lang->title)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 control-label" >{{ _i('Title') }} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-6">
                                <input  type="text"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}"  placeholder=" {{_i('Blog Category Title')}}" required="">
                                @if ($errors->has('title'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active" class="col-sm-2 control-label">{{ _i('Publish') }}</label>
                            <div class="col-sm-3">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input id="is_active" type="checkbox" name="published" value="1" >
                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">{{_i('Image')}}</label>
                            <div class="col-sm-4">
                                <input type="file" name="img_url" id="filex" onchange="showImg(this)" class="btn btn-default" accept="image/*" value="{{old('img_url')}}">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('img_url')}}</strong>
                                </span>
                            </div>
                            <div class="col-sm-6">
                                <img class="img-responsive pad " id="article_img" style="margin: 0 auto;display: block" >
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <button class="btn btn-primary col-sm-6">{{_i('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                console.log(e);
                $('#article_img').attr('src', e.target.result).width(270).height(220);
            };
            console.log(input.files);
            filereader.readAsDataURL(input.files[0]);
        }
    </script>

@endpush
