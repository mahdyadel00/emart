<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="sendGroup" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Enter Message') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" >&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="send_form" class="j-pro" enctype="multipart/form-data" data-parsley-validate=""
                      style="box-shadow:none; background: none">
                    <input type="hidden" name="type" form="send_form" class="type">
                    <input type="hidden" form="send_form"  name="users[]"
                           value="{{ $order->user ? $order->user->id  : null}}">
                    <input type="hidden" form="send_form" name="user_id"  value="{{ $order->user ? $order->user->id : null }}" >
                    <input type="hidden" form="send_form" name="order_id"  value="{{ $order->id }}" >

                    @csrf
                    <div class="j-content">
                        <div class="j-unit">
                            <div class="j-input">
                                <label class="j-icon-left" for="message">
                                    <i class="icofont icofont-file-text"></i>
                                </label>
                                <textarea form="send_form" required placeholder="{{ _i('Message Text') }}"
                                          spellcheck="false"
                                          id="message"
                                          name="message"></textarea>
                                <span
                                    class="j-tooltip j-tooltip-right-top">{{ _i('Describe your Message as detailed as possible') }}</span>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" form="send_form" class="btn btn-primary">{{ _i('Send') }}</button>
            </div>
        </div>
    </div>
</div>

@push('css')

    <link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/j-pro-modern.css')}}">

    <style>

        .j-pro {
            border: none;
        }

        .j-pro .j-primary-btn, .j-pro .j-file-button, .j-pro .j-secondary-btn {
            background: #1abc9c;
        }

        .j-pro .j-primary-btn:hover, .j-pro .j-file-button:hover, .j-pro .j-secondary-btn:hover {
            background: #1abc9c;
        }

        .j-pro input[type="text"]:focus, .j-pro input[type="password"]:focus, .j-pro input[type="email"]:focus, .j-pro input[type="search"]:focus, .j-pro input[type="url"]:focus, .j-pro textarea:focus, .j-pro select:focus {
            border: #1abc9c solid 2px !important;
        }

        .j-pro input[type="text"]:hover, .j-pro input[type="password"]:hover, .j-pro input[type="email"]:hover, .j-pro input[type="search"]:hover, .j-pro input[type="url"]:hover, .j-pro textarea:hover, .j-pro select:hover {
            border: #1abc9c solid 2px !important;
        }

        .card .card-header span {
            color: #fff;
        }

        .j-pro .j-tooltip, .j-pro .j-tooltip-image {
            background-color: #1abc9c;
        }

        .j-pro .j-tooltip-right-top:before {
            border-color: #1abc9c transparent;
        }
    </style>

    <script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.2.2.4.min.js')}}"></script>
    <script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.j-pro.js')}}"></script>

@endpush

@push('js')
    <script>

        $('.send').on('click', function () {
            var type = $(this).data('type');
            $('.type').val(type);
        });

        // send email or sms
        $('#send_form').submit(function (e) {
            e.preventDefault();
            var type = $('.type').val();
            if(type == "notification"){
                var url = "{{ route('userOrderNotification') }}";
            }else{
                var url = "{{ route('UserSend') }}";
            }

            var form = $("#send_form").serialize();
            $.ajax({
                url: url,
                type: "post",
                //data:form,
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function (res) {
                    console.log(res);
                    if (res[0] == false) {
                        $('.modal').modal('hide');
                        $('#error').css('display', 'block');
                        $('#error_text').text(res.message);
                    } else {
                        $('.modal').modal('hide');
                        $('#error').css('display', 'none');
                        $("#send_form").parsley().reset();
                        $('#message').val("");

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Message on its Way')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }

                }
            })
        });
    </script>
@endpush
