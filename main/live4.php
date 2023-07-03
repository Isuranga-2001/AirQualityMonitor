<?php


$history = "";
$dashboard = "";
$home = "";
$settings = "";
$live = "";
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
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php

                require "myNav.php";

                ?>
                <div class="row">
                    <div class="col-12 mt-5 d-block d-md-inline-flex">
                        <div class="input-group mx-auto">
                            <button class="btn btn-dark" type="button" id="button-addon1">ENTER DEVICE NUMBER :</button>
                            <input type="number" style="width:200px;" class="form-control" min=0 placeholder="000X" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                        <!-- <?php
                                $rooms = array();
                                for ($j = 0; $j < $noOfRooms; $j++) {
                                    $room = new stdClass();
                                    $room->room_name = "room" . ($j + 1);
                                    $room->room_id = "000" . ($j + 1);
                                    $rooms[$j] = $room;
                                }
                                for ($i = 0; $i < $noOfRooms; $i++) {
                                    if ($rooms[$i]->room_id == "0006") {
                                ?>
                                            <button class="liveSelected" style="width:200px;height:50px;"><?php echo "ROOM-[" . $rooms[$i]->room_id . "]"; ?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button class="liveBtn" style="width:200px;height:50px;"><?php echo "ROOM-[" . $rooms[$i]->room_id . "]"; ?></button>
                                    <?php
                                    }
                                }
                                    ?> -->
                        <select class="form-select mx-auto" aria-label="Default select example">
                            <?php
                            for ($i = 0; $i < $noOfRooms; $i++) {
                                if ($rooms[$i]->room_id == "006") {
                            ?>
                                    <option selected><?php echo "DEVICE-[" . $rooms[$i]->room_id . "]" ?></option>
                                <?php
                                } else {
                                ?>
                                    <option><?php echo "DEVICE-[" . $rooms[$i]->room_id . "]" ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

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

                    <!-- room_search -->
                    <div class="col-12 offset-0 col-md-8 offset-md-2 col-lg-4 offset-lg-4">
                        <div class="mt-5 p-3"></div>
                    </div>
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
                                    <br /><br /><br /><br />
                                    <div style="background-color:<?php echo $temperature_rangeColors[0]; ?>;border-radius:5px;color:black;">
                                        <span class="paraValue">45</span>
                                        <span class="paraUnit">degCelcius</span>
                                    </div>
                                    <br /><br /><br /><br />
                                    <div class="text-start ps-3">
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
                                    <br /><br /><br /><br />
                                    <div style="background-color:<?php echo $humdity_rangeColors[0]; ?>;border-radius:5px;color:black;">
                                        <span class="paraValue">50</span>
                                        <span class="paraUnit">%RH</span>
                                    </div>
                                    <br /><br /><br /><br />
                                    <div class="text-start ps-3">
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
                                    <br /><br /><br /><br />
                                    <div style="background-color:<?php echo $pressure_rangeColors[0]; ?>;border-radius:5px;color:black;">
                                        <span class="paraValue">1000</span>
                                        <span class="paraUnit">hPa</span>
                                    </div>
                                    <br /><br /><br /><br />
                                    <div class="text-start ps-3">
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
                                    <span class="paraName">TVOC Level</span>
                                    <br /><br /><br /><br />
                                    <span class="paraValue">1.5</span>
                                    <span class="paraUnit">ppm</span>
                                    <br /><br /><br /><br />
                                    <div class="text-start ps-3">
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
                                    <span class="paraName">Co2 Level</span>
                                    <br /><br /><br /><br />
                                    <span class="paraValue">300</span>
                                    <span class="paraUnit">ppm</span>
                                    <br /><br /><br /><br />
                                    <div class="text-start ps-3">
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
</body>

</html>