<script>
    $(document).on('click', '.remove-record', function(){
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var token = '{{csrf_token()}}';
            $(".remove-record-model").attr("action", url);
            $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="'+ token +'">');
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        });
        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
        $('.modal').click(function() {
            // $('body').find('.remove-record-model').find( "input" ).remove();
        });
</script>

<a href="#" class="btn color-white waves-effect waves-light btn-primary edit" title="{{_i('Edit')}}" data-toggle="modal" data-target="#edit-modal" data-url='{{route('ticket.priority.update', $id)}}' data-id='{{$id}}' data-lang_id='{{$lang_id}}' data-name='{{$name}}' data-description='{{$description}}' data-color='{{$color}}' data-display_order='{{$display_order}}'>
    <i class="ti-pencil-alt"></i> {{_i('Edit')}}
</a>
<a class="btn color-white waves-effect waves-light btn btn-danger remove-record" data-toggle="modal" data-url="{{route('ticket.priority.destroy', $id) }}" data-id="{{$id}}" data-target="#delete-modal"  title="{{_i('Delete')}}">
    <i class="ti-trash"></i> {{_i('Delete')}}
</a>

<div class="btn-group">
   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
        <span class="ti ti-settings"></span>
    </button>
    <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
    @foreach (get_languages() as $lang)
        <li><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="{{$id}}" data-lang="{{$lang->id}}" style="display: block; padding: 5px 10px 10px;">{{$lang->title}}</a></li>
    @endforeach
    </ul>
</div> 

<form action="" method="POST" class="remove-record-model" action=''>
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">{{ _i('Delete') }}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{ _i('Are You Sure You want To Delete ?') }}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{ _i('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ _i('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>