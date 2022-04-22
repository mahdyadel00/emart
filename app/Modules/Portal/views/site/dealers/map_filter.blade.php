
<div class="col-md-8">

    <!----- site map -->
     
        <div id="mymap"></div>
    

</div>


@push('js')
<!--<script src=" https://maps.googleapis.com/maps/api/js"></script>-->
    <script type="text/javascript">


        var locations = <?php print_r(json_encode($locations)) ?>;
        var latitude = {{$selectedLat}};
        var langitude = {{$selectedlang}};


        var mymap = new GMaps({
            el: '#mymap',
            lat: latitude,
            lng: langitude,
            zoom:6
        });


        $.each( locations, function( index, value ){
            mymap.addMarker({
                lat: value.lat,
                lng: value.lng,
                title: value.city,
                click: function(e) {
                    alert('This is '+value.city+', {{_i('gujarat from Saudi')}}.');
                }
            });
        });

        $('body').on('change', '#filtercity', function (e) {
            e.preventDefault();
            var cityId = $("#filtercity").val();


            $.ajax({
                type:"GET",
                url:"{{route('dealers.index')}}?cityid="+cityId,
                dataType:'json',
                success:function(res){
                    if(res){
                        var mymap = new GMaps({
                            el: '#mymap',
                            lat: res.data.lat,
                            lng: res.data.lng,
                            zoom:6
                        });
                        $.each( locations, function( index, value ){
                            mymap.addMarker({
                                lat: value.lat,
                                lng: value.lng,
                                title: value.city,
                                click: function(e) {
                                    alert('This is '+value.city+', {{_i('gujarat from Saudi')}}.');
                                }
                            });
                        });
                    }
                }
            });
        });

    </script>

@endpush
