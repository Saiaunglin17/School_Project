// #include <Wire.h>
// #include <LiquidCrystal_I2C.h>
// #include <DHT.h>
// #include <MQUnifiedsensor.h>

// Blynk
#define BLYNK_TEMPLATE_ID "TMPL6yMYG6Yho"
#define BLYNK_TEMPLATE_NAME "AIR QUALITY MONITOR"
#define BLYNK_AUTH_TOKEN "83YjA6GfRIOXekTM7nqbHJn4Jm3mMKfF"
#define BLYNK_PRINT Serial

// Wifi
#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <BlynkSimpleEsp32_SSL.h>

// WiFi credentials.
char ssid[] = "Garo";
char pass[] = "garo1704";

// // Initialize LCD and DHT
// LiquidCrystal_I2C lcd(0x27, 16, 2);
// #define DHTPIN 5
// #define DHTTYPE DHT11
// DHT dht(DHTPIN, DHTTYPE);
// float t,h = 0;

// // Initialize MQ135
// #define placa "ESP-32"
// #define Voltage_Resolution 3.3
// #define pin 34
// #define type "MQ-135"
// #define ADC_Bit_Resolution 12
// #define RatioMQ135CleanAir 3.6  
// double CO = (0);
// MQUnifiedsensor MQ135(placa, Voltage_Resolution, ADC_Bit_Resolution, pin, type);

void setup() {
  Serial.begin(115200);
  // dht.begin();
  // lcd.init();
  // lcd.backlight();
  // lcd.setCursor(0, 0);
  // lcd.print("DHT11 Test");

  // Connect with blynk
  Blynk.begin(BLYNK_AUTH_TOKEN, ssid, pass);

  // //Set math model to calculate the PPM concentration and the value of constants   
  //   MQ135.setRegressionMethod(1); //_PPM =  a*ratio^b   
  //   MQ135.setA(605.18); 
  //   MQ135.setB(-3.937); 
  //   // Configurate the ecuation values to get NH4 concentration    
  //   MQ135.init();    
  //   Serial.print("Calibrating please wait.");   
  //   float calcR0 = 0;   
  //   for(int i = 1; i<=10; i ++)   {     
  //       MQ135.update(); // Update data, the arduino will be read the voltage on the analog pin     
  //       calcR0 += MQ135.calibrate(RatioMQ135CleanAir);    
  //       Serial.print(".");   
  //   }   
  //   MQ135.setR0(calcR0/10);   
  //   Serial.println("  done!.");      
  //   if(isinf(calcR0)) { Serial.println("Warning: Conection issue founded, R0 is infite (Open circuit detected) please check your wiring and supply"); while(1);}   
  //   if(calcR0 == 0){Serial.println("Warning: Conection issue founded, R0 is zero (Analog pin with short circuit to ground) please check your wiring and supply"); while(1);}   
  //   /*****************************  MQ CAlibration **************************/                   
  //   MQ135.serialDebug(false); 
}

void loop() {

  Blynk.run();

  // t = dht.readTemperature();
  // h = dht.readHumidity();

  // if (isnan(t) || isnan(h)) {
  //   lcd.setCursor(0, 0);
  //   lcd.print("Sensor Error!");
  //   Serial.println("Failed to read from DHT sensor!");
  // } else {
  //   lcd.clear();
  //   lcd.setCursor(0, 0);
  //   lcd.print("Temp: ");
  //   lcd.print(t);
  //   lcd.print((char)223); // Degree symbol
  //   lcd.print("C");

  //   lcd.setCursor(0, 1);
  //   lcd.print("Humidity: ");
  //   lcd.print(h);
  //   lcd.print("%");

  //   Serial.print("Temp: ");
  //   Serial.print(t);
  //   Serial.println(" C");
  //   Serial.print("Humidity: ");
  //   Serial.print(h);
  //   Serial.println(" %");
  // }
  // MQ135.update(); // Update data, the arduino will be read the voltage on the analog pin   
  //   CO = MQ135.readSensor(); // Sensor will read CO concentration using the model and a and b values setted before or in the setup   
  //   Serial.print("CO: ");   
  //   Serial.println(CO);  	

  // delay(2000);
}