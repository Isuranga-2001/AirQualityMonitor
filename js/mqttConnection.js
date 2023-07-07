// Create a client instance with the broker host name and port
var client  = mqtt.connect('wss://6576f9e38ece4cddb9d7c92576674be1.s2.eu.hivemq.cloud:8884/mqtt', {
    username: 'isuranga2001',
    password: '%C#3308291@5570I'
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
  if (topic == "temp"){
    UpdateTemperature(message)
  }
  else if (topic == "humidity"){
    UpdateHumidity(message)
  }
  else{
    document.getElementById(topic).innerHTML = message.toString();
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