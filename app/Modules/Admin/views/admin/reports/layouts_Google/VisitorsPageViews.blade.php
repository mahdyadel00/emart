


<div class="col-md-12 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Visitors And Page Views') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>



@section('myChart')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($dataLabels, JSON_NUMERIC_CHECK); ?>,
                datasets: [
                    {
                        label: 'Visitors',
                        data: <?php echo json_encode($datavisitors, JSON_NUMERIC_CHECK); ?>,
                        borderColor: <?php echo json_encode($color[2], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: <?php echo json_encode($color[0], JSON_NUMERIC_CHECK); ?>,
                        order: 1
                    },
                    {
                        label: 'pageViews',
                        data: <?php echo json_encode($datapageViews, JSON_NUMERIC_CHECK); ?>,
                        borderColor: <?php echo json_encode($color[3], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: <?php echo json_encode($color[1], JSON_NUMERIC_CHECK); ?>,
                        type: 'line',
                        order: 0
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
                        text: 'Visitors And Page Views'
                    }
                }
            },

        });
    </script>
    @endsection