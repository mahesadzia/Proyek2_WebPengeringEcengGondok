#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>
#include <ArduinoJson.h>

// ====== ISI SESUAI KONDISIMU ======
const char* WIFI_SSID = "Mahasiswa";
const char* WIFI_PASS = "@Polindra2026";
const char* SERVER_URL = "http://10.0.166.222:8000/api/sensor";
const char* API_TOKEN = "5b20eea1b9fdcb6080f88d5b2659a814";
const char* KODE_PERANGKAT = "ESP-001";

#define DHT_PIN 4
#define DHT_TYPE DHT11   // Ubah ke DHT22 jika memakai sensor DHT22
const unsigned long INTERVAL_MS = 5000;
// ==================================

DHT dht(DHT_PIN, DHT_TYPE);
unsigned long waktuTerakhirKirim = 0;

void sambungWiFi() {
  if (WiFi.status() == WL_CONNECTED) return;

  WiFi.mode(WIFI_STA);
  WiFi.disconnect(true);
  delay(500);

  Serial.print("Menyambung ke WiFi ");
  Serial.println(WIFI_SSID);
  WiFi.begin(WIFI_SSID, WIFI_PASS);

  unsigned long mulai = millis();
  while (WiFi.status() != WL_CONNECTED) {
    if (millis() - mulai > 15000) {
      Serial.println("Belum tersambung, reset koneksi WiFi...");
      WiFi.disconnect(true);
      WiFi.mode(WIFI_OFF);
      delay(1000);
      WiFi.mode(WIFI_STA);
      delay(500);
      WiFi.begin(WIFI_SSID, WIFI_PASS);
      mulai = millis();
    }
    delay(500);
  }

  Serial.print("Terhubung. IP ESP32: ");
  Serial.println(WiFi.localIP());
}

void setup() {
  Serial.begin(115200);
  delay(500);
  dht.begin();
  sambungWiFi();
}

void loop() {
  sambungWiFi();

  if (millis() - waktuTerakhirKirim < INTERVAL_MS) {
    delay(50);
    return;
  }
  waktuTerakhirKirim = millis();

  float kelembaban = dht.readHumidity();
  float suhu = dht.readTemperature();

  if (isnan(suhu) || isnan(kelembaban)) {
    Serial.println("Gagal membaca sensor DHT. Cek kabel, pin, dan jenis sensor (DHT11/DHT22).");
    delay(2000);
    return;
  }

  float suhuBulat = round(suhu * 10.0) / 10.0;
  float kelembabanBulat = round(kelembaban * 10.0) / 10.0;

  JsonDocument doc;
  doc["kode_perangkat"] = KODE_PERANGKAT;
  doc["suhu"] = suhuBulat;
  doc["kelembaban"] = kelembabanBulat;
  doc["heater"] = false;
  doc["kipas"] = false;

  String payload;
  serializeJson(doc, payload);

  WiFiClient client;
  HTTPClient http;

  if (!http.begin(client, SERVER_URL)) {
    Serial.println("Gagal mengirim: tidak bisa menginisialisasi HTTPClient");
    return;
  }

  http.setTimeout(10000);
  http.addHeader("Content-Type", "application/json");
  http.addHeader("X-IOT-TOKEN", API_TOKEN);

  int httpCode = http.POST(payload);

  if (httpCode > 0) {
    String respon = http.getString();
    Serial.printf("Suhu %.1f C | Kelembaban %.1f %% -> HTTP %d\n", suhuBulat, kelembabanBulat, httpCode);
    Serial.println(respon);
  } else {
    Serial.printf("Gagal mengirim: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end();
}