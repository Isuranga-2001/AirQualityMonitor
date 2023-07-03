<!DOCTYPE html>
<html>
<head>
    <title>Line Chart with Log Scales</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });
        google.charts.setOnLoadCallback(drawLogScales);

        function drawLogScales() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Time');
            data.addColumn('number', 'Dogs');
            data.addColumn('number', 'Cats');

            data.addRows([
                [new Date(2023, 0, 1), 0, 0],
                [new Date(2023, 0, 8), 10, 5],
                [new Date(2023, 0, 15), 23, 15],
                [new Date(2023, 0, 22), 17, 9],
                [new Date(2023, 0, 29), 18, 10],
                // Add more data points here
            ]);

            var options = {
                hAxis: {
                    title: 'Time',
                    format: 'MMM dd, yyyy',
                    logScale: true
                },
                vAxis: {
                    title: 'Popularity',
                    logScale: false
                },
                colors: ['#a52714', '#097138']
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 100%; height: 400px;"></div>
</body>
</html>
