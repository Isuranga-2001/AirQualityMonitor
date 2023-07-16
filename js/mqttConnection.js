// Create a client instance with the broker host name and port
var client  = mqtt.connect('wss://6576f9e38ece4cddb9d7c92576674be1.s2.eu.hivemq.cloud:8884/mqtt', {
    username: localStorage.getItem("username"),
    password: localStorage.getItem("password")
});

// Handle the connection event
client.on('connect', function () {
  // Subscribe to a topic
  client.subscribe('temp');
  client.subscribe('co2');
  client.subscribe('pressure');
  client.subscribe('humidity');
  client.subscribe('tvoc');
})

// Handle the message event
client.on('message', function (topic, message) {
  //console.log(message.toString());
  try {
    if (topic == "temp"){
      UpdateTemperature(message);
    }
    else if (topic == "humidity"){
      UpdateHumidity(message);
      try {
        var tolerance = ((Number(message) - 80) * 3 / 40 + 2).toFixed(2);
        if (tolerance <= 2){
          document.getElementById("Humidity_Tolerance").innerHTML = "";
        }
        else{
          document.getElementById("Humidity_Tolerance").innerHTML = "Tolerance : &plusmn;" + String(tolerance);
        } 
      } catch (error) {
        console.log(error);
      }
    }
    else{
      document.getElementById(topic).innerHTML = message.toString();
    } 
  } catch (error) {
    console.log("Mqtt : " + error);
  }
})

function EnableLiveServer(checkboxElem){
  if (checkboxElem.checked) {
    client.publish('enable', '1');
  } 
  else {
    client.publish('enable', '0');
  }
}

function EnableConnectedDevice(checkboxElem){
  if (checkboxElem.checked) {
    client.publish('channel1', '1');
  } 
  else {
    client.publish('channel1', '0');
  }
}