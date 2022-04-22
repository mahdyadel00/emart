<div class="col-md-12 mb-3">
    <form action="{{route('admin.colorGroup.update')}}" id="myForm" method="post" class="form-horizontal"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="row_product_id" name="group_id">
        <div class="row">
            <div class="col-sm-5">

                <input class="form-control load" type="text" name="title" placeholder="{{_i('Color Group name ...')}}" value="{{$color_group->data->title}}" required>

            </div>
			<div class="col-sm-5 m-b-30">
				<input type="text" id="text-field" style="width:200px;height:35px"
					class="form-control demo" value="{{$color_group->color}}" name="color">
			</div>
            <div class="col-sm-1">
                <div class="input-group">
                    <button type="submit" id="submitBtn" class="btn btn-info">
                        {{_i('Update')}}
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    @foreach($feature_oprions as $feature)
                        @if($feature !== null)
                        <div class="custom-control custom-checkbox">

                            <label class="custom-
                                -label" for="updatefilterCheck{{ $feature->id }}">
                                    <span class="coloring-options">
                                        <div class="backGround-colorGroup" style="background-color: {{ $feature->title  }};"></div>
                                    </span>
                                {{ $feature->name ?? $feature->title}}
                                <input type="checkbox" name='filter[]' class="checkbox-colorGroup"
                                       id="updatefilterCheck{{ $feature->id  }}"
                                       value="{{ $feature->id  }}" @if(in_array($feature->id,$color_group_option)) checked @endif>
                            </label>

                        </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    </form>
</div>
