#include <WiFi.h> // Wifi
#include <Wire.h> // I2C
#include <SPI.h> // SPI
#include <FirebaseESP32.h> // Firebase
#include <PubSubClient.h> // MQTT
#include <WiFiClientSecure.h> // MQTT
#include <FS.h> //SD
#include <SD.h> //SD
#include <Adafruit_BMP280.h> // bmp280
#include "SHTSensor.h" // SHTC3
#include "Adafruit_SGP30.h" // SGP30
#include "RTClib.h" // RTC
#include <DallasTemperature.h> // DS18B20 Temperature sensor
#include <ESP32-ENC28J60.h> // Ethernet Module

// Firebase Connection
#define FIREBASE_HOST "https://airqualitymonitoringsyst-87ae7-default-rtdb.asia-southeast1.firebasedatabase.app/"  //Realtime database url 
#define FIREBASE_AUTH "AIzaSyCZV35Sd2Qo14fz3XORPncs7TudDTVRFLk" //API key

// Define digital pins
#define DS18B20_PIN 16
#define RELAY_PIN 17
#define SENSOR_INDICATOR_PIN 32

// indicators
#define SENSOR_CALIBRATION_PIN 33
#define WIFI_CONNECTIVITY_INDICATOR_PIN 26
#define ETHERNET_CONNECTIVITY_INDICATOR_PIN 25

// Ethernet Module
#define SPI_HOST 1
#define SPI_CLOCK_MHZ 8
#define INT_GPIO 27
#define MISO_GPIO 12
#define MOSI_GPIO 13
#define SCLK_GPIO 14
#define CS_GPIO 15
#define ETH_RS_PIN 4

// Wifi Settings 
String WIFI_SSID;
String WIFI_PASSWORD;

static bool eth_connected = false;

// Device ID
String DeviceID = String(ESP.getEfuseMac(), HEX);

// Define FirebaseESP32 data object
FirebaseData firebaseData;

// MQTT Broker settings
String username, mqtt_password, mqtt_server, deviceName;
int mqtt_port;

// define mqtt objects
WiFiClientSecure espClient;
PubSubClient client(espClient);

#define MSG_BUFFER_SIZE (50)
char msg[MSG_BUFFER_SIZE];

