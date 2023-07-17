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
        <script type="module" src="../js/DashboardScripts.js"></script>
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

                        <h3 id="lasttime" style="margin-top:25px;margin-bottom:25px;">Last Updated : </h3>

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

                        <hr />

                        <div class="row" style="margin-top:50px;">
                            <div class="col-12 col-xl-6 text-center">
                                <div class="row">
                                    <div class="offset-0 col-12 col-xl-5">
                                        <!-- parameter -->
                                        <select name="parameter" id="parameter" class="form-select my-3 mt-4 mx-auto" style="width:200px;">
                                            <option value="Temp">Temperature</option>
                                            <option value="Humidity">Relative Humidity</option>
                                            <option value="Pressure">Biometric Air Pressure</option>
                                            <option value="CO2">CO2</option>
                                            <option value="TVOC">Total Volatile Organic Compounds (TVOC)</option>
                                        </select>
                                        <!-- parameter -->
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <!-- duration -->
                                        <div class="d-inline-flex p-4">
                                            <label for="from" class="mt-1">From</label>
                                            <input type="date" class="form-control dateInput ms-3" id="startdate"/>
                                            <label class="ms-3 mt-1" for="to">To</label>
                                            <input type="date" class="form-control dateInput  ms-3" id="enddate"/>
                                        </div>
                                        <!-- duration -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-6 text-center mt-3">
                                <span id="topic" style="font-size:35px;font-weight:bolder;">Temperature</span>
                            </div>
                        </div>
                        <div id="chartContainer" style="margin-bottom:100px;">
                            <canvas id="paraChart" style="width:100%;max-width:1500px;margin-left:auto;margin-right:auto;"></canvas>
                        </div>

                        <hr/>
                    </form>
                </div>
            </div>
        </div>
        
        <script src="../js/DashboardGauges.js"></script>
    </body>

</html>