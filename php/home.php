<?php

$dashboard = "";
$home = "";
$settings = "";
$live = "";
$ethernet = "";
$noOfRooms = 12;
$noOfParameters = 5;
$pagesLocations = array("../php/live.php,../php/dashboard.php,../php/history.php,../php/home.php,../php/login.php");

$home = "style='background-color:#fed215;font-weight:bolder;'";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <link href="../css/home.css" rel="stylesheet" />
    <link href="../images/icon1.png" rel="icon" />
    <link rel="stylesheet" href="../loaders/fnon.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
        import { getDatabase, ref, child, get } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-database.js";
            
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

        window.addEventListener('DOMContentLoaded', (e) => { 
            var uname = localStorage.getItem("username");
            document.getElementById("uname").innerHTML = uname;

            let deviceArray = [];
            let count = 0;

            get(child(dbRef, uname + "/Device")).then((snapshot) => {
                if (snapshot.exists()) {
                    snapshot.forEach(function(value) {
                        var deviceID = String(value.key);
                        AddCard(deviceID);
                        document.getElementById("DID_" + deviceID).innerHTML = deviceID;
                        deviceArray.push(count);

                        get(child(dbRef, uname + "/Device/" + deviceID + "/Name")).then((snapshot1) => {
                            if (snapshot1.exists()) {
                                // device name
                                document.getElementById("DName_" + deviceID).innerHTML = String(snapshot1.val());
                            }
                        }).catch((error) => {
                            alert(error);
                        });

                        count++;
                    });
                }
            }).catch((error) => {
                alert(error);
            });

           
        });

        function AddCard(num){
            // <span class="badge text-bg-danger">Inactive</span> for inactive
            document.getElementById("cardHolder").innerHTML += `
            <div class='flip-card mx-auto' style='cursor:pointer;' onclick='loadDashboard(this)' id='` + num + `'>
                <div class='flip-card-inner'>
                    <div class='flip-card-front'>
                    <span class='badge text-bg-success'>Active</span>
                    <h5 style='margin-top:40px;' class='text-center'><span id='DName_` + num + `'>Unknown<span></h5>
                    <h5 style='margin-top:30px;' class='text-center'>DEVICE ID <br><span id='DID_` + num + `'><span></h5>
                    </div>
                </div>
            </div>`;
        }
    </script>
    <script src="../loaders/fnon.min.js"></script>
    <script src="../js/load.js"></script>
</head>

<body style="overflow-y:visible;background-color:white;" id="homepage">
    <!-- The overlay -->
    <div id="myNav" class="overlay">
        <!-- Button to close the overlay navigation -->
        <!-- Overlay content -->
        <div class="overlay-content">
            <!-- <div class="btnGrp" style="margin-top:-70px;">
                <button class="navBtn mx-auto mx-lg-4 currentPg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" />
                    </svg> &nbsp; <span>Home</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                    </svg> &nbsp; <span>History</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-button-fill" viewBox="0 0 16 16">
                        <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h8A1.5 1.5 0 0 0 11 3.5v-2A1.5 1.5 0 0 0 9.5 0h-8zm5.927 2.427A.25.25 0 0 1 7.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0l-.396-.396zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                    </svg> &nbsp; <span>DashBoard</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                    </svg>&nbsp; <span>Live</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
                    </svg>&nbsp; <span>Summary</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                        <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                    </svg> &nbsp; <span>Settings</span>
                </button>
                <button class="navBtn mx-auto mx-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                    </svg>&nbsp; <span>Logout</span>
                </button>
            </div> -->
            <div class="row">
                <!-- profile_details -->
                <div class="col-12 profile text-center p-5 text-light" style="margin-top:-150px;">
                    <img src="../images/icon2.png" style="width:100px;border-radius:100%;" class="shadow avatar" alt="Avatar" style="cursor:pointer;" onclick="closeNav()">
                </div>
                <div class="col-12 btnGrp my-5 mb-lg-5 mt-lg-0" style="margin-top:-100px;">
                    <button class="profileBtn" <?php echo $settings; ?> onclick="gotoSettings()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                        </svg>
                        &nbsp;Settings
                    </button>
                    <br />
                    <button class="profileBtn logout_btn" style="background-color:red;color:white;font-weight:bolder;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                        </svg>
                        &nbsp;Logout
                    </button>
                </div>
                <!-- profile_details -->
            </div>
        </div>
    </div>
    <!-- overlay_navigation -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">

                    <div class="col-12 col-lg-4 col-xl-3 align d-block d-sm-none">
                        <div class="btnGrp text-center" style="margin-top:30px;">
                            <img src="../images/icon2.png" style="width:100px;border-radius:100%;" class="shadow avatar" alt="Avatar" onclick="openNav()" type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="USER 001">
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 col-xl-3 align d-none d-sm-block p-4" style="height:100vh;">
                        <div class="userSection mt-5">
                            <div class="row">
                                <!-- profile_details -->
                                <div class="col-6 col-lg-12 profile text-center p-5">
                                    <img src="../images/icon2.png" style="width:100px;border-radius:100%;" class="shadow avatar" alt="Avatar" style="cursor:pointer;">
                                    <br /><br />
                                    <h4 id="uname">USERNAME</h4>
                                </div>
                                <div class="col-6 col-lg-12 btnGrp my-5 mb-lg-5 mt-lg-0 text-center">
                                    <button class="profileBtn" <?php echo $settings; ?> onclick="gotoSettings()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                        </svg>
                                        &nbsp;Settings
                                    </button>
                                    <button class="profileBtn logout_btn" style="background-color:red;color:white;font-weight:bolder;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                                        </svg>
                                        &nbsp;Logout
                                    </button>
                                    <!-- <button class="navBtn mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                        </svg> &nbsp; <span>Settings</span>
                                    </button>
                                    <button class="navBtn mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                        </svg>&nbsp; <span>Logout</span>
                                    </button> -->
                                </div>
                                <!-- profile_details -->
                            </div>
                        </div>
                    </div>

                    <!-- room details -->
                    <div class="col-12 col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="d-flex flex-row mb-3 flex-wrap">
                                <!-- large devices -->
                                <div class="mx-auto">
                                    <table class="table d-none d-xxl-block mt-5">
                                        <tbody>
                                            <tr style="height:fit-content;">
                                                <td> <span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:red;">.</span>&nbsp;Highest temperature :</span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> <span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:blue;">.</span>&nbsp;Lowest temperature :</span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                            </tr>
                                            <tr style="height:fit-content;">
                                                <td><span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:green;">.</span>&nbsp;Highest humidity :</span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> <span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:orange;">.</span>&nbsp;Lowest humidity : </span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                            </tr>
                                            <tr style="height:fit-content;">
                                                <td> <span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:rgb(50, 130, 184);">.</span>&nbsp;Highest CO2 :</span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><span style="font-weight:bolder;margin:10px;" class="rounded-3 shadow p-2 fs-6"><span style="font-size:40px;color:rgb(52, 248, 176);">.</span>&nbsp;Lowest CO2 : </span></td>
                                                <td><span id="" class="badge bg-dark text-light" style="margin-top:20px;font-size:20px;">DEVICE 0007</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- large devices -->
                                <!-- small devices -->
                                <div class="d-block d-xxl-none mx-auto">
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:red;">.</span>&nbsp;Highest temperature : <span id="" class="badge bg-dark text-light">DEVICE 0007</span></span>
                                    </div>
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:blue;">.</span>&nbsp;Lowest temperature : <span id="" class="badge bg-dark text-light">DEVICE 0008</span></span>
                                    </div>
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:green;">.</span>&nbsp;Highest humidity : <span id="" class="badge bg-dark text-light">DEVICE 0009</span></span>
                                    </div>
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:orange;">.</span>&nbsp;Lowest humidity : <span id="" class="badge bg-dark text-light">DEVICE 0001</span></span>
                                    </div>
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:rgb(50, 130, 184);">.</span>&nbsp;Highest CO2 : <span id="" class="badge bg-dark text-light">DEVICE 0002</span></span>
                                    </div>
                                    <div class="mx-auto">
                                        <span style="font-weight:bolder;" class="rounded-3 shadow p-2 fs-3"><span style="font-size:90px;color:rgb(52, 248, 176);">.</span>&nbsp;Lowest CO2 : <span id="" class="badge bg-dark text-light">DEVICE 0003</span></span>
                                    </div>
                                </div>
                                <!-- small devices -->
                            </div>
                        </div>
                        
                        <!-- user_room_details -->
                        <div class="row row-cols-1 row-cols-md-2 g-4 p-3 text-center mt-0 overflow-y-auto p-4" style="height:90vh;" id="cardHolder">
                            
                        </div>
                        <!-- user_room_details -->
                    </div>
                    <!-- room details -->

                </div>
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>

    <script>
        /* Open when someone clicks on the span element */
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        /* Close when someone clicks on the "x" symbol inside the overlay */
        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>

</body>

</html>