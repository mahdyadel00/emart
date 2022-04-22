@extends('admin.layout.index',[
	'title' => _i('Pages'),
	'subtitle' => _i('Create Page'),
	'activePageName' => _i('Create Page'),
	'activePageUrl' => route('pages.create'),
	'additionalPageName' => 'Pages',
	'additionalPageUrl' => route('pages.index') ,
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5> {{ _i('Add Page') }} </h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
					<form method="POST" action="store" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
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
									<small  class="form-text text-muted">{{_i('Please select language to show article categories')}}</small>
								</div>
							</div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 control-label" >{{ _i('Place') }} <span style="color: #F00;">*</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="place" id="language_addform" required="">
                                        <option selected disabled>{{_i('CHOOSE')}}</option>
                                        @foreach($places as $place)
                                            <option value="{{$place}}">{{_i($place)}}</option>
                                        @endforeach
                                    </select>
                                    <small  class="form-text text-muted">{{_i('Please select where to put your page')}}</small>
                                </div>
                            </div>

							<div class="form-group row">
								<label for="title" class="col-sm-2 control-label" >{{ _i('Title') }} <span style="color: #F00;">*</span></label>
								<div class="col-sm-6">
                                    <input type="hidden" name="page_order" value="5">
									<input  type="text"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}"  placeholder=" {{_i('Page Title')}}" required="">
									@if ($errors->has('title'))
										<span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>
							</div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-2 control-label" >{{ _i('Image') }} <span style="color: #F00;">*</span></label>
                                <div class="col-sm-6">
                                    <input  type="file"  class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" value="{{ old('image') }}"  placeholder=" {{_i('Image')}}" required="">
                                    @if ($errors->has('image'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('image') }}</strong>
										</span>
                                    @endif
                                </div>
                            </div>

							<div class="form-group row" >
								<label class="col-sm-2 col-form-label" for="checkbox">
									{{_i('Publish')}}
								</label>
								<div class="checkbox-fade fade-in-primary col-sm-6">
									<label>
										<input type="checkbox"  id="checkbox" name="published" value="1" {{old('published') == 1 ? 'checked' : ''}}>
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
										</span>
									</label>
								</div>
							</div>

							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">{{_i('Content')}} <span style="color: #F00;">*</span> </label>
								<div class="col-sm-10">
                                    <textarea required="" id="editor1" class="form-control " name="content"   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" placeholder="Place write content here...">{{old('content')}}</textarea>
									@if($errors->has('content'))
										<span class="text-danger invalid-feedback" role="alert">
									<strong>{{ $errors->first('content')}}</strong>
								</span>
									@endif
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
	</div>
@endsection

@push('js')

    <script>
        $(function () {
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{asset('admin_dashboard/bower_components/ckeditor/ck_upload_master.php')}}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
@endpush







