<?php

$history = "";
$dashboard = "";
$home = "";
$settings = "";
$live = "";

$history =  "style='background-color:#fed215;font-weight:bolder;'";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Page</title>
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <link href="../css/history.css" rel="stylesheet" />
    <link href="../images/icon1.png" rel="icon" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-5">
                <?php require "myNav.php"; ?>
            </div>
        </div>
        <div class="row p-5">
            <!-- temperature graph -->
            <div id="temperature_chart" style="width: 100%; height: 400px;"></div>
            <select id="timeInterval_fortemperature" class="form-select mx-auto" aria-label="Default select example" style="width:100px;">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <!-- temperature graph -->
            <!-- pressure -->
            <div class="mt-5" id="pressure_chart" style="width: 100%; height: 400px;"></div>
            <select id="timeInterval_forpressure" class="form-select mx-auto" aria-label="Default select example" style="width:100px;">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <!-- pressure -->
            <!-- humidity -->
            <div class="mt-5" id="humidity_chart" style="width: 100%; height: 400px;"></div>
            <select id="timeInterval_forhumidity" class="form-select mx-auto" aria-label="Default select example" style="width:100px;">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <!-- humidity -->
            <!-- tvoc -->
            <div class="mt-5" id="tvoc_chart" style="width: 100%; height: 400px;"></div>
            <select id="timeInterval_fortvoc" class="form-select mx-auto" aria-label="Default select example" style="width:100px;">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <!-- tvoc -->
            <!-- co2 -->
            <div class="mt-5" id="co2_chart" style="width: 100%; height: 400px;"></div>
            <select id="timeInterval_forco2" class="form-select mx-auto" aria-label="Default select example" style="width:100px;">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <!-- co2 -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- temperature -->
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Days');

            var options = {
                hAxis: {
                    title: 'Time',
                    logScale: false,
                    format: '0',
                    ticks: []
                },
                vAxis: {
                    title: 'Temperature',
                    logScale: false
                },
                colors: ['#FF6B6B']
            };

            var chart = new google.visualization.LineChart(document.getElementById('temperature_chart'));

            var select = document.getElementById('timeInterval_fortemperature');
            select.addEventListener('change', function() {
                var interval = select.value;
                updateData(interval);
            });

            function updateData(interval) {
                var newData = [];
                var hAxisTitle = 'Time';
                var hAxisTicks = [];
                switch (interval) {
                    case 'hours':
                        newData = [
                            [0, 0],
                            [6, 10],
                            [12, 23],
                            [18, 17],
                            [24, 18],
                            [30, 9],
                            [36, 11],
                            [42, 27],
                            [48, 33],
                            [54, 40],
                            [60, 32],
                            [66, 35],
                            [69, 30]
                        ];
                        hAxisTitle = 'Hours';
                        hAxisTicks = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 66, 69];
                        break;
                    case 'days':
                        newData = [
                            [0, 0],
                            [1, 10],
                            [2, 23],
                            [3, 17],
                            [4, 18],
                            [5, 9],
                            [6, 11],
                            [7, 27],
                            [8, 33],
                            [9, 40],
                            [10, 32],
                            [11, 35],
                            [12, 30],
                            [13, 40],
                            [14, 42],
                            [15, 47],
                            [16, 44],
                            [17, 48],
                            [18, 52],
                            [19, 54],
                            [20, 42],
                            [21, 55],
                            [22, 56],
                            [23, 57],
                            [24, 60],
                            [25, 50],
                            [26, 52],
                            [27, 51],
                            [28, 49],
                            [29, 53],
                            [30, 55],
                            [31, 60],
                            [32, 61],
                            [33, 59],
                            [34, 62],
                            [35, 65],
                            [36, 62],
                            [37, 58],
                            [38, 55],
                            [39, 61],
                            [40, 64],
                            [41, 65],
                            [42, 63],
                            [43, 66],
                            [44, 67],
                            [45, 69],
                            [46, 69],
                            [47, 70],
                            [48, 72],
                            [49, 68],
                            [50, 66],
                            [51, 65],
                            [52, 67],
                            [53, 70],
                            [54, 71],
                            [55, 72],
                            [56, 73],
                            [57, 75],
                            [58, 70],
                            [59, 68],
                            [60, 64],
                            [61, 60],
                            [62, 65],
                            [63, 67],
                            [64, 68],
                            [65, 69],
                            [66, 70],
                            [67, 72],
                            [68, 75],
                            [69, 80]
                        ];
                        hAxisTitle = 'Days';
                        hAxisTicks = [0, 10, 20, 30, 40, 50, 60];
                        break;
                    case 'weeks':
                        newData = [
                            [0, 0],
                            [14, 23],
                            [28, 40],
                            [42, 52],
                            [56, 70],
                            [69, 30]
                        ];
                        hAxisTitle = 'Weeks';
                        hAxisTicks = [0, 14, 28, 42, 56, 69];
                        break;
                    case 'months':
                        newData = [
                            [0, 0],
                            [30, 23],
                            [60, 40],
                            [69, 30]
                        ];
                        hAxisTitle = 'Months';
                        hAxisTicks = [0, 30, 60, 69];
                        break;
                }
                data.removeRows(0, data.getNumberOfRows());
                data.addRows(newData);
                options.hAxis.title = hAxisTitle;
                options.hAxis.ticks = hAxisTicks;
                drawChart();
            }

            function drawChart() {
                chart.draw(data, options);
            }

            updateData('days'); // Set the initial data

            // ...
        }
    </script>
    <!-- temperature -->
    <!-- pressure -->
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Days');

            var options = {
                hAxis: {
                    title: 'Time',
                    logScale: false,
                    format: '0',
                    ticks: []
                },
                vAxis: {
                    title: 'Pressure',
                    logScale: false
                },
                colors: ['#FF8B13']
            };

            var chart = new google.visualization.LineChart(document.getElementById('pressure_chart'));

            var select = document.getElementById('timeInterval_forpressure');
            select.addEventListener('change', function() {
                var interval = select.value;
                updateData(interval);
            });

            function updateData(interval) {
                var newData = [];
                var hAxisTitle = 'Time';
                var hAxisTicks = [];
                switch (interval) {
                    case 'hours':
                        newData = [
                            [0, 0],
                            [6, 10],
                            [12, 23],
                            [18, 17],
                            [24, 18],
                            [30, 9],
                            [36, 11],
                            [42, 27],
                            [48, 33],
                            [54, 40],
                            [60, 32],
                            [66, 35],
                            [69, 30]
                        ];
                        hAxisTitle = 'Hours';
                        hAxisTicks = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 66, 69];
                        break;
                    case 'days':
                        newData = [
                            [0, 0],
                            [1, 10],
                            [2, 23],
                            [3, 17],
                            [4, 18],
                            [5, 9],
                            [6, 11],
                            [7, 27],
                            [8, 33],
                            [9, 40],
                            [10, 32],
                            [11, 35],
                            [12, 30],
                            [13, 40],
                            [14, 42],
                            [15, 47],
                            [16, 44],
                            [17, 48],
                            [18, 52],
                            [19, 54],
                            [20, 42],
                            [21, 55],
                            [22, 56],
                            [23, 57],
                            [24, 60],
                            [25, 50],
                            [26, 52],
                            [27, 51],
                            [28, 49],
                            [29, 53],
                            [30, 55],
                            [31, 60],
                            [32, 61],
                            [33, 59],
                            [34, 62],
                            [35, 65],
                            [36, 62],
                            [37, 58],
                            [38, 55],
                            [39, 61],
                            [40, 64],
                            [41, 65],
                            [42, 63],
                            [43, 66],
                            [44, 67],
                            [45, 69],
                            [46, 69],
                            [47, 70],
                            [48, 72],
                            [49, 68],
                            [50, 66],
                            [51, 65],
                            [52, 67],
                            [53, 70],
                            [54, 71],
                            [55, 72],
                            [56, 73],
                            [57, 75],
                            [58, 70],
                            [59, 68],
                            [60, 64],
                            [61, 60],
                            [62, 65],
                            [63, 67],
                            [64, 68],
                            [65, 69],
                            [66, 70],
                            [67, 72],
                            [68, 75],
                            [69, 80]
                        ];
                        hAxisTitle = 'Days';
                        hAxisTicks = [0, 10, 20, 30, 40, 50, 60];
                        break;
                    case 'weeks':
                        newData = [
                            [0, 0],
                            [14, 23],
                            [28, 40],
                            [42, 52],
                            [56, 70],
                            [69, 30]
                        ];
                        hAxisTitle = 'Weeks';
                        hAxisTicks = [0, 14, 28, 42, 56, 69];
                        break;
                    case 'months':
                        newData = [
                            [0, 0],
                            [30, 23],
                            [60, 40],
                            [69, 30]
                        ];
                        hAxisTitle = 'Months';
                        hAxisTicks = [0, 30, 60, 69];
                        break;
                }
                data.removeRows(0, data.getNumberOfRows());
                data.addRows(newData);
                options.hAxis.title = hAxisTitle;
                options.hAxis.ticks = hAxisTicks;
                drawChart();
            }

            function drawChart() {
                chart.draw(data, options);
            }

            updateData('days'); // Set the initial data

            // ...
        }
    </script>
    <!-- pressure -->
    <!-- humidity -->
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Days');

            var options = {
                hAxis: {
                    title: 'Time',
                    logScale: false,
                    format: '0',
                    ticks: []
                },
                vAxis: {
                    title: 'Humidity Level',
                    logScale: false
                },
                colors: ['#6BCB77']
            };

            var chart = new google.visualization.LineChart(document.getElementById('humidity_chart'));

            var select = document.getElementById('timeInterval_forhumidity');
            select.addEventListener('change', function() {
                var interval = select.value;
                updateData(interval);
            });

            function updateData(interval) {
                var newData = [];
                var hAxisTitle = 'Time';
                var hAxisTicks = [];
                switch (interval) {
                    case 'hours':
                        newData = [
                            [0, 0],
                            [6, 10],
                            [12, 23],
                            [18, 17],
                            [24, 18],
                            [30, 9],
                            [36, 11],
                            [42, 27],
                            [48, 33],
                            [54, 40],
                            [60, 32],
                            [66, 35],
                            [69, 30]
                        ];
                        hAxisTitle = 'Hours';
                        hAxisTicks = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 66, 69];
                        break;
                    case 'days':
                        newData = [
                            [0, 0],
                            [1, 10],
                            [2, 23],
                            [3, 17],
                            [4, 18],
                            [5, 9],
                            [6, 11],
                            [7, 27],
                            [8, 33],
                            [9, 40],
                            [10, 32],
                            [11, 35],
                            [12, 30],
                            [13, 40],
                            [14, 42],
                            [15, 47],
                            [16, 44],
                            [17, 48],
                            [18, 52],
                            [19, 54],
                            [20, 42],
                            [21, 55],
                            [22, 56],
                            [23, 57],
                            [24, 60],
                            [25, 50],
                            [26, 52],
                            [27, 51],
                            [28, 49],
                            [29, 53],
                            [30, 55],
                            [31, 60],
                            [32, 61],
                            [33, 59],
                            [34, 62],
                            [35, 65],
                            [36, 62],
                            [37, 58],
                            [38, 55],
                            [39, 61],
                            [40, 64],
                            [41, 65],
                            [42, 63],
                            [43, 66],
                            [44, 67],
                            [45, 69],
                            [46, 69],
                            [47, 70],
                            [48, 72],
                            [49, 68],
                            [50, 66],
                            [51, 65],
                            [52, 67],
                            [53, 70],
                            [54, 71],
                            [55, 72],
                            [56, 73],
                            [57, 75],
                            [58, 70],
                            [59, 68],
                            [60, 64],
                            [61, 60],
                            [62, 65],
                            [63, 67],
                            [64, 68],
                            [65, 69],
                            [66, 70],
                            [67, 72],
                            [68, 75],
                            [69, 80]
                        ];
                        hAxisTitle = 'Days';
                        hAxisTicks = [0, 10, 20, 30, 40, 50, 60];
                        break;
                    case 'weeks':
                        newData = [
                            [0, 0],
                            [14, 23],
                            [28, 40],
                            [42, 52],
                            [56, 70],
                            [69, 30]
                        ];
                        hAxisTitle = 'Weeks';
                        hAxisTicks = [0, 14, 28, 42, 56, 69];
                        break;
                    case 'months':
                        newData = [
                            [0, 0],
                            [30, 23],
                            [60, 40],
                            [69, 30]
                        ];
                        hAxisTitle = 'Months';
                        hAxisTicks = [0, 30, 60, 69];
                        break;
                }
                data.removeRows(0, data.getNumberOfRows());
                data.addRows(newData);
                options.hAxis.title = hAxisTitle;
                options.hAxis.ticks = hAxisTicks;
                drawChart();
            }

            function drawChart() {
                chart.draw(data, options);
            }

            updateData('days'); // Set the initial data

            // ...
        }
    </script>
    <!-- humidity -->
    <!-- tvoc -->
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Days');

            var options = {
                hAxis: {
                    title: 'Time',
                    logScale: false,
                    format: '0',
                    ticks: []
                },
                vAxis: {
                    title: 'TVOC Level',
                    logScale: false
                },
                colors: ['#4D96FF']
            };

            var chart = new google.visualization.LineChart(document.getElementById('tvoc_chart'));

            var select = document.getElementById('timeInterval_fortvoc');
            select.addEventListener('change', function() {
                var interval = select.value;
                updateData(interval);
            });

            function updateData(interval) {
                var newData = [];
                var hAxisTitle = 'Time';
                var hAxisTicks = [];
                switch (interval) {
                    case 'hours':
                        newData = [
                            [0, 0],
                            [6, 10],
                            [12, 23],
                            [18, 17],
                            [24, 18],
                            [30, 9],
                            [36, 11],
                            [42, 27],
                            [48, 33],
                            [54, 40],
                            [60, 32],
                            [66, 35],
                            [69, 30]
                        ];
                        hAxisTitle = 'Hours';
                        hAxisTicks = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 66, 69];
                        break;
                    case 'days':
                        newData = [
                            [0, 0],
                            [1, 10],
                            [2, 23],
                            [3, 17],
                            [4, 18],
                            [5, 9],
                            [6, 11],
                            [7, 27],
                            [8, 33],
                            [9, 40],
                            [10, 32],
                            [11, 35],
                            [12, 30],
                            [13, 40],
                            [14, 42],
                            [15, 47],
                            [16, 44],
                            [17, 48],
                            [18, 52],
                            [19, 54],
                            [20, 42],
                            [21, 55],
                            [22, 56],
                            [23, 57],
                            [24, 60],
                            [25, 50],
                            [26, 52],
                            [27, 51],
                            [28, 49],
                            [29, 53],
                            [30, 55],
                            [31, 60],
                            [32, 61],
                            [33, 59],
                            [34, 62],
                            [35, 65],
                            [36, 62],
                            [37, 58],
                            [38, 55],
                            [39, 61],
                            [40, 64],
                            [41, 65],
                            [42, 63],
                            [43, 66],
                            [44, 67],
                            [45, 69],
                            [46, 69],
                            [47, 70],
                            [48, 72],
                            [49, 68],
                            [50, 66],
                            [51, 65],
                            [52, 67],
                            [53, 70],
                            [54, 71],
                            [55, 72],
                            [56, 73],
                            [57, 75],
                            [58, 70],
                            [59, 68],
                            [60, 64],
                            [61, 60],
                            [62, 65],
                            [63, 67],
                            [64, 68],
                            [65, 69],
                            [66, 70],
                            [67, 72],
                            [68, 75],
                            [69, 80]
                        ];
                        hAxisTitle = 'Days';
                        hAxisTicks = [0, 10, 20, 30, 40, 50, 60];
                        break;
                    case 'weeks':
                        newData = [
                            [0, 0],
                            [14, 23],
                            [28, 40],
                            [42, 52],
                            [56, 70],
                            [69, 30]
                        ];
                        hAxisTitle = 'Weeks';
                        hAxisTicks = [0, 14, 28, 42, 56, 69];
                        break;
                    case 'months':
                        newData = [
                            [0, 0],
                            [30, 23],
                            [60, 40],
                            [69, 30]
                        ];
                        hAxisTitle = 'Months';
                        hAxisTicks = [0, 30, 60, 69];
                        break;
                }
                data.removeRows(0, data.getNumberOfRows());
                data.addRows(newData);
                options.hAxis.title = hAxisTitle;
                options.hAxis.ticks = hAxisTicks;
                drawChart();
            }

            function drawChart() {
                chart.draw(data, options);
            }

            updateData('days'); // Set the initial data

            // ...
        }
    </script>
    <!-- tvoc -->
    <!-- co2 -->
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Days');

            var options = {
                hAxis: {
                    title: 'Time',
                    logScale: false,
                    format: '0',
                    ticks: []
                },
                vAxis: {
                    title: 'CO2 Level',
                    logScale: false
                },
                colors: ['#00FFAB']
            };

            var chart = new google.visualization.LineChart(document.getElementById('co2_chart'));

            var select = document.getElementById('timeInterval_forco2');
            select.addEventListener('change', function() {
                var interval = select.value;
                updateData(interval);
            });

            function updateData(interval) {
                var newData = [];
                var hAxisTitle = 'Time';
                var hAxisTicks = [];
                switch (interval) {
                    case 'hours':
                        newData = [
                            [0, 0],
                            [6, 10],
                            [12, 23],
                            [18, 17],
                            [24, 18],
                            [30, 9],
                            [36, 11],
                            [42, 27],
                            [48, 33],
                            [54, 40],
                            [60, 32],
                            [66, 35],
                            [69, 30]
                        ];
                        hAxisTitle = 'Hours';
                        hAxisTicks = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 66, 69];
                        break;
                    case 'days':
                        newData = [
                            [0, 0],
                            [1, 10],
                            [2, 23],
                            [3, 17],
                            [4, 18],
                            [5, 9],
                            [6, 11],
                            [7, 27],
                            [8, 33],
                            [9, 40],
                            [10, 32],
                            [11, 35],
                            [12, 30],
                            [13, 40],
                            [14, 42],
                            [15, 47],
                            [16, 44],
                            [17, 48],
                            [18, 52],
                            [19, 54],
                            [20, 42],
                            [21, 55],
                            [22, 56],
                            [23, 57],
                            [24, 60],
                            [25, 50],
                            [26, 52],
                            [27, 51],
                            [28, 49],
                            [29, 53],
                            [30, 55],
                            [31, 60],
                            [32, 61],
                            [33, 59],
                            [34, 62],
                            [35, 65],
                            [36, 62],
                            [37, 58],
                            [38, 55],
                            [39, 61],
                            [40, 64],
                            [41, 65],
                            [42, 63],
                            [43, 66],
                            [44, 67],
                            [45, 69],
                            [46, 69],
                            [47, 70],
                            [48, 72],
                            [49, 68],
                            [50, 66],
                            [51, 65],
                            [52, 67],
                            [53, 70],
                            [54, 71],
                            [55, 72],
                            [56, 73],
                            [57, 75],
                            [58, 70],
                            [59, 68],
                            [60, 64],
                            [61, 60],
                            [62, 65],
                            [63, 67],
                            [64, 68],
                            [65, 69],
                            [66, 70],
                            [67, 72],
                            [68, 75],
                            [69, 80]
                        ];
                        hAxisTitle = 'Days';
                        hAxisTicks = [0, 10, 20, 30, 40, 50, 60];
                        break;
                    case 'weeks':
                        newData = [
                            [0, 0],
                            [14, 23],
                            [28, 40],
                            [42, 52],
                            [56, 70],
                            [69, 30]
                        ];
                        hAxisTitle = 'Weeks';
                        hAxisTicks = [0, 14, 28, 42, 56, 69];
                        break;
                    case 'months':
                        newData = [
                            [0, 0],
                            [30, 23],
                            [60, 40],
                            [69, 30]
                        ];
                        hAxisTitle = 'Months';
                        hAxisTicks = [0, 30, 60, 69];
                        break;
                }
                data.removeRows(0, data.getNumberOfRows());
                data.addRows(newData);
                options.hAxis.title = hAxisTitle;
                options.hAxis.ticks = hAxisTicks;
                drawChart();
            }

            function drawChart() {
                chart.draw(data, options);
            }

            updateData('days'); // Set the initial data

            // ...
        }
    </script>
    <!-- co2 -->
</body>

</html>