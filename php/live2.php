<?php

$dashboard = "";
$home = "";
$settings = "";
$live = "";
$ethernet = "";
$noOfRooms = 12;
$noOfParameters = 5;
$pagesLocations = array("../main/live.php,../main/dashboard.php,../main/history.php,../main/home.php,../main/login.php");


$live =  "style='background-color:#fed215;font-weight:bolder;'";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live</title>
    <link href="../css/live.css" rel="stylesheet" />
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <link href="../images/icon1.png" rel="icon" />
    <!-- for gauges -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="http://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.7/all/gauge.min.js"></script>
    <!-- for gauges -->
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php

                require "myNav.php";

                ?>

                <!-- switch -->
                <div class="switch-holder col-10 offset-1 mt-3 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="switch-label">
                        <i class="fa fa-bluetooth-b"></i><span>Device</span>
                    </div>
                    <div class="switch-toggle">
                        <input type="checkbox" id="bluetooth">
                        <label for="bluetooth"></label>
                    </div>
                </div>
                <!-- switch -->

                <!-- device name -->
                <div class="col-12 text-center mt-4">
                    <h3 id="device" class="badge bg-dark mx-auto fs-4" style="width:fit-content;">DEVICE 0007</h3>
                </div>
                <!-- device name -->

                <div class="content">
                    <div class="card-grid">
                        <div class="card">
                            <p class="card-title">Temperature</p>
                            <canvas class="mx-auto" id="gauge-temperature"></canvas>
                        </div>
                        <div class="card">
                            <p class="card-title">Humidity</p>
                            <canvas class="mx-auto" id="gauge-humidity"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- parameter_card_wrapper -->
                    <div class="col-12">
                        <!-- parameter_cards -->
                        <div class="row g-4 p-3 text-center mt-0 overflow-y-auto pb-5">
                            <div style="display:contents;">
                                <!-- temperature,humidity,pressure -->
                                <?php
                                
                                $temperature_rangeColors = array("#FF0000", "#FF9300", "#FBFF00", "#49FF00");
                                $humdity_rangeColors = array("#52B1D2", "#73CCD8", "#E8E4E2", "#D0AE8B", "#05192C");
                                $pressure_rangeColors = array("#fbe49f", "#e9ecd1", "#d8e1e1", "#b8dedf", "#98fdf5");

                                ?>
                                <!-- temperature,humidity,pressure -->
                                <!-- temperature -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraTemp">TEMPERATURE</span>

                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue">45</span>
                                        <span class="paraUnit" style="font-size:60px;"><sup style="font-size:90px;">.</sup>C</span>
                                    </div>

                                    <div class="text-start ps-3" style="margin-top:100px;">
                                        <!-- <span class="badge rounded-pill text-bg-dark" style="width:100px;">MAX VALUE :</span>
                                    <br />
                                    <span class="badge rounded-pill text-bg-dark" style="width:100px;">MIN VALUE :</span> -->
                                        <span class="text-dark">MAX VALUE:</span>
                                        <br />
                                        <span class="text-dark">MIN VALUE:</span>
                                    </div>
                                </div>
                                <!-- temperature -->
                                <!-- humidity -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraHum">HUMIDITY</span>

                                    <div id="chartdiv"></div>
                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue">85</span>
                                        <span class="paraUnit">%RH</span>
                                    </div>
                                    <h6 class="text-danger fw-bolder">Tolerance :&plusmn;(y-80)/5</h6>

                                    <div class="text-start ps-3" style="margin-top:80px;">
                                        <!-- <span class="badge rounded-pill text-bg-dark" style="width:100px;">MAX VALUE :</span>
                                    <br />
                                    <span class="badge rounded-pill text-bg-dark" style="width:100px;">MIN VALUE :</span> -->
                                        <span class="text-dark">MAX VALUE:</span>
                                        <br />
                                        <span class="text-dark">MIN VALUE:</span>
                                    </div>
                                </div>
                                <!-- humidity -->
                                <!-- pressure -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">PRESSURE</span>
                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue" style="font-size:60px;">1000.7</span>
                                        <span class="paraUnit">hgcm</span>
                                    </div>
                                    <div class="text-start ps-3" style="margin-top:130px;">
                                        <!-- <span class="badge rounded-pill text-bg-dark" style="width:100px;">MAX VALUE :</span>
                                    <br />
                                    <span class="badge rounded-pill text-bg-dark" style="width:100px;">MIN VALUE :</span> -->
                                        <span class="text-dark">MAX VALUE:</span>
                                        <br />
                                        <span class="text-dark">MIN VALUE:</span>
                                    </div>
                                </div>
                                <!-- pressure -->
                                <!-- tvoc level -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">TVOC Level</span>

                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue">1.5</span>
                                        <span class="paraUnit">ppm</span>
                                    </div>
                                    <div class="text-start ps-3" style="margin-top:100px;">
                                        <!-- <span class="badge rounded-pill text-bg-dark" style="width:100px;">MAX VALUE :</span>
                                    <br />
                                    <span class="badge rounded-pill text-bg-dark" style="width:100px;">MIN VALUE :</span> -->
                                        <span class="text-dark">MAX VALUE:</span>
                                        <br />
                                        <span class="text-dark">MIN VALUE:</span>
                                    </div>
                                </div>
                                <!-- tvoc level -->
                                <!-- co2 level -->
                                <div class="paraCard mt-5 text-center" id="card0value" style="padding:10px;">
                                    <span class="paraName paraPres">CO2 Level</span>

                                    <div style="border-radius:5px;color:black;margin-top:100px;">
                                        <span class="paraValue">450</span>
                                        <span class="paraUnit">ppm</span>
                                    </div>
                                    <div class="text-start ps-3" style="margin-top:100px;">
                                        <!-- <span class="badge rounded-pill text-bg-dark" style="width:100px;">MAX VALUE :</span>
                                    <br />
                                    <span class="badge rounded-pill text-bg-dark" style="width:100px;">MIN VALUE :</span> -->
                                        <span class="text-dark">MAX VALUE:</span>
                                        <br />
                                        <span class="text-dark">MIN VALUE:</span>
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
    <script src="../js/script.js"></script>
    <script src="../js/gauges.js"></script>
</body>

</html>