#include <Arduino.h>
#include <WiFi.h>
#include <WebSocketsClient.h>
#include <SocketIOclient.h>
#include <ArduinoJson.h>

SocketIOclient socketIO;

void socketIOEvent(socketIOmessageType_t type, uint8_t *payload, size_t length)
{
  switch (type)
  {
    case sIOtype_DISCONNECT:
      Serial.printf("[IOc] Disconnected!\n");
      break;
    case sIOtype_CONNECT:
      Serial.printf("[IOc] Connected to url: %s\n", payload);
      // join default namespace (no auto join in Socket.IO V3)
      socketIO.send(sIOtype_CONNECT, "/");
      break;
    case sIOtype_EVENT:
      Serial.printf("[IOc] get event: %s\n", payload);
      break;
    case sIOtype_ACK:
      Serial.printf("[IOc] get ack: %u\n", length);
      break;
    case sIOtype_ERROR:
      Serial.printf("[IOc] get error: %u\n", length);
      break;
    case sIOtype_BINARY_EVENT:
      Serial.printf("[IOc] get binary: %u\n", length);
      break;
    case sIOtype_BINARY_ACK:
      Serial.printf("[IOc] get binary ack: %u\n", length);
      break;
  }
}

void setup()
{
  // put your setup code here, to run once:
  Serial.begin(115200);
  Serial.setDebugOutput(true);

  // Connect to wifi
  //WiFi.begin("abcde", "12345678"); 192.168.43.1
  WiFi.begin("Luan4G", "12345678");

  // Wait some time to connect to wifi
  for (int i = 0; i < 10 && WiFi.status() != WL_CONNECTED; i++)
  {
    Serial.print(".");
    delay(1000);
  }

  // Check if connected to wifi
  if (WiFi.status() != WL_CONNECTED)
  {
    Serial.println("No Wifi!");
    return;
  }
  Serial.println("");
  Serial.printf("Connected to wifi. Connecting to server.\n");

  // server address, port and URL
  socketIO.begin("192.168.100.104", 3000, "/socket.io/?EIO=4");

  // event handler
  socketIO.onEvent(socketIOEvent);
}

uint64_t messageTimestamp;
void loop()
{
  socketIO.loop();
  uint64_t now = millis();
  if (now - messageTimestamp > 5000) {
    messageTimestamp = now;
    // Send event
    socketIO.sendEVENT("[\"message\", \"new message from esp32\"]");
  }
}

// unsigned long messageTimestamp = 0;
// void loop()
// {
//   socketIO.loop();
  
//   uint64_t now = millis();

//     if(now - messageTimestamp > 2000) {
//       messageTimestamp = now;

//       // creat JSON message for Socket.IO (event)
//       DynamicJsonDocument doc(1024);
//       JsonArray array = doc.to<JsonArray>();

//       // add evnet name
//       // Hint: socket.on('event_name', ....
//       array.add("event_name");

//       // add payload (parameters) for the event
//       JsonObject param1 = array.createNestedObject();
//       param1["now"] = (uint32_t) now;

//       // JSON to String (serializion)
//       String output;
//       serializeJson(doc, output);

//       // Send event
//       socketIO.sendEVENT("[\"message\", \"message from esp32\"]");

//       // Print JSON for debugging
//       Serial.println(output);
//     }
// }