<?php

$dashboard = "";
$home = "";
$settings = "";
$live = "";
$ethernet = "";
$noOfRooms = 12;
$noOfParameters = 5;
$pagesLocations = array("../php/live.php,../php/dashboard.php,../php/history.php,../php/home.php,../php/login.php");


$dashboard =  "style='background-color:#fed215;font-weight:bolder;'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../css/history2.css" rel="stylesheet" />
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="../images/icon2.png" rel="icon" />
    <!-- for gauges -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="http://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.7/all/gauge.min.js"></script>
    <!-- for gauges -->
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script src="../js/mqttConnection.js" type="text/JavaScript"><script>
    <script src="../js/script.js" type="text/JavaScript"></script>
    <script type="module">
        import {initializeApp} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
        import {getAnalytics} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
        import {getDatabase,ref,child,get} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-database.js";

        console.log('running');

        const firebaseConfig = {
            apiKey: "AIzaSyCZV35Sd2Qo14fz3XORPncs7TudDTVRFLk",
            authDophp: "airqualitymonitoringsyst-87ae7.firebaseapp.com",
            databaseURL: "https://airqualitymonitoringsyst-87ae7-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "airqualitymonitoringsyst-87ae7",
            storageBucket: "airqualitymonitoringsyst-87ae7.appspot.com",
            messagingSenderId: "451013569860",
            appId: "1:451013569860:web:bf8e9bc4946c3b13f3bb11",
            measurementId: "G-NBW598T1DB"
        };

        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);

        const dbRef = ref(getDatabase());

        var interval = "oneH";
        var para = "Temp";

        var paraName = "Temp";
        var paraValue = "31";

        var paraMin = 0;
        var paraMax = 100;

        var chart;

        window.addEventListener('DOMContentLoaded', (e) => {
            const paraArray = ["Temp", "Humidity", "Pressure", "CO2", "TVOC", "Time"];

            for (let index = 0; index < paraArray.length; index++) {
                get(child(dbRef, "/" + localStorage.getItem("username") + "/Device/" + localStorage.getItem("deviceID") + "/Last/" + paraArray[index])).then((snapshot1) => {
                    if (snapshot1.exists()) {
                        switch (paraArray[index]){
                            case "Temp":{
                                UpdateTempnew(snapshot1.val());
                                break;
                            }
                            case "Humidity":{
                                UpdateHumnew(snapshot1.val());
                                break;
                            }
                            case "Pressure":{
                                document.getElementById("pressureD").innerHTML = (Number(snapshot1.val()) / 100).toFixed(2).toString();
                                break;
                            }
                            case "CO2":{
                                UpdateCO2Dash(snapshot1.val().toString());
                                break;
                            }
                            case "TVOC":{
                                document.getElementById("tvocD").innerHTML = snapshot1.val().toString();

                                break;
                            }
                            case "Time":{
                                document.getElementById("lasttime").innerHTML = "Indoor Air Quality Status of " + localStorage.getItem("devicename") + " at : " + snapshot1.val().toString();
                            }
                        }
                    }
                }).catch((error) => {
                    alert(error);
                });
            }
        });

        UpdateData();
        //document.getElementById("pressureD").innerHtml = "Hello";
        
        var selectedParameter = document.getElementById("parameter");
        selectedParameter.addEventListener('change', function() {
            para = selectedParameter.value;

            chart.destroy();

            switch (para) {
                case "Temp": {
                    paraMin = 0;
                    paraMax = 125;
                    document.getElementById("topic").innerHTML = "Temperature";
                    break;
                }
                case "Humidity": {
                    paraMin = 0;
                    paraMax = 100;
                    document.getElementById("topic").innerHTML = "Relative Humidity";
                    break;
                }
                case "Pressure": {
                    paraMin = 30000;
                    paraMax = 110000;
                    document.getElementById("topic").innerHTML = "Biometric Air Pressure";
                    break;
                }
                case "CO2": {
                    paraMin = 400;
                    paraMax = 60000;
                    document.getElementById("topic").innerHTML = "CO2";
                    break;
                }
                case "TVOC": {
                    paraMin = 0;
                    paraMax = 60000;
                    document.getElementById("topic").innerHTML = "Total Volatile Organic Compounds (TVOC)";
                    break;
                }
            }

            UpdateData();
        });

        function UpdateData() {
            var xValues = [];
            var yValues = [];

            get(child(dbRef, "/" + localStorage.getItem("username") + "/Device/" + localStorage.getItem("deviceID") + "/Reading/")).then((snapshot) => {
                if (snapshot.exists()) {

                    var maximumValue = 0;

                    snapshot.forEach(function(value) {
                        var childObject = value.val();

                        Object.keys(childObject).forEach(e => {
                            paraName = e.toString();
                            if (paraName == para) {
                                paraValue = childObject[e];

                                switch (para) {
                                    case "Temp": {
                                        if (Number(paraValue) > -50) {
                                            xValues.push(value.key);
                                            yValues.push(paraValue);
                                        }
                                        break;
                                    }
                                    case "Humidity": {
                                        if (Number(paraValue) > 0) {
                                            xValues.push(value.key);
                                            yValues.push(paraValue);
                                        }
                                        break;
                                    }
                                    case "Pressure": {
                                        if (Number(paraValue) > 30000) {
                                            xValues.push(value.key);
                                            yValues.push(paraValue);
                                        }
                                        break;
                                    }
                                    case "CO2": {
                                        if (Number(paraValue) > 400) {
                                            xValues.push(value.key);
                                            yValues.push(paraValue);

                                            if (maximumValue < paraValue) {
                                                maximumValue = paraValue;
                                            }
                                        }
                                        break;
                                    }
                                    case "TVOC": {
                                        if (Number(paraValue) >= 0) {
                                            xValues.push(value.key);
                                            yValues.push(paraValue);

                                            if (maximumValue < paraValue) {
                                                maximumValue = paraValue;
                                            }
                                        }
                                        break;
                                    }
                                }

                            }
                        });
                    });
                } else {
                    console.log("Invalid");
                }

                if (para == "TVOC" || para == "CO2") {
                    paraMax = maximumValue;
                }
                DrawChart(xValues, yValues);

            }).catch((error) => {
                console.log(error);
            });
        }

        function DrawChart(xValues, yValues) {
            var container = document.getElementById('chartContainer');
            container.style.height = '500px';

            var backgroundColor;
            var borderColor;

            switch (para) {
                case "Temp":
                    backgroundColor = "rgba(255,0,0,1.0)";
                    borderColor = "rgba(255,0,0,0.8)";
                    break;
                case "Humidity":
                    backgroundColor = "rgba(30,144,255,1.0)";
                    borderColor = "rgba(30,144,255,0.8)";
                    break;
                case "Pressure":
                    backgroundColor = "rgba(205,133,63,1.0)";
                    borderColor = "rgba(205,133,63,0.8)";
                    break;
                case "CO2":
                    backgroundColor = "rgba(34,139,34,1.0)";
                    borderColor = "rgba(34,139,34,0.8)";
                    break;
                case "TVOC":
                    backgroundColor = "rgba(255,140,0,1.0)";
                    borderColor = "rgba(255,140,0,0.8)";
                    break;
            }


            chart = new Chart("paraChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        data: yValues
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: paraMin,
                                max: paraMax
                            }
                        }]
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    height: 500 // Set the desired height here
                }
            });


        }
    </script>
