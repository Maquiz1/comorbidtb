<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHARTJS</title>
    <style type="text/css">
        .chartBox {
            width: 700px;
        }
    </style>
</head>

<body>
    <?php
    $barchart = $override->getDataPoints();
    $revenue = array();
    $lableaxis = array();


    foreach ($barchart as $value) {
        $revenue[] = $value['datapoint'];
        $lableaxis[] = ucwords($value['lableaxis']);
        $descriptionlabel = $value['descriptionlabel'];
        $bgcolor = $value['bgcolor'];
        $bordercolor = $value['bordercolor'];
    }

    // print_r($bordercolor);



    ?>



    <div class="chartBox">
        <canvas id="myChart"></canvas>
        <!-- <canvas id="myChart" width="400" height="400"></canvas> -->
    </div>
    <div class="buttonBox">
        <button onclick="showData(5)">Show limited Data</button>
        <button onclick="showData(7)">Show 7 limited Data</button>
        <button onclick="resetData()">Show All Data</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        // SETUP BLOCK

        const revenue = <?php echo json_encode($revenue) ?>;
        const lableaxis = <?php echo json_encode($lableaxis) ?>;
        const descriptionlabel = <?php echo json_encode($descriptionlabel) ?>;
        const bgcolor = <?php echo json_encode($bgcolor) ?>;
        const bordercolor = <?php echo json_encode($bordercolor) ?>;

        const data = {
            labels: lableaxis,
            datasets: [{
                label: descriptionlabel,
                data: revenue,
                backgroundColor: bgcolor,
                borderColor: bordercolor,
                borderWidth: 1
            }]
        }
        //CONFIG BLOCK
        const config = {
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }

        //RENDER BLOCK
        const myChart = new Chart(document.getElementById('myChart'), config);

        function showData(num) {
            const revenueSliced = revenue.slice(0, num);
            const lableaxisSliced = lableaxis.slice(0, num)
            myChart.data.datasets[0].data = revenueSliced;
            myChart.data.labels = lableaxisSliced;
            myChart.update();
        }

        function resetData(num) {
            myChart.data.datasets[0].data = revenue;
            myChart.data.labels = lableaxis;
            myChart.update();
        }
    </script>

</body>

</html>