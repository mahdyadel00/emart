<ul class="top-level-menu">
    <li>
        <div class="input-group">
            {{-- <span class="input-group-addon"><i class="ti-menu-alt"></i></span> --}}
            <input type="text" class="form-control pname" placeholder="Prodcut Name" id="filter_search">
            <button class="btn btn-default" onclick="filter_search()">{{ _i('Search') }}</button>
        </div>
    </li>
    <li>
        <button class="btn btn-dark first_link">{{ _i('Services') }}</button>
        <ul class="second-level-menu">
            <li>
                <a href="{{ route('categories.index') }}">{{ _i('Categories') }}</a>
            </li>
{{--            <li>--}}
{{--                <a href="{{ route('admin.getTranslateDetail.index') }}">{{ _i('Translate Labels') }}</a>--}}
{{--            </li>--}}
        </ul>
    </li>
</ul>
@push('css')
    <style>
        .first_link:after {
            content: "\e64b";
            font-family: themify;
            margin-left: 35px;
        }

        .third-level-menu {
            position: absolute;
            top: 0;
            left: -250px;
            width: 150px;
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
        }

        .third-level-menu>li {
            height: 30px;
            width: 250px;
            background: #fff;
        }

        .third-level-menu>li:hover {
            background: #CCCCCC;
        }

        .second-level-menu {
            position: absolute;
            top: 30px;
            right: 0;
            width: 150px;
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
        }

        .second-level-menu>li {
            position: relative;
            height: 40px;
            background: #fff;
        }

        .second-level-menu>li:hover {
            background: #CCCCCC;
        }

        .top-level-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .top-level-menu>li {
            position: relative;
            float: left;
            height: 30px;
            margin-right: 15px;
            background: #5dd5c4;
            border-radius: 50px;
        }

        .top-level-menu>li:hover {
            background: #CCCCCC;
        }

        .top-level-menu li:hover>ul {
            /* On hover, display the next level's menu */
            display: inline-block;
            z-index: 99999;
        }

        /* Menu Link Styles */
        .top-level-menu a

        /* Apply to all links inside the multi-level menu */
            {
            color: #666;
            text-decoration: none;
            padding: 0 0 0 10px;
            /* Make the link cover the entire list item-container */
            display: block;
            line-height: 30px;
        }

        .top-level-menu a:hover {
            color: #000000;
        }

    </style>
@endpush

@push('js')
    <script>
        $('.status').on('click', function() {
            var code = $(this).data('code');
            $.ajax({
                url: '{{ route('product.getstatus') }}',
                method: 'GET',
                DataType: 'json',
                data: {
                    code: code
                },
                success: function(res) {
                    console.log(res);
                    $('#allProducts_div').html(res);
                    $('.selectpicker').selectpicker('refresh');
                }
            })
        });

        function filter_search() {
            var text = $("#filter_search").val();
            $.ajax({
                url: '{{ route('product.product_search') }}',
                method: 'GET',
                DataType: 'json',
                data: {
                    keyword: text
                },
                success: function(res) {
                    //console.log(res);
                    $('#allProducts_div').html(res);

                   //$('#allProducts_div').empty();
                   // $('#allProducts_div2').empty();
                   //  $('#allProducts_div').html(res);
                    $('.selectpicker').selectpicker('refresh');
                }
            })
        }
        $('.brand').on('click', function() {
            var code = $(this).data('id');
            $.ajax({
                url: '{{ route('product.getbrand') }}',
                method: 'GET',
                DataType: 'json',
                data: {
                    id: code
                },
                success: function(res) {
                    console.log(res);
                    $('#allProducts_div').html(res);
                    $('.selectpicker').selectpicker('refresh');
                }
            })
        });
        $('.category').on('click', function() {
            var category = $(this).data('category');
            $.ajax({
                url: '{{ route('product.getcategory') }}',
                method: 'GET',
                DataType: 'json',
                data: {
                    category: category
                },
                success: function(res) {
                    console.log(res);
                    $('#allProducts_div').html(res);
                    $('.selectpicker').selectpicker('refresh');
                }
            })
        });
        $('a.type').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route('product.gettype') }}',
                method: 'GET',
                DataType: 'json',
                data: {
                    id: id
                },
                success: function(res) {
                    console.log(res);
                    $('#allProducts_div').html(res);
                    $('.selectpicker').selectpicker('refresh');
                }
            })
        })
    </script>
@endpush
