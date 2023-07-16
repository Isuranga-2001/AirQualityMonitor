// dashboard gauges
// new humidty gauge
var gaugeHumnew = new RadialGauge({
    renderTo: 'gauge-hum',
    width: 300,
    height: 300,
    units: "Humidity (%)",
    minValue: 0,
    maxValue: 100,
    colorValueBoxRect: "#9704aa",
    colorValueBoxRectEnd: "#9704aa",
    colorValueBoxBackground: "#f1fbfc",
    valueInt: 2,
    majorTicks: [
        "0",
        "20",
        "40",
        "60",
        "80",
        "100"
    ],
    minorTicks: 4,
    strokeTicks: true,
    highlights: [
        {
            "from": 80,
            "to": 100,
            "color": "rgba(255, 183, 1, 0.75)"
        }
    ],
    colorPlate: "#fff",
    borderShadowWidth: 0,
    borders: false,
    needleType: "line",
    colorNeedle: "#9704aa",
    colorNeedleEnd: "#9704aa",
    needleWidth: 2,
    needleCircleSize: 3,
    colorNeedleCircleOuter: "#9704aa",
    needleCircleOuter: true,
    needleCircleInner: false,
    animationDuration: 1500,
    animationRule: "linear"
  }).draw();
  // new humidty gauge
  
  //tvoc gauge
  var gaugeTempNew = new RadialGauge({
    renderTo: 'gauge-temp',
    width: 300,
    height: 300,
    units: "Temperature (degCelcius)",
    minValue: 0,
    maxValue: 100,
    colorValueBoxRect: "#9704aa",
    colorValueBoxRectEnd: "#9704aa",
    colorValueBoxBackground: "#f1fbfc",
    valueInt: 2,
    majorTicks: [
        "0",
        "20",
        "40",
        "60",
        "80",
        "100"
  
    ],
    minorTicks: 4,
    strokeTicks: true,
    highlights: [
        {
            "from": 80,
            "to": 100,
            "color": "rgba(255, 183, 1, 0.75)"
        }
    ],
    colorPlate: "#fff",
    borderShadowWidth: 0,
    borders: false,
    needleType: "line",
    colorNeedle: "#9704aa",
    colorNeedleEnd: "#9704aa",
    needleWidth: 2,
    needleCircleSize: 3,
    colorNeedleCircleOuter: "#9704aa",
    needleCircleOuter: true,
    needleCircleInner: false,
    animationDuration: 1500,
    animationRule: "linear"
  }).draw();
  
function UpdateHumnew(hum){
  gaugeHumnew.value = hum;
  var tolerance = ((Number(hum) - 80) * 3 / 40 + 2).toFixed(2);
  if (tolerance <= 2){
    document.getElementById("tolerance").innerHTML = "";
  }
  else{
    document.getElementById("tolerance").innerHTML = "Tolerance : &plusmn;" + String(tolerance);
  }
}
  
function UpdateTempnew(temp){
  gaugeTempNew.value = temp;
}

function UpdateCO2Dash(val){
  document.getElementById("co2D").innerHTML = val;
  var co2_level = Number(val);

  var lowbtn = document.getElementById("co2_low");
  var normalbtn = document.getElementById("co2_normal");
  var warningbtn = document.getElementById("co2_high");
  var highbtn = document.getElementById("co2_veryHight");


  if (co2_level >= 400 && co2_level <= 650){
    document.getElementById("co2_level").innerHTML = "Excellent";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      warningbtn.style.backgroundColor = 
      highbtn.style.backgroundColor = 
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      highbtn.style.borderColor = "#0d6efd";
  }
  else if (co2_level > 650 && co2_level <= 850){
    document.getElementById("co2_level").innerHTML = "Good";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      warningbtn.style.backgroundColor = 
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor = 
      warningbtn.style.borderColor = "#198754";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = "#495057";
  }
  else if (co2_level > 850 && co2_level <= 1050){
    document.getElementById("co2_level").innerHTML = "Fair";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      warningbtn.style.backgroundColor = 
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor = 
      warningbtn.style.borderColor = "#198754";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = "#adb5bd";
  }
  else if (co2_level > 1050 && co2_level <= 1550){
    document.getElementById("co2_level").innerHTML = "Moderate";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor =  
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor =  "#ffc107";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      warningbtn.style.backgroundColor = "#adb5bd";
  }
  else{
    document.getElementById("co2_level").innerHTML = "Bad";

    lowbtn.style.backgroundColor =   
      lowbtn.style.borderColor = "#dc3545";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      warningbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      normalbtn.style.borderColor = "#adb5bd";
  }
}

function UpdateTVOCDash(val){
  document.getElementById("tvocD").innerHTML = val;
  var co2_level = Number(val);

  var lowbtn = document.getElementById("tvoc_low");
  var normalbtn = document.getElementById("tvoc_normal");
  var warningbtn = document.getElementById("tvoc_high");
  var highbtn = document.getElementById("tvoc_veryHight");

  if (co2_level >= 0 && co2_level <= 65){
    document.getElementById("tvoc_level").innerHTML = "Excellent";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      warningbtn.style.backgroundColor = 
      highbtn.style.backgroundColor = 
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      highbtn.style.borderColor = "#0d6efd";
  }
  else if (co2_level > 65 && co2_level <= 220){
    document.getElementById("tvoc_level").innerHTML = "Good";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      warningbtn.style.backgroundColor = 
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor = 
      warningbtn.style.borderColor = "#198754";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = "#adb5bd";
  }
  else if (co2_level > 220 && co2_level <= 660){
    document.getElementById("tvoc_level").innerHTML = "Moderate";

    lowbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor =  
      lowbtn.style.borderColor = 
      normalbtn.style.borderColor =  "#ffc107";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      warningbtn.style.backgroundColor = "#adb5bd";s
  }
  else if (co2_level > 660 && co2_level <= 2200){
    document.getElementById("tvoc_level").innerHTML = "Poor";

    lowbtn.style.backgroundColor =   
      lowbtn.style.borderColor = "#dc3545";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      warningbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      normalbtn.style.borderColor = "#adb5bd";
  }
  else{
    document.getElementById("tvoc_level").innerHTML = "Bad";

    lowbtn.style.backgroundColor =   
      lowbtn.style.borderColor = "#dc3545";

    highbtn.style.backgroundColor = 
      highbtn.style.borderColor = 
      warningbtn.style.borderColor = 
      warningbtn.style.backgroundColor = 
      normalbtn.style.backgroundColor = 
      normalbtn.style.borderColor = "#adb5bd";
  }
}