


<div class="col-md-12 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Most Visited Pages') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <canvas id="myChartMost" width="400" height="400"></canvas>
        </div>
    </div>
</div>


@section('myChartMost')
    <script>
        var ctx = document.getElementById('myChartMost').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($MostDataTitle, JSON_NUMERIC_CHECK); ?>,
                datasets: [
                    {
                        label: <?php echo json_encode($MostDataUrl, JSON_NUMERIC_CHECK); ?>,
                        data: <?php echo json_encode($MostDataViews, JSON_NUMERIC_CHECK); ?>,
                        borderColor: <?php echo json_encode($color[0], JSON_NUMERIC_CHECK); ?>,
                        fill: false,
                        stepped: true,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    intersect: false,
                    axis: 'x'
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Most Visited Pages',
                    }
                }
            }

        });
    </script>
    @endsection