static const char *root_ca PROGMEM = R"EOF(
-----BEGIN CERTIFICATE-----
MIIFazCCA1OgAwIBAgIRAIIQz7DSQONZRGPgu2OCiwAwDQYJKoZIhvcNAQELBQAw
TzELMAkGA1UEBhMCVVMxKTAnBgNVBAoTIEludGVybmV0IFNlY3VyaXR5IFJlc2Vh
cmNoIEdyb3VwMRUwEwYDVQQDEwxJU1JHIFJvb3QgWDEwHhcNMTUwNjA0MTEwNDM4
WhcNMzUwNjA0MTEwNDM4WjBPMQswCQYDVQQGEwJVUzEpMCcGA1UEChMgSW50ZXJu
ZXQgU2VjdXJpdHkgUmVzZWFyY2ggR3JvdXAxFTATBgNVBAMTDElTUkcgUm9vdCBY
MTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBAK3oJHP0FDfzm54rVygc
h77ct984kIxuPOZXoHj3dcKi/vVqbvYATyjb3miGbESTtrFj/RQSa78f0uoxmyF+
0TM8ukj13Xnfs7j/EvEhmkvBioZxaUpmZmyPfjxwv60pIgbz5MDmgK7iS4+3mX6U
A5/TR5d8mUgjU+g4rk8Kb4Mu0UlXjIB0ttov0DiNewNwIRt18jA8+o+u3dpjq+sW
T8KOEUt+zwvo/7V3LvSye0rgTBIlDHCNAymg4VMk7BPZ7hm/ELNKjD+Jo2FR3qyH
B5T0Y3HsLuJvW5iB4YlcNHlsdu87kGJ55tukmi8mxdAQ4Q7e2RCOFvu396j3x+UC
B5iPNgiV5+I3lg02dZ77DnKxHZu8A/lJBdiB3QW0KtZB6awBdpUKD9jf1b0SHzUv
KBds0pjBqAlkd25HN7rOrFleaJ1/ctaJxQZBKT5ZPt0m9STJEadao0xAH0ahmbWn
OlFuhjuefXKnEgV4We0+UXgVCwOPjdAvBbI+e0ocS3MFEvzG6uBQE3xDk3SzynTn
jh8BCNAw1FtxNrQHusEwMFxIt4I7mKZ9YIqioymCzLq9gwQbooMDQaHWBfEbwrbw
qHyGO0aoSCqI3Haadr8faqU9GY/rOPNk3sgrDQoo//fb4hVC1CLQJ13hef4Y53CI
rU7m2Ys6xt0nUW7/vGT1M0NPAgMBAAGjQjBAMA4GA1UdDwEB/wQEAwIBBjAPBgNV
HRMBAf8EBTADAQH/MB0GA1UdDgQWBBR5tFnme7bl5AFzgAiIyBpY9umbbjANBgkq
hkiG9w0BAQsFAAOCAgEAVR9YqbyyqFDQDLHYGmkgJykIrGF1XIpu+ILlaS/V9lZL
ubhzEFnTIZd+50xx+7LSYK05qAvqFyFWhfFQDlnrzuBZ6brJFe+GnY+EgPbk6ZGQ
3BebYhtF8GaV0nxvwuo77x/Py9auJ/GpsMiu/X1+mvoiBOv/2X/qkSsisRcOj/KK
NFtY2PwByVS5uCbMiogziUwthDyC3+6WVwW6LLv3xLfHTjuCvjHIInNzktHCgKQ5
ORAzI4JMPJ+GslWYHb4phowim57iaztXOoJwTdwJx4nLCgdNbOhdjsnvzqvHu7Ur
TkXWStAmzOVyyghqpZXjFaH3pO3JLF+l+/+sKAIuvtd7u+Nxe5AW0wdeRlN8NwdC
jNPElpzVmbUq4JUagEiuTDkHzsxHpFKVK7q4+63SM1N95R1NbdWhscdCb+ZAJzVc
oyi3B43njTOQ5yOf+1CceWxG1bQVs5ZufpsMljq4Ui0/1lvh+wjChP4kqKOJ2qxq
4RgqsahDYVvTH9w7jXbyLeiNdd8XM2w9U/t7y0Ff/9yi0GE44Za4rF2LN9d11TPA
mRGunUHBcnWEvgJBQl9nJEiU0Zsnvgc/ubhPgXRR4Xq37Z0j4r7g1SgEEzwxA57d
emyPxgcYxn/eR44/KJ4EBs+lVDR3veyJm+kXQ99b21/+jh5Xos1AnX5iItreGCc=
-----END CERTIFICATE-----
)EOF";
// End of defining MQTT objects

// bmp280 (Air Pressure)
Adafruit_BMP280 bmp;

// SHTC3 (Humidity)
SHTSensor sht;

// SGP30
Adafruit_SGP30 sgp;

// RTC Module
RTC_DS3231 rtc;

// DS18B20 Temperature Sensor
OneWire oneWire_DS18B20(DS18B20_PIN);
DallasTemperature DS18B20(&oneWire_DS18B20);

// loop
unsigned long premillis, premillisReadData;
bool uploadingSavedData = false, liveEnable = false, wifiProcessing = false;

// variables for calculate average of the parameters
float totalTemp, totalHumidity, totalPressure;
int totalCO2, totalTvoc;
int count;

/////
///// Get User Details
/////

void GetUserDetails(fs::FS &fs){
  Serial.printf("Reading file: /UserDetails.txt\n");

  File file = fs.open("/UserDetails.txt");
  if(!file){
    Serial.println("Failed to open file for reading");
    return;
  }

  String SavedDataAscii = "";
  while(file.available()){
    SavedDataAscii += (char)file.read();
  }

  String fline = "";
  int lineCount = 0;

  for (int i = 0; i < SavedDataAscii.length(); i++) {
    if (SavedDataAscii[i] == '\n'){
      fline.trim();
      if (lineCount == 0){
        mqtt_server = fline;
      }
      else if (lineCount == 1){
        username = fline;
      }
      else if (lineCount == 2){
        mqtt_password = fline; 
      }
      else if (lineCount == 3){
        mqtt_port = fline.toInt();
      }
      else if (lineCount == 4){
        deviceName = fline;
        break;
      }

      lineCount++;
      fline = "";
    }
    else{
      fline += SavedDataAscii[i];
    }
    
  }

  file.close();
}

void ErrorStop(){
  Serial.println("Can't Continue Process");
  Serial.flush();
  while (1) {
    digitalWrite(SENSOR_CALIBRATION_PIN, LOW);
    delay(250);
    digitalWrite(SENSOR_CALIBRATION_PIN, HIGH);
    delay(250);
  };
}
/////
///// Connection Functions 
/////

void WiFiEvent(WiFiEvent_t event){
  switch (event) {
    case ARDUINO_EVENT_ETH_START:
      Serial.println("ETH Started");
      //set eth hostname here
      ETHNET.setHostname("esp32-ethernet");
      break;
    case ARDUINO_EVENT_ETH_CONNECTED:
      Serial.println("ETH Connected");
      break;
    case ARDUINO_EVENT_ETH_GOT_IP:
      Serial.print("ETH MAC: ");
      Serial.print(ETHNET.macAddress());
      Serial.print(", IPv4: ");
      Serial.print(ETHNET.localIP());
      if (ETHNET.fullDuplex()) {
        Serial.print(", FULL_DUPLEX");
      }
      Serial.print(", ");
      Serial.print(ETHNET.linkSpeed());
      Serial.println("Mbps");
      eth_connected = true;
      WiFi.disconnect();
      digitalWrite(ETHERNET_CONNECTIVITY_INDICATOR_PIN, HIGH);
      break;
    case ARDUINO_EVENT_ETH_DISCONNECTED:
      Serial.println("ETH Disconnected");
      EndEthernetConnection();
      break;
    case ARDUINO_EVENT_ETH_STOP:
      Serial.println("ETH Stopped");
      EndEthernetConnection();
      break;
    default:
      break;
  }
}

bool WaitingForWifi(){
  Serial.printf("\nTring to connect via Wi-Fi...");

  Serial.println("\nWIFI SSID : " + WIFI_SSID);
  Serial.println("WIFI PASSWORD : " + WIFI_PASSWORD);

  const char* SSID = WIFI_SSID.c_str();
  const char* PWD = WIFI_PASSWORD.c_str();

  WiFi.begin(SSID, PWD);

  int waitingTimeForWifi = 0;
  while (WiFi.status() != WL_CONNECTED){
    digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, HIGH);
    Serial.print(".");
    delay(250);
    digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, LOW);
    delay(250);

    waitingTimeForWifi++;

    if (waitingTimeForWifi == 20){
      Serial.printf("\nConnot Connect via Wifi\n\n");
      return false;
    }
  }
  Serial.print("Connected with IP: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  return true;
}

void ConnectWifi(fs::FS &fs){
  if (wifiProcessing){
    return;
  }

  Serial.printf("\nSearching Wifi Details ........\n");
  Serial.printf("Reading file: /WifiDetails.txt\n");

  wifiProcessing = true;

  File file = fs.open("/WifiDetails.txt");
  if(!file){
    Serial.println("Failed to open file for reading");
    return;
  }

  String SavedDataAscii = "";
  while(file.available()){
    SavedDataAscii += (char)file.read();
  }

  String fline = "";
  int lineCount = 0;

  for (int i = 0; i < SavedDataAscii.length(); i++) {
    if (SavedDataAscii[i] == '\n'){
      fline.trim();
      switch (lineCount){
        case 1:
          WIFI_SSID = fline;
          break;
        case 2:
          WIFI_PASSWORD = fline;
          if (WaitingForWifi()){
            file.close();
            digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, HIGH);

            wifiProcessing = false;
            return;
          }
          else{
            lineCount = -1;
          }
          break;
      }

      lineCount++;
      fline = "";
    }
    else{
      fline += SavedDataAscii[i];
    }
  }

  file.close();
  digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, LOW);

  wifiProcessing = false;
}

void ConnectEthernet(){
  WiFi.onEvent(WiFiEvent);

  Serial.printf("\nTrying to access Internet via Ethernet..");

  ETHNET.begin(MISO_GPIO, MOSI_GPIO, SCLK_GPIO, CS_GPIO, INT_GPIO, SPI_CLOCK_MHZ, SPI_HOST);

  int waitingTimeForEthernet = 0;

  while(!eth_connected) {
    digitalWrite(ETHERNET_CONNECTIVITY_INDICATOR_PIN, HIGH);
    Serial.print(".");

    waitingTimeForEthernet++;
    if (waitingTimeForEthernet >= 10){ // 10 Seconds
      Serial.println("Cannot Connect via Ethernet....");
      digitalWrite(ETHERNET_CONNECTIVITY_INDICATOR_PIN, LOW);
      break;
    }
    delay(500);
    digitalWrite(ETHERNET_CONNECTIVITY_INDICATOR_PIN, LOW);
    delay(500);
  }
}

void ReconnectWifi(){
  if (wifiProcessing){
    return;
  }
  
  if (WiFi.status() != WL_CONNECTED){
    digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, LOW);
  }
  else{
    digitalWrite(WIFI_CONNECTIVITY_INDICATOR_PIN, HIGH);
  }
}

void EndEthernetConnection(){
  digitalWrite(ETHERNET_CONNECTIVITY_INDICATOR_PIN, LOW);
  eth_connected = false;
  if (WiFi.status() != WL_CONNECTED){
    delay(100);
    ConnectWifi(SD);
  }
}

void ConnectToFirebase(){
  Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
  Firebase.reconnectWiFi(true);

  //Set database read timeout to 1 minute (max 15 minutes)
  Firebase.setReadTimeout(firebaseData, 1000 * 60);

  Firebase.setwriteSizeLimit(firebaseData, "tiny");

  if (eth_connected){
    Serial.println("Connected to Firebase Database via Ethernet");  
  }
  else{
    Serial.println("Connected to Firebase Database via WIFI");
  }
}

////
//// MQTT Functions
////

void reconnect() {
  // Loop until we’re reconnected
  int waitTimeForMQTTConnection = 0;

  while (!client.connected()) {
    Serial.println();
    Serial.print("Attempting MQTT connection…");
    String clientId = "ESP32Client-"; // Create a random client ID
    clientId += String(random(0xffff), HEX);
    // Attempt to connect

    Serial.println();
    Serial.println("Username : " + username);
    Serial.println("Password : " + mqtt_password);

    const char* PASSWORD = mqtt_password.c_str();
    const char* USERNAME = username.c_str();

    if (client.connect(clientId.c_str(), USERNAME, PASSWORD)) {
      Serial.println("Connected To MQTT Broker");

      // subscribe the topics here
      client.subscribe("enable");
      client.subscribe("channel1");
      client.subscribe("activeR");
    } 
    else {
      if (waitTimeForMQTTConnection == 24){
        Serial.println("Cannot Connect MQTT Broker");
        break;
      }

      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 2 seconds");   // Wait 2 seconds before retrying

      delay(2000);

      waitTimeForMQTTConnection++;
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length) {
  String incommingMessage = "";
  for (int i = 0; i < length; i++) incommingMessage+=(char)payload[i];

  if (String(topic) == "enable"){
    if (String(incommingMessage) == "1"){
      Serial.printf("\nStarting Live Server"); 
      liveEnable = true;
    }
    else{
      Serial.printf("\nStopping Live Server");
      liveEnable = false;
    }
  }
  else if (String(topic) == "channel1"){
    Serial.print("Channel 01 - ");

    if (String(incommingMessage) == "1"){
      digitalWrite(RELAY_PIN, HIGH);
      Serial.println("ON");
    }
    else{
      digitalWrite(RELAY_PIN, LOW);
      Serial.println("OFF");
    }
  }
  else if (String(topic) == "activeR"){
    

    String cDate = String(rtc.now().year()) + "-" + String(rtc.now().month()) + "-" + String(rtc.now().day()) + "-" + String(rtc.now().hour());

    if (String(incommingMessage) == cDate){
      publishMessage("activeT", cDate, true);
      Serial.print("\nSend activity status to web application : " + cDate);
    }
    else{
      Serial.print("\nTime Not Matching : " + String(incommingMessage));
    }

    
  }
  //Serial.println("Message arrived ["+String(topic)+"]"+incommingMessage);
}

void publishMessage(const char* topic, String payload , boolean retained){
  if (!client.publish(topic, payload.c_str(), true)){
    Serial.println("Failed To publish message");
  }
}

void ConnectToMQTTBroker(){
  Serial.println();
  Serial.println("MQTT Server URL : " + mqtt_server);
  Serial.println("MQTT Port No : " + String(mqtt_port));

  const char* SERVER = mqtt_server.c_str();

  espClient.setCACert(root_ca);
  client.setServer(SERVER, mqtt_port);
  client.setCallback(callback);

  if (!client.connected()) reconnect();

  Serial.println();
}

/////
///// Microchip Module Functions
/////

void InitializeSDCard(){
  Serial.println("Initializing SD Card");

  if(!SD.begin()){
    Serial.println("Card Mount Failed.");
    ErrorStop();
    return;
  }
  uint8_t cardType = SD.cardType();

  if(cardType == CARD_NONE){
    Serial.println("No SD card attached");
    return;
  }

  Serial.print("SD Card Type: ");
  if(cardType == CARD_MMC){
    Serial.println("MMC");
  } 
  else if(cardType == CARD_SD){
    Serial.println("SDSC");
  } 
  else if(cardType == CARD_SDHC){
    Serial.println("SDHC");
  } 
  else {
    Serial.println("UNKNOWN");
  }

  uint64_t cardSize = SD.cardSize() / (1024 * 1024);
  Serial.printf("SD Card Size: %lluMB\n", cardSize);
}

void appendFile(fs::FS &fs, const char * path, String message){
    Serial.printf("Appending to file: %s\n", path);

    File file = fs.open(path, FILE_APPEND);
    if(!file){
        Serial.println("Failed to open file for appending");
        return;
    }
    if(file.print(message)){
        Serial.println("Message appended");
    } else {
        Serial.println("Append failed");
    }
    file.close();
}

void currentCapacitySD(){
  Serial.printf("Total space: %lluMB\n", SD.totalBytes() / (1024 * 1024));
  Serial.printf("Used space: %lluMB\n", SD.usedBytes() / (1024 * 1024));
} 

////
//// Module Testing Functions
////

void TestBMP280(){
   // Testing BMP280
  Serial.println("Testing BMP280");
  if (!bmp.begin(0x76)) {
    Serial.println("Could not find a valid BMP280 sensor, check wiring!");
  }
  Serial.println("BMP280 Successed");
}

void TestSHTC3(){
   // Testing SHTC3 Module
  Serial.println("\nTesting SHTC3");
  if (!sht.init()) {
    Serial.println("Could not find a valid SHTC3 sensor, check wiring!");
  }
  Serial.println("SHTC3 Successed");
}

void TestSGP30(){
  Serial.println("\nTesting SGP30");

  digitalWrite(SENSOR_INDICATOR_PIN, LOW);

  if (!sgp.begin()) {
    Serial.println("Could not find a valid SGP30 sensor, check wiring!");
  }
  else{
    Serial.println("SGP30 Successed");
  }

  digitalWrite(SENSOR_INDICATOR_PIN, HIGH);

  Serial.print("Found SGP30 serial #");
  Serial.print(sgp.serialnumber[0], HEX);
  Serial.print(sgp.serialnumber[1], HEX);
  Serial.println(sgp.serialnumber[2], HEX);

  //sgp.setIAQBaseline(0x8E68, 0x8F41); // self-calibrate
}

void TestRTC(){
  Serial.println("\nRTC Test");
  if (!rtc.begin()) {
    Serial.println("Couldn't find RTC");
    ErrorStop();
  }
  Serial.println("RTC Successed");

  if (rtc.lostPower()) {
    Serial.println("RTC lost power, let's set the time!");
    rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
  }
  //rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
}

void TestDS18B20(){
  // Start the DS18B20 sensor
  Serial.println("\nTesting DS18B20 Temperature Sensor");
  DS18B20.begin();
  Serial.println("DS18B20 Temperature Sensor Succesed.");
}

/////
///// Update values on sensors
/////

// update humidity from SHTC3
void UpdateSHTC3(){
  // read humidity 
  if (!sht.init()) {
    Serial.println("Could not find a valid SHTC3 sensor, check wiring!");
  }
}

/////
///// Read Values from each module or sensor
/////

// get air pressure from bmp280
float ReadBMP280(){
  // Read air pressure value
  if (String(bmp.readPressure()) == "nan"){
    return 0;
  }
  return bmp.readPressure(); 
}

// get temperature from DS18B20
float ReadDS18B20(){
  // Read temperature value
  DS18B20.requestTemperatures();
  return DS18B20.getTempCByIndex(0);
  
}

float ReadSHTC3(){
  UpdateSHTC3();

  if (String(sht.getHumidity()) == "nan"){
    return 0;
  }
  return sht.getHumidity();
}

void ReadDataFromSensors(){
  if (millis() - premillisReadData >= 10000){
    Serial.println("\nCalculating values.....");

    totalTemp += ReadDS18B20();
    totalHumidity += ReadSHTC3();
    totalPressure += ReadBMP280();
    totalCO2 += sgp.eCO2;
    totalTvoc += sgp.TVOC;
    count += 1;
    premillisReadData = millis();
  }  
}

void ResetTotals(){
  totalTemp = 0;
  totalHumidity = 0;
  totalPressure = 0;
  totalCO2 = 0;
  totalTvoc = 0;
  count = 0;
}

////
//// SGP30 Functions
////

uint32_t getAbsoluteHumiditySGP30(float temperature, float humidity) {
    // approximation formula from Sensirion SGP30 Driver Integration chapter 3.15
    const float absoluteHumidity = 216.7f * ((humidity / 100.0f) * 6.112f * exp((17.62f * temperature) / (243.12f + temperature)) / (273.15f + temperature)); // [g/m^3]
    const uint32_t absoluteHumidityScaled = static_cast<uint32_t>(1000.0f * absoluteHumidity); // [mg/m^3]
    return absoluteHumidityScaled;
}

// Update SGP value
void UpdateSGP30(){
  
  UpdateSHTC3();
  sgp.setHumidity(getAbsoluteHumiditySGP30(ReadDS18B20(), sht.getHumidity()));

  if (!sgp.IAQmeasure()) {
    Serial.println("SGP Measurement Failed");
    //return;
  }
}

// Setup SGP30
void WarmupSGP30(){
  UpdateSGP30();
  Serial.println("Warmup SGP30...");

  uint8_t waitTime = 0;

  while (sgp.TVOC == 0 && sgp.eCO2 <= 400){
    digitalWrite(SENSOR_CALIBRATION_PIN, LOW);
    if (sgp.eCO2 == 0){
      Serial.println("Sensor not found....");
      
      if (waitTime == 10){
        Serial.println("Error SGP30");
        digitalWrite(SENSOR_CALIBRATION_PIN, HIGH);
        return;
      }

      delay(1000);
    }

    waitTime++;

    if (waitTime == 30){
      break;
    }
    Serial.print(".");
    digitalWrite(SENSOR_CALIBRATION_PIN, HIGH);
    delay(5000);
    UpdateSGP30();
  }

  digitalWrite(SENSOR_CALIBRATION_PIN, HIGH);
  Serial.println("SGP30 Ready to use....");
}

/////
///// Uploading Functions
/////

void CheckTimeForUploadData(){
  if (millis() - premillis >= 600000){
    UploadData();
    premillis = millis();
  }
}

void UploadSavedData(fs::FS &fs){
  uploadingSavedData = true;
  FirebaseJson json;

  Serial.printf("\nReading file: /TemporaryValues.txt\n");

  File file = fs.open("/TemporaryValues.txt");
  if(!file){
    Serial.println("Failed to open file for reading");
    return;
  }

  Serial.println("Read from file: ");

  String SavedDataAscii = "";
  while(file.available()){
    SavedDataAscii += (char)file.read();
  }

  String fline = "", path, savedTime = "";
  int lineCount = 0;

  for (int i = 0; i < SavedDataAscii.length(); i++) {
    if (SavedDataAscii[i] == '\n'){
      switch (lineCount){
        case 1:
          path = "/" + username + "/Device/" + DeviceID + "/Readings/" + fline;
          savedTime = fline;
          break;
        case 2:
          json.set("/Temp", fline.toFloat());
          break;
        case 3:
          json.set("/Pressure", fline.toFloat());
          break;
        case 4:
          json.set("/Humidity", fline.toFloat());
          break;
        case 5:
          json.set("/CO2", fline.toFloat());
          break;
        case 6:
          json.set("/TVOC", fline.toFloat());
          Serial.printf("Update node... %s\n", Firebase.updateNode(firebaseData, path, json) ? String(savedTime) : firebaseData.errorReason().c_str());
          Serial.println("Saved Data - Upload");
          lineCount = -1;
          CheckTimeForUploadData();
          break;
      }

      lineCount++;
      fline = "";
    }
    else{
      fline += SavedDataAscii[i];
    }
    
  }

  file.close();
  Serial.println("Saved Data Upload Completed.....");

  file = fs.open("/TemporaryValues.txt", FILE_WRITE);
  file.print("");
  file.close();

  uploadingSavedData = false;
}

void SaveDataInSDCard(String ctime){
  Serial.println("\nTemporary Data Saved in SD Card.....");

  appendFile(SD, "/TemporaryValues.txt", "#\n");
  appendFile(SD, "/TemporaryValues.txt", ctime + "\n");
  appendFile(SD, "/TemporaryValues.txt", String(totalTemp / count) + "\n");
  appendFile(SD, "/TemporaryValues.txt", String(totalPressure / count) + "\n");
  appendFile(SD, "/TemporaryValues.txt", String(totalHumidity / count) + "\n");
  appendFile(SD, "/TemporaryValues.txt", String(sgp.eCO2) + "\n");
  appendFile(SD, "/TemporaryValues.txt", String(sgp.TVOC) + "\n");
}

String ReadRTC(){
  String currenttime = String(rtc.now().year());
  
  if (rtc.now().month() < 10){
    currenttime += "-0" + String(rtc.now().month());
  }
  else{
    currenttime += "-" + String(rtc.now().month());
  }

  if (rtc.now().day() < 10){
    currenttime += "-0" + String(rtc.now().day());
  }
  else{
    currenttime += "-" + String(rtc.now().day());
  }

  if (rtc.now().hour() < 10){
    currenttime += " 0" + String(rtc.now().hour());
  }
  else{
    currenttime += " " + String(rtc.now().hour());
  }

  if (rtc.now().minute() < 10){
    currenttime += ":0" + String(rtc.now().minute());
  }
  else{
    currenttime += ":" + String(rtc.now().minute());
  }

  //String currenttime = String(rtc.now().year()) + "-" + String(rtc.now().month()) + "-" + String(rtc.now().day()) + " " + String(rtc.now().hour()) + ":" + String(rtc.now().minute()) + ":" + String(rtc.now().second());
  Serial.println("Current Time : " + currenttime);
  return currenttime;
}

// Upload data to firebase database
void UploadData(){
  Serial.println("\nUploading Data to Firebase database ..... ");
  
  UpdateSGP30();
  UpdateSHTC3();

  FirebaseJson json;

  if (sgp.TVOC == 0 && sgp.eCO2 == 400){
    delay(500);
    WarmupSGP30();
  }

  json.set("/Temp", totalTemp / count);
  json.set("/Pressure", totalPressure / count);
  json.set("/Humidity", totalHumidity / count);
  json.set("/CO2", sgp.eCO2);
  json.set("/TVOC", sgp.TVOC);

  // get values from RTC Module
  String ctime = ReadRTC();
  String path = "/" + username + "/Device/" + DeviceID + "/Readings/" + ctime;

  if (WiFi.status() == WL_CONNECTED || eth_connected){
    // upload data into firebase using wifi
    if (Firebase.updateNode(firebaseData, path, json)){

      if (eth_connected){
        Serial.println("Upload Completed via Ethernet.....");
        Serial.println("Uploading Saved data via Ethernet.....");
      }
      else{
        Serial.println("Upload Completed via WIFI.....");
        Serial.println("Uploading Saved data via WIFI.....");
      }

      path = "/" + username + "/Device/" + DeviceID + "/Last/";
      json.set("/Time", ctime);

      if (Firebase.updateNode(firebaseData, path, json)){
        Serial.println("Updated last dataset in Firebase..");
      }
      
      if (!uploadingSavedData){
        UploadSavedData(SD);
      }
    }
    else{
      Serial.println(firebaseData.errorReason().c_str());
      SaveDataInSDCard(ctime);
    }
  }
  else{
    Serial.println("Upload Failed via either WIFI or Ethernet.....");
    SaveDataInSDCard(ctime);    
  }  

  ResetTotals();
}

void UploadDataLiveServer(){
  if (liveEnable) {
    UpdateSGP30();

    publishMessage("temp",String(ReadDS18B20()),true);
    publishMessage("pressure",String(ReadBMP280()),true);
    publishMessage("humidity",String(ReadSHTC3()),true);
    publishMessage("co2",String(sgp.eCO2),true);
    publishMessage("tvoc",String(sgp.TVOC),true);

    Serial.println("Data published successfully..");
  }
}

void UploadServerURL(){
  Serial.println("\nUploading MQTT Data to Firebase database ..... ");

  FirebaseJson json;

  json.set("/MQTT", mqtt_server);
  json.set("/Name", deviceName);

  Serial.println("\nDevice Name : " + deviceName);
  Serial.println("\nMQTT URL : " + mqtt_server);

  // get values from RTC Module
  String path = "/" + username + "/Device/" + DeviceID;
  if (Firebase.updateNode(firebaseData, path, json)){
    Serial.print("Upload Completed\n");
  }
}

void UploadUserDetails(){
  Serial.println("\nUploading User to Firebase database ..... ");

  FirebaseJson json;

  json.set("/Password", mqtt_password);

  // get values from RTC Module
  String path = "/" + username;
  if (Firebase.updateNode(firebaseData, path, json)){
    Serial.print("Upload Completed\n");
  }
}

/////
///// Main Functions
/////

void setup() {
  Serial.begin(115200);

  Serial.printf("Starting System........\n\n");

  pinMode(RELAY_PIN, OUTPUT);
  pinMode(SENSOR_INDICATOR_PIN, OUTPUT);

  pinMode(SENSOR_CALIBRATION_PIN, OUTPUT);
  pinMode(WIFI_CONNECTIVITY_INDICATOR_PIN, OUTPUT);
  pinMode(ETHERNET_CONNECTIVITY_INDICATOR_PIN, OUTPUT);

  digitalWrite(SENSOR_CALIBRATION_PIN, HIGH);
  digitalWrite(SENSOR_INDICATOR_PIN, HIGH);

  // tring to Initialize SD Card
  InitializeSDCard();

  // Find user details
  GetUserDetails(SD);

  Serial.println();
  Serial.println("Device ID : " + DeviceID);
  Serial.println("Username : " + username);

  // test rtc
  TestRTC();
  
  // tring to connect ethernet
  ConnectEthernet();

  // when can't connect via ethernet trying to connect via wifi
  if (!eth_connected){
    ConnectWifi(SD);
  }

  ConnectToFirebase();
  
  // only connected to either wifi or ethernet, trying to connect Firebase and MQTT broker
  if (eth_connected || WiFi.status() == WL_CONNECTED){
    ConnectToMQTTBroker();

    UploadServerURL();
    UploadUserDetails();

    UploadSavedData(SD);
  }

  // Testing all sensors
  TestBMP280();
  TestSHTC3();
  TestSGP30();
  TestDS18B20();

  // warmup SGP30 sonsor
  //WarmupSGP30();

  premillis = millis();
  premillisReadData = millis();
  ResetTotals();
}

void loop() {
  ReadDataFromSensors();
  CheckTimeForUploadData();

  // MQTT Server Sync
  if (client.connected()){
    client.loop();
    UploadDataLiveServer();
  }
  else if (WiFi.status() == WL_CONNECTED || eth_connected){
    reconnect();
  }

  ReconnectWifi();
}

