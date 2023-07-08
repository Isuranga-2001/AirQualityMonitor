// locate pages
function gotoDashboard() {
  window.location.assign("../php/dashboard.php");
}

function loadDashboard(card){
  var DID = card.id;
  localStorage.setItem("devicename", document.getElementById("DName_" + DID).innerHTML);
  localStorage.setItem("deviceID", DID);
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

function pageLoad(){
  document.getElementById("device").innerHTML = localStorage.getItem("devicename") + " - " + localStorage.getItem("deviceID");
}