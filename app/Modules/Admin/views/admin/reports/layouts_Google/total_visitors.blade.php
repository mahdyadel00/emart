


<div class="col-md-12 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Total visitors and pageviews') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <canvas id="myChartTotal" width="400" height="400"></canvas>
        </div>
    </div>
</div>

@section('myChartTotal')
<script>
    var ctx = document.getElementById('myChartTotal').getContext('2d');
    var DATA_COUNT = <?php echo json_encode($totalData_count, JSON_NUMERIC_CHECK); ?>;
    const labels = [];
    for (let i = 0; i < DATA_COUNT; ++i) {
        labels.push(i.toString());
    }
    var myChart = new Chart(ctx, {
        type: 'bubble',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Most Visitors',
                    data: <?php echo json_encode($TotalDataVisitors, JSON_NUMERIC_CHECK); ?>,
                    borderColor: <?php echo json_encode($color[0], JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: <?php echo json_encode($color[1], JSON_NUMERIC_CHECK); ?>,
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                }, {
                    label: 'Most pageViews',
                    data: <?php echo json_encode($TotalDataViews, JSON_NUMERIC_CHECK); ?>,
                    borderColor: <?php echo json_encode($color[4], JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: <?php echo json_encode($color[1], JSON_NUMERIC_CHECK); ?>,
                    fill: false,
                    tension: 0.4
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
                    text: 'Total visitors and pageviews'
                }
            }
        },

    });
</script>

    @endsection