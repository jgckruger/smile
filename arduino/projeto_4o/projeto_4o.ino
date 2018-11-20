// Armazenamento
#include <ArduinoJson.h>       // JSON
#include <FS.h>                // FS - Sistema de arquivos SPIFFS

// Wi-Fi Manager
#include <ESP8266WiFi.h>       // ESP Wi-Fi
#include <DNSServer.h>         // DNS - redireciona as requisições
#include <ESP8266WebServer.h>  // WebServer - Possibilita usar o ESP de servidor facilmente
#include <WiFiManager.h>       // Portal Captive

// Funcionamento do projeto como um todo
#include <SPI.h>               // SPI - protocolo do MFRC522
#include "MFRC522.h"           // MFRC522 - RFID da Mifare
#include <Wire.h>              // I2C - protocolo do display LCD
#include <LiquidCrystal_I2C.h> // LCD I2C - display para feedback das ações



// Variáveis do dispositivo - preparadas para serem configuradas no portal Captive
char camera_entrada[128];
char camera_saida[128];
char identificador[64];
char ip_servidor[128];
char porta_servidor[6];
char camera_entrada2[128];
char camera_saida2[128];
char qualidadeStr[2];
int qualidade;
WiFiManagerParameter custom_camera_entrada("ipentrada", "IP da camera de entrada - HQ", camera_entrada, 128);
WiFiManagerParameter custom_camera_saida("ipsaida", "IP da camera de saida - HQ", camera_saida, 128);
WiFiManagerParameter custom_camera_entrada2("ipentrada2", "IP da camera de entrada - LQ", camera_entrada2, 128);
WiFiManagerParameter custom_camera_saida2("ipsaida2", "IP da camera de saida - LQ", camera_saida2, 128);
WiFiManagerParameter custom_identificador("identificador", "Identificador do dispositivo", identificador, 64);
WiFiManagerParameter custom_ip_servidor("ip_servidor", "IP do servidor", ip_servidor, 64);
WiFiManagerParameter custom_porta_servidor("porta_servidor", "Porta do servidor", porta_servidor, 6);
WiFiManagerParameter custom_qualidade("qualidadeStr", "Qualidade (1 para HQ ou 0 para LQ)", qualidadeStr, 1);

// Dados do Servidor
char* host; // IP do Servidor
int   port;            // Porta do Servidor


// Flag para salvar dados no FS
bool shouldSaveConfig = false;

// Flag para resetar o ESP para as configurações originais - DEVE SER USADO PARA TESTES APENAS
bool deveResetar = false;



// Pinos do NodeMCU: https://jgamblog.files.wordpress.com/2018/02/esp8266-nodemcu-pinout.png

/* Ligando o MFRC522 ao NodeMCU (ESP-12F)
 *  RST     = D4
 *  SDA(SS) = D8 
 *  MOSI    = D7
 *  MISO    = D6
 *  SCK     = D5
 *  GND     = GND
 *  3.3V    = 3.3V
 *  RQ      = Não ligado
*/

#define RST_PIN  D4 
#define SS_PIN  D8  
MFRC522 mfrc522(SS_PIN, RST_PIN); // Instância do MFRC522




/* Ligando o LCD I2C ao NodeMCU
 *  SCL = D2
 *  SDA = D3
 *  VCC = 5.0V
 *  GND = GND
 *  Endereço de memória - 0x27
 */
 
#define SCL_PIN D2
#define SDA_PIN D3
LiquidCrystal_I2C lcd(0x27, 16, 2); //FUNÇÃO DO TIPO "LiquidCrystal_I2C"


// Pinos para detecção de sentido
#define inPin D0
#define outPin D1



// Prevenção de excesso de registros
const int watchdog = 5000;
unsigned long previousMillis = 0;
/*
void conectaWifi(){
  //Serial.print("Conectando a ");
  //Serial.println(ssid);
  escreveMensagemLCD("Conectando a", ssid);

  
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    //Serial.print(".");
  }
  
  //Serial.println(F("\nConectado ao Wi-Fi\n"));
  escreveMensagemLCD("Conectado!", "");
  //Serial.print("Endereço IP: ");
  //Serial.println(WiFi.localIP());
  //Serial.println(F("\nPronto para realizar o envio!"));
  //Serial.println(F("======================================================\n\n")); 
}*/

void iniciaMFRC(){
  SPI.begin();           // Iniciando barramento SPI 
  mfrc522.PCD_Init();    // Iniciando MFRC522
  escreveMensagemLCD("RFID conectado!", "");
}


String recuperaRFID(byte *buffer, byte bufferSize){
  String content = "";
  for (byte i = 0; i < bufferSize; i++) {
    content.concat(String(buffer[i] < 0x10 ? " 0" : " "));
    content.concat(String(buffer[i], HEX));
  }
  content.toUpperCase();
  return content;
}

void leCartao(){
  escreveMensagemLCD("Escaneando RFID", "");
  // Procura novos cartões a serem lidos
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    delay(50);
    return;
  }
  // Escolhe um dos cartões
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    delay(50);
    return;
  }
  // Mostra detalhes do PICC (tag/cartão)
  //Serial.print(F("UID do Cartão:"));
  String rfid = recuperaRFID(mfrc522.uid.uidByte, mfrc522.uid.size);
  //Serial.print(rfid);
  //Serial.println();
  escreveMensagemLCD("UID do cartao", rfid);

  // Substitui espaços por + para envio de parâmetro via HTTP/GET
  //Serial.print(F("UID do Cartão sem espaços:"));
  String rfidGET = rfid;
  rfidGET.replace(" ","+");
  //Serial.print(rfidGET);
  //Serial.println();

  // Envio para o servidor
  postRFID(rfidGET);
}

void mostraMensagemInicial(){
  //Serial.println(F("Escaneando por cartões e escrevendo a UID:"));
  //Serial.println("");
  escreveMensagemLCD("Escaneando RFID", "");
}

void postRFID(String rfid){
  unsigned long currentMillis = millis();
  
  if ( currentMillis> watchdog ) {
    previousMillis = currentMillis;
    WiFiClient client;
  
    if (!client.connect(host, port)) {
      //Serial.println("connection failed");
      return;
    }
 
    String url = "/smile/class/teste/postRFID.php?";
    url += "rfid=" + rfid;
    if(qualidade == 1) { // HQ
      url += "&camera_entrada=" + String(camera_entrada);
      url += "&camera_saida="   + String(camera_saida);
    }
    else{
      url += "&camera_entrada=" + String(camera_entrada2);
      url += "&camera_saida="   + String(camera_saida2);
    }
    url += "&identificador="  + String(identificador);
    //url += "&ip=";
    //url += WiFi.localIP().toString();
    //Serial.println(String(host)+url);
    // This will send the request to the server
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0) {
      if (millis() - timeout > 1500) {
        //Serial.println(">>> Client Timeout !");
        client.stop();
        return;
      }
    }
  
    // Read all the lines of the reply from server and print them to Serial
    while(client.available()){
      String line = client.readStringUntil('\r');
      //Serial.print(line);
    }
  }
}

void postPASS(int tipo){
  unsigned long currentMillis = millis();
  
  if ( currentMillis> watchdog ) {
    previousMillis = currentMillis;
    WiFiClient client;
  
    if (!client.connect(host, port)) {
      //Serial.println("connection failed");
      return;
    }
 
    String url = "/smile/class/teste/postPASS.php?";
    url += "tipo=" + String(tipo);
    if(qualidade == 1) { // HQ
      url += "&camera_entrada=" + String(camera_entrada);
      url += "&camera_saida="   + String(camera_saida);
    }
    else{
      url += "&camera_entrada=" + String(camera_entrada2);
      url += "&camera_saida="   + String(camera_saida2);
    }
    //url += "&ip=";
    //url += WiFi.localIP().toString();
    //Serial.println(String(host)+url);
    // This will send the request to the server
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0) {
      if (millis() - timeout > 5000) {
        //Serial.println(">>> Client Timeout !");
        client.stop();
        return;
      }
    }
  
    // Read all the lines of the reply from server and print them to Serial
    while(client.available()){
      String line = client.readStringUntil('\r');
      //Serial.print(line);
    }
  }
}

void iniciaLCD(){
  Wire.begin(SDA_PIN, SCL_PIN); // Muda pinos padrão do I2C, no NodeMCU os pinos são D2 (SDA) e D1 (SCL)
  lcd.init();   // Inicializa o display LCD
  lcd.backlight(); // Habilita luz de fundo do display LCD
  escreveMensagemLCD("Iniciando", "");
}

void escreveMensagemLCD(String linha_1, String linha_2){
  lcd.setCursor (linha_1.length(), 0); // Posiciona o cursor na posição 0 da linha 1
  for (int i = linha_1.length(); i < 16; ++i)
    lcd.write(' '); // Limpa linha 1
  lcd.setCursor (linha_2.length(), 1); // Posiciona o cursor na posição 0 da linha 2
  for (int i = linha_2.length(); i < 16; ++i)
    lcd.write(' '); // Limpa linha 2



  lcd.setCursor(0, 0); // Posiciona o cursor na posição 0 da linha 1
  lcd.print(linha_1); // Escreve mensagem na linha 1 do LCD
  lcd.setCursor(0, 1); // Posiciona o cursor na posição 0 da linha 2
  lcd.print(linha_2); // Escreve mensagem na linha 2 do LCD
}

// Callback que avisa a necessidade de salvar as configurações
void saveConfigCallback () {
  //Serial.println("Deve salvar as configurações");
  shouldSaveConfig = true;
}

// Recupera informações já salvas no sistema de arquivos
void leFS(){
  escreveMensagemLCD("Iniciando", "Lendo FS");
  // Formata FS, para testes
  if(deveResetar)
    SPIFFS.format();

  // Lê configuração do JSON do FS
  //Serial.println("Montando FS");

  if (SPIFFS.begin()) {
    //Serial.println("Sistema de arquivos montado");
    if (SPIFFS.exists("/config.json")) {
      // Arquivo existe, lendo e carregando
      //Serial.println("Lendo arquivo de config");
      File configFile = SPIFFS.open("/config.json", "r");
      if (configFile) {
        //Serial.println("Abriu arquivo de configuração");
        size_t size = configFile.size();
        // Aloca buffer para abrigar conteúdo do arquivo
        std::unique_ptr<char[]> buf(new char[size]);

        configFile.readBytes(buf.get(), size);
        DynamicJsonBuffer jsonBuffer;
        JsonObject& json = jsonBuffer.parseObject(buf.get());
        json.printTo(Serial);
        if (json.success()) {
          escreveMensagemLCD("Iniciando", "Leu FS!");
          //Serial.println("\nJSON parseado");
          strcpy(camera_entrada, json["camera_entrada"]);
          strcpy(camera_saida, json["camera_saida"]);
          strcpy(camera_entrada2, json["camera_entrada2"]);
          strcpy(camera_saida2, json["camera_saida2"]);
          strcpy(identificador, json["identificador"]);
          strcpy(ip_servidor, json["ip_servidor"]);
          strcpy(porta_servidor, json["porta_servidor"]);
          strcpy(qualidadeStr, json["qualidadeStr"]);
        } else {
          //Serial.println("Falhou ao ler JSON de configuração");
          escreveMensagemLCD("Iniciando", "Falha lendo FS");
        }
        configFile.close();
      }
    }
  } else {
    //Serial.println("Falhou ao montar o FS");
    escreveMensagemLCD("Iniciando", "Falha no FS");
  }
  // Termina leitura
}

void printaVariaveisConfiguradas(){
  //Serial.println("IP do servidor:                  "+ String(ip_servidor));
  //Serial.println("Porta do servidor:               "+ String(porta_servidor));
  //Serial.println("ID do dispositivo:               "+ String(identificador));
  //Serial.println("IP da camera de entrada - HQ:    "+ String(camera_entrada));
  //Serial.println("IP da camera de saida - HQ:      "+ String(camera_saida));
  //Serial.println("IP da camera de entrada - LQ:    "+ String(camera_entrada2));
  //Serial.println("IP da camera de saida - LQ:      "+ String(camera_saida2));
  //Serial.println("Qualidade (1 para HQ 0 para LQ): "+ String(qualidadeStr));
}

void preparaWifiEFS(){
  // Inicialização do WifiManager é local, só é preciso dele uma vez.
  leFS();
  WiFiManager wifiManager;

  // Configuração da notificação de callback de salvamento
  wifiManager.setSaveConfigCallback(saveConfigCallback);
  
  // Adicionados os parâmetros
  wifiManager.addParameter(&custom_ip_servidor);
  wifiManager.addParameter(&custom_porta_servidor);
  wifiManager.addParameter(&custom_camera_entrada);
  wifiManager.addParameter(&custom_camera_saida);
  wifiManager.addParameter(&custom_camera_entrada2);
  wifiManager.addParameter(&custom_camera_saida2);
  wifiManager.addParameter(&custom_qualidade);
  wifiManager.addParameter(&custom_identificador);

  //reset settings - for testing
  if(deveResetar)
    wifiManager.resetSettings();

  // recupera SSID e senha salvos e tenta conectar
  // Se não conecta então cria um AP com o nome
  // Fica num loop bloqueante até ser conectado

  escreveMensagemLCD("Tentando conectar","");
  
  if (!wifiManager.autoConnectCustom("SMILE", "projeto2018")) 
    escreveMensagemLCD("Falha de conexao","Configure via AP");
  if(!wifiManager.autoConnect("SMILE", "projeto2018")){
    //Serial.println("Falhou em conectar - timeout");
    escreveMensagemLCD("Timeout","Tente novamente");
    delay(3000);
    //reset e tenta de novo, talvez por em sono profundo
    ESP.reset();
    delay(5000);
  }

  //Serial.println("Conectado ao Wi-Fi, salvando parâmetros");
  escreveMensagemLCD("Conectado ao Wi-Fi","Salvando dados");
  // Lê parâmetros atualizados
  strcpy(camera_entrada, custom_camera_entrada.getValue());
  strcpy(camera_saida, custom_camera_saida.getValue());
  strcpy(camera_entrada2, custom_camera_entrada2.getValue());
  strcpy(camera_saida2, custom_camera_saida2.getValue());
  strcpy(identificador, custom_identificador.getValue());
  strcpy(ip_servidor, custom_ip_servidor.getValue());
  strcpy(porta_servidor, custom_porta_servidor.getValue());
  strcpy(qualidadeStr, custom_qualidade.getValue());

  // Salva os parâmetros novos no FS
  if (shouldSaveConfig) {
    //Serial.println("saving config");
    DynamicJsonBuffer jsonBuffer;
    JsonObject& json = jsonBuffer.createObject();
    json["camera_entrada"] = camera_entrada;
    json["camera_saida"] = camera_saida;
    json["camera_entrada2"] = camera_entrada2;
    json["camera_saida2"] = camera_saida2;
    json["identificador"] = identificador;
    json["ip_servidor"] = ip_servidor;
    json["porta_servidor"] = porta_servidor;
    json["qualidadeStr"] = qualidadeStr;

    File configFile = SPIFFS.open("/config.json", "w");
    if (!configFile) {
      //Serial.println("Falha ao abrir ou escrever arquivo de configuracao");
    }

    json.printTo(Serial);
    json.printTo(configFile);
    configFile.close();
    // Fim do save
  }

  //Serial.println("IP local");
  //Serial.println(WiFi.localIP());

  // Carrega variáveis para memória
  leFS();
  host = ip_servidor;
  port = String(porta_servidor).toInt();
  qualidade = String(qualidadeStr).toInt();
}

void IN(){
    //Serial.println("Entrada");
    escreveMensagemLCD("Entrada","");
    postPASS(2);
    delay(1000);
}

void OUT(){
    //Serial.println("Saída");
    escreveMensagemLCD("Saida","");
    postPASS(3);
    delay(1000);
}

void detectaEntrada(){
  int in = !digitalRead(inPin);
  int out = !digitalRead(outPin);
  if(in){
    IN();
  }
  else if(out){
    OUT(); 
  }
}

bool checaReset(){
  if(analogRead(A0) > 800){
    escreveMensagemLCD("Reset","do dispositivo");
    delay(3000);
    return true;
  }
  else
    return false;
}

void checaBotaoQualidade(){
  if(analogRead(A0) > 800) // deve alterar qualidade da imagem
  {
      qualidade = (qualidade == 1 )? (0) : (1);
      escreveMensagemLCD("Qualidade", (qualidade == 1 )? ("HQ") : ("LQ"));
      delay(2000);
  }
  else
    return;
  
}

void setup() {
  ////Serial.begin(115200);
  iniciaLCD();
  iniciaMFRC();
  deveResetar = checaReset();
  preparaWifiEFS(); 
//  conectaWifi();
  iniciaMFRC();
  mostraMensagemInicial();
  printaVariaveisConfiguradas();
  pinMode(inPin, INPUT);
  pinMode(outPin, INPUT);
}

void loop() { 
  leCartao();
  detectaEntrada();
  checaBotaoQualidade();
  //delay(1000);
}