</head>

<body onload="pageLoad();">
    <div class="container-fluid">
        <div class="row">
            <?php

            require "myNav.php";

            ?>
            <div class="col-12">
                <form>
                    <div class="row">
                        <!-- switch -->
                        <div class="switch-holder mt-4 mx-auto col-10 offset-1 col-md-4 offset-md-4">
                            <div class="switch-label">
                                <i class="fa fa-bluetooth-b"></i><span>Connected Device</span>
                            </div>
                            <div class="switch-toggle">
                                <input type="checkbox" id="bluetooth" onchange="EnableConnectedDevice(this)">
                                <label for="bluetooth"></label>
                            </div>
                        </div>
                        <!-- switch -->
                    </div>
                    <div class="text-center p-3">
                        <h3 id="device" class="badge bg-dark mx-auto fs-4" style="width:fit-content;">DEVICE 0000</h3>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-4 d-inline-flex text-center">
                            <!-- parameter -->
                            <select name="parameter" id="parameter" class="form-select mx-auto my-3" style="width:200px;margin-left:20px;">
                                <option value="Temp">Temperature</option>
                                <option value="Humidity">Relative Humidity</option>
                                <option value="Pressure">Biometric Air Pressure</option>
                                <option value="CO2">CO2</option>
                                <option value="TVOC">Total Volatile Organic Compounds (TVOC)</option>
                            </select>
                            <!-- parameter -->
                            <!-- duration -->
                            <select name="duration" id="timeInterval" class="form-select mx-auto my-3" style="width:200px;">
                                <option value="oneH">Last One Hour</option>
                                <option value="24H">Last 24 Hours</option>
                                <option value="oneW">Last One Week</option>
                                <option value="oneW">Last month</option>
                                <option value="oneW">Last 3 months</option>
                                <option value="oneW">Last year</option>
                                <option value="all">All</option>
                            </select>
                            <!-- duration -->
                        </div>
                        <div class="col-12 col-xl-4 text-center">
                            <span id="topic" style="font-size:35px;font-weight:bolder;">Temperature</span>
                            
                        </div>
                    </div>
                    <div id="chartContainer">
                        <canvas id="paraChart" style="width:100%;max-width: 1500px;margin-left:auto;margin-right:auto;"></canvas>
                    </div>
                    <hr />
                    <h3 id="lasttime" style="margin-top:50px;margin-bottom:25px;">Last Updated : </h3>
                    
                    <div class="row">
                        <!-- parameter_card_wrapper -->
                        <div class="col-12">
                            <!-- parameter_cards -->
                            <div class="row g-4 p-3 text-center overflow-y-auto pb-5">
                                <div style="display:contents;">
                                    <!-- temperature -->
                                    <div class="paraCard mt-4 text-center" id="card0value" style="padding:10px;">
                                        <span class="paraName paraPres">TEMPERATURE</span>
                                        <canvas class="mx-auto mt-4" id="gauge-temp"></canvas>
                                    </div>
                                    <!-- temperature -->
                                    <!-- humidity -->
                                    <div class="paraCard mt-4 text-center" id="card0value" style="padding:10px;">
                                        <span class="paraName paraPres">HUMIDIITY</span>
                                        <canvas class="mx-auto mt-4" id="gauge-hum"></canvas>
                                        <h6 class="text-danger fw-bolder" id="tolerance">Tolerance :&plusmn;(y-80)/5</h6>
                                    </div>
                                    <!-- humidity -->
                                    <!-- pressure -->
                                    <div class="paraCard mt-4 text-center" id="card0value" style="padding:10px;">
                                        <span class="paraName paraPres">PRESSURE</span>
                                        <div style="border-radius:5px;color:black;margin-top:150px;">
                                            <span class="paraValue" style="font-size:60px;" id="pressureD">0.0</span>
                                            <span class="paraUnit">hPa</span>
                                        </div>
                                    </div>
                                    <!-- pressure -->
                                    <!-- co2 level -->
                                    <div class="paraCard mt-4 text-center" id="card0value" style="padding:10px;">
                                        <span class="paraName paraPres">CO2 Level</span>
                                        <div style="border-radius:5px;color:black;margin-top:100px;">
                                            <span class="paraValue" id="co2D">0</span>
                                            <span class="paraUnit">ppm</span>
                                        </div>
                                        <div class="d-inline">
                                            <button class="btn btn-primary mt-5" id="co2_low"></button>
                                            <button class="btn btn-success mt-5" id="co2_normal"></button>
                                            <button class="btn btn-warning mt-5" id="co2_high"></button>
                                            <button class="btn btn-danger mt-5" id="co2_veryHight"></button>
                                            <h3 class="mt-4" id="co2_level">LOW</h3>
                                        </div>
                                    </div>
                                    <!-- co2 level -->
                                    <!-- tvoc level -->
                                    
                                    <div class="paraCard mt-4 text-center" id="card0value" style="padding:10px;">
                                        <span class="paraName paraPres">TVOC Level</span>
                                        <div style="border-radius:5px;color:black;margin-top:100px;">
                                            <span class="paraValue" id="tvocD">0</span>
                                            <span class="paraUnit">ppb</span>
                                        </div>
                                        <div class="d-inline">
                                            <button class="btn btn-primary mt-5" id="tvoc_low"></button>
                                            <button class="btn btn-success mt-5" id="tvoc_normal"></button>
                                            <button class="btn btn-warning mt-5" id="tvoc_high"></button>
                                            <button class="btn btn-danger mt-5" id="tvoc_veryHight"></button>
                                            <h3 class="mt-4" id="tvoc_level">LOW</h3>
                                        </div>
                                    </div>
                                    <!-- tvoc level -->
                                    <!--  -->
                                </div>
                            </div>
                            <!-- parameter_cards -->
                        </div>
                        <!-- parameter_card_wrapper -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../js/gauges2.js"></script>
</body>

</html>