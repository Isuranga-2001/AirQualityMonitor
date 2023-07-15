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
  }
  
  function UpdateTempnew(temp){
    gaugeTempNew.value = temp;
  }