<?php

$dashboard = "";
$home = "";
$settings = "";
$live = "";
$ethernet = "";
$noOfRooms = 12;
$noOfParameters = 5;
$pagesLocations = array("../php/live.php,../php/dashboard.php,../php/history.php,../php/home.php,../php/login.php");


$live =  "style='background-color:#fed215;font-weight:bolder;'";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="600">
    <title>Live</title>
    <link href="../css/live.css" rel="stylesheet" />
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <link href="../images/icon2.png" rel="icon" />
    <!-- for gauges -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="http://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.7/all/gauge.min.js"></script>
    <!-- for gauges -->
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script src="../js/mqttConnection.js" type="text/JavaScript"><script>
    <script src="../js/script.js" type="text/JavaScript"></script>
</head>

<body onload="pageLoad();">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php

                require "myNav.php";

                ?>

                <!-- switch -->
                <div class="switch-holder col-10 offset-1 mt-3 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="switch-label">
                        <i class="fa fa-bluetooth-b"></i><span>Live Server</span>
                    </div>
                    <div class="switch-toggle">
                        <input type="checkbox" id="bluetooth" onchange="EnableLiveServer(this)">
                        <label for="bluetooth"></label>
                    </div>
                </div>
                <!-- switch -->

                <!-- device name -->
                <div class="col-12 text-center mt-4">
                    <h3 id="device" class="badge bg-dark mx-auto fs-4" style="width:fit-content;">DEVICE 0007</h3>
                </div>
                <!-- device name -->
                <div class="row" style="margin-top:-30px;">
                    <!-- parameter_card_wrapper -->
                    <div class="col-12">
                        <!-- parameter_cards -->
                        <div class="row g-4 p-3 text-center mt-0 overflow-y-auto pb-5">
                            <div style="display:contents;">
                                <!-- temperature -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <p class="card-title">Temperature</p>
                                    <canvas class="mx-auto" id="gauge-temperature"></canvas>
                                </div>
                                <!-- temperature -->
                                <!-- humidity -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <p class="card-title">Humidity</p>
                                    <canvas class="mx-auto" id="gauge-humidity"></canvas>
                                    <h6 class="text-danger fw-bolder" id="Humidity_Tolerance">Tolerance :&plusmn;(y-80)/5</h6>
                                </div>
                                <!-- humidity -->
                                <!-- pressure -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">PRESSURE</span>
                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue" style="font-size:60px;" id="pressure">1000.7</span>
                                        <span class="paraUnit">Pa</span>
                                    </div>
                                </div>
                                <!-- pressure -->
                                <!-- tvoc level -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">TVOC Level</span>

                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue" id="tvoc">1.5</span>
                                        <span class="paraUnit">ppb</span>
                                    </div>
                                </div>
                                <!-- tvoc level -->
                                <!-- co2 level -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">CO2 Level</span>

                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue" id="co2">450</span>
                                        <span class="paraUnit">ppm</span>
                                    </div>
                                </div>
                                <!-- co2 level -->
                                <!--  -->
                            </div>
                        </div>
                        <!-- parameter_cards -->
                    </div>
                    <!-- parameter_card_wrapper -->
                </div>
            </div>
        </div>
    </div>
    <script src="../js/gauges.js"></script>
</body>

</html>