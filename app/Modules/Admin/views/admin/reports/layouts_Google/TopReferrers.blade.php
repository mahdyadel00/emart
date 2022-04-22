


<div class="col-md-12 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Top referrers') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <canvas id="myChartTopReferrers" width="400" height="400"></canvas>
        </div>
    </div>
</div>


@section('myChartTopReferrers')
    <script>
        var ctx = document.getElementById('myChartTopReferrers').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($TopDataUrl, JSON_NUMERIC_CHECK); ?>,
                datasets: [
                    {
                        label: 'Top Referrers',
                        data: <?php echo json_encode($TopDataViews, JSON_NUMERIC_CHECK); ?>,
                        borderColor: <?php echo json_encode($color[0], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: <?php echo json_encode($color[4], JSON_NUMERIC_CHECK); ?>,
                        fill: true
                    }
                ]
            },
            options: {
                plugins: {
                    filler: {
                        propagate: false,
                    },
                    title: {
                        display: true,
                        text: 'Top Referrers'
                    }
                },
                pointBackgroundColor: '#fff',
                radius: 10,
                interaction: {
                    intersect: false,
                }
            },
        });
    </script>
    @endsection