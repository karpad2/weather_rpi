

#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include "DHT.h"

#define DHTPIN 4 
#define DHTTYPE DHT22 


const char* ssid     = "your-ssid";
const char* password = "your-password";
DHT dht(DHTPIN, DHTTYPE);

void setup() {

    Serial.begin(115200);

    Serial.println();
    Serial.println();
    Serial.println();

   
    Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
    
}

void loop() {
        HTTPClient http;

        Serial.print("[HTTP] begin...\n");
        double h = dht.readHumidity();
           
          double t = dht.readTemperature();
        
        String httpRequestData = "temperature="+String(t)+"&humidity="+String(h);
        http.begin("http://192.168.0.101/api/save"); //HTTP
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

         Serial.print("[HTTP] GET...\n");
        // start connection and send HTTP header
        int httpCode = http.POST(httpRequestData);


        

        // httpCode will be negative on error
        if(httpCode > 0) {
            // HTTP header has been send and Server response header has been handled
            Serial.printf("[HTTP] POST... code: %d\n", httpCode);

            // file found at server
            if(httpCode == HTTP_CODE_OK) {
                String payload = http.getString();
                Serial.println(payload);
            }
        } else {
            Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
        }

        http.end();
        delay(5000);
    }
