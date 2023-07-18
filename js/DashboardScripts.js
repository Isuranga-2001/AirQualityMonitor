import {initializeApp} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
import {getAnalytics} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
import {
    getDatabase,
    ref,
    child,
    get
} from "https://www.gstatic.com/firebasejs/9.22.1/firebase-database.js";


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

var para = "Temp";

var paraName = "Temp";
var paraValue = "31";

var paraMin = 0;
var paraMax = 100;

var chart;

var startDate = document.getElementById("startdate");
var endDate = document.getElementById("enddate");

window.addEventListener('DOMContentLoaded', (e) => {
    const paraArray = ["Temp", "Humidity", "Pressure", "CO2", "TVOC", "Time"];

    for (let index = 0; index < paraArray.length; index++) {
        get(child(dbRef, "/" + localStorage.getItem("username") + "/Device/" + localStorage.getItem("deviceID") + "/Last/" + paraArray[index])).then((snapshot1) => {
            if (snapshot1.exists()) {
                switch (paraArray[index]) {
                    case "Temp": {
                        UpdateTempnew(snapshot1.val());
                        break;
                    }
                    case "Humidity": {
                        UpdateHumnew(snapshot1.val());
                        break;
                    }
                    case "Pressure": {
                        document.getElementById("pressureD").innerHTML = (Number(snapshot1.val()) / 100).toFixed(2).toString();
                        break;
                    }
                    case "CO2": {
                        UpdateCO2Dash(snapshot1.val().toString());
                        break;
                    }
                    case "TVOC":{
                        UpdateTVOCDash(snapshot1.val().toString());

                        break;
                    }
                    case "Time": {
                        document.getElementById("lasttime").innerHTML = "Indoor Air Quality Status of " + localStorage.getItem("devicename") + " at : " + snapshot1.val().toString();
                    }
                }
            }
        }).catch((error) => {
            console.log(error);
        });
    }
});

SetupDates();
UpdateData();

var selectedParameter = document.getElementById("parameter");
selectedParameter.addEventListener('change', function() {
    para = selectedParameter.value;

    chart.destroy();

    switch (para) {
        case "Temp": {
            paraMin = 0;
            paraMax = 80;
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
            paraMin = 90000;
            paraMax = 110000;
            document.getElementById("topic").innerHTML = "Biometric Air Pressure";
            break;
        }
        case "CO2": {
            paraMin = 300;
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

startDate.onchange = function(){
    UpdateData();
}

endDate.onchange = function(){
    UpdateData();
}

function UpdateData() {
    //alert("hsd");
    if (!CheckDateInput()){
        return;
    }

    var xValues = [];
    var yValues = [];

    get(child(dbRef, "/" + localStorage.getItem("username") + "/Device/" + localStorage.getItem("deviceID") + "/Readings/")).then((snapshot) => {
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
                                if (Number(paraValue) > -50 && ValidateDate(value.key)) {
                                    xValues.push(value.key);
                                    yValues.push(paraValue);
                                }
                                break;
                            }
                            case "Humidity": {
                                if (Number(paraValue) > 0 && ValidateDate(value.key)) {
                                    xValues.push(value.key);
                                    yValues.push(paraValue);
                                }
                                break;
                            }
                            case "Pressure": {
                                if (Number(paraValue) > 30000 && ValidateDate(value.key)) {
                                    xValues.push(value.key);
                                    yValues.push(paraValue);
                                }
                                break;
                            }
                            case "CO2": {
                                if (Number(paraValue) >= 400 && ValidateDate(value.key)) {
                                    xValues.push(value.key);
                                    yValues.push(paraValue);

                                    if (maximumValue < paraValue) {
                                        maximumValue = paraValue;
                                    }
                                }
                                break;
                            }
                            case "TVOC": {
                                if (Number(paraValue) >= 0 && ValidateDate(value.key)) {
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

function SetupDates(){
    endDate.valueAsDate = new Date();

    var yesterdayDate = new Date();
    yesterdayDate.setDate(yesterdayDate.getDate() - 1);
    startDate.valueAsDate = yesterdayDate;
}

function CheckDateInput(){
    var date1 = new Date(startDate.value);
    var date2 = new Date(endDate.value);
    var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10); 

    if (diffDays < 0){
        //alert("Error Input Dates. Can't Change Graph!");
        startDate.style.borderWidth = endDate.style.borderWidth = "2px";
        startDate.style.borderColor = endDate.style.borderColor = "#dc3545";
        return false;
    }
    else{
        startDate.style.borderWidth = endDate.style.borderWidth = "1px";
        startDate.style.borderColor = endDate.style.borderColor = "#6c757d";
        return true;
    }
}

function ValidateDate(date){
    date = new Date(date.split(' ')[0]);

    var datestart = new Date(startDate.value);
    var dateend = new Date(endDate.value);

    if (date >= datestart && date <= dateend){
        return true;
    }
    else{
        return false;
    }
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