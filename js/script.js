function login() {
  var username = document.getElementById("uname");
  var password = document.getElementById("password");

  var form = new FormData();
  form.append("username", username.value);
  form.append("password", password.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    var text = r.responseText;
    if (r.readyState == 4) {
      alert(text);
    }
  };
  r.open("POST", "login_process.php", true);
  r.send(form);
}

// history
google.charts.load("current", {
  packages: ["corechart", "line"],
});
google.charts.setOnLoadCallback(drawLogScales);

function drawLogScales() {
  var data = new google.visualization.DataTable();
  data.addColumn("number", "X");
  data.addColumn("number", "Days");

  data.addRows([
    [0, 0],
    [1, 10],
    [2, 23],
    [3, 17],
    [4, 18],
    [5, 9],
    [6, 11],
    [7, 27],
    [8, 33],
    [9, 40],
    [10, 32],
    [11, 35],
    [12, 30],
    [13, 40],
    [14, 42],
    [15, 47],
    [16, 44],
    [17, 48],
    [18, 52],
    [19, 54],
    [20, 42],
    [21, 55],
    [22, 56],
    [23, 57],
    [24, 60],
    [25, 50],
    [26, 52],
    [27, 51],
    [28, 49],
    [29, 53],
    [30, 55],
    [31, 60],
    [32, 61],
    [33, 59],
    [34, 62],
    [35, 65],
    [36, 62],
    [37, 58],
    [38, 55],
    [39, 61],
    [40, 64],
    [41, 65],
    [42, 63],
    [43, 66],
    [44, 67],
    [45, 69],
    [46, 69],
    [47, 70],
    [48, 72],
    [49, 68],
    [50, 66],
    [51, 65],
    [52, 67],
    [53, 70],
    [54, 71],
    [55, 72],
    [56, 73],
    [57, 75],
    [58, 70],
    [59, 68],
    [60, 64],
    [61, 60],
    [62, 65],
    [63, 67],
    [64, 68],
    [65, 69],
    [66, 70],
    [67, 72],
    [68, 75],
    [69, 80],
  ]);

  var options = {
    hAxis: {
      title: "Time",
      logScale: true,
    },
    vAxis: {
      title: "Temperature",
      logScale: false,
    },
    colors: ["#a52714"],
  };

  var chart = new google.visualization.LineChart(
    document.getElementById("chart_div")
  );
  chart.draw(data, options);
}
// history

// locate pages
function gotoDashboard() {
  window.location.assign("../php/dashboard.php");
}

function gotoHome() {
  window.location.assign("../php/home.php");
}

function gotoSettings() {
  window.location.assign("../php/settings.php");
}

function gotoLive() {
  window.location.assign("../php/live.php");
}
// locate pages

//