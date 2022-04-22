

<div class="col-md-12 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Top browsers') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <canvas id="myChartTopBrowsers" width="400" height="400"></canvas>
        </div>
    </div>
</div>



@section('myChartTopBrowsers')
    <script>
        var ctx = document.getElementById('myChartTopBrowsers').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: <?php echo json_encode($TopBrowsDatabro, JSON_NUMERIC_CHECK); ?>,
                datasets: [
                    {
                        label: 'Top browsers',
                        data: <?php echo json_encode($TopBrowsDatasessions, JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: <?php echo json_encode($color, JSON_NUMERIC_CHECK);?>
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Top browsers'
                    }
                }
            },
        });
    </script>
@endsection