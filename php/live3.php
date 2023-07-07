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
                                <div id="root"></div>
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