#include <ESP8266WiFi.h>            //Incluye la libreria de WiFi
WiFiClient client;                  // Crea un objeto cliente
char ssid[] = "Nombre de mi WiFi";  // Mi Red
char password[] = "kaitiroweb3415"; // Password de Red
byte mac[6];                        // = {0xA6, 0x1A, 0x48, 0x91, 0x02, 0x50} ;                   //MAC de la placa de desarrollo

#include <MySQL_Connection.h>             //Incluye la libreria de MySQL
#include <MySQL_Cursor.h>                 //Incluye la libreria de MySQL
MySQL_Connection conn((Client *)&client); // Crea un objeto de conexion a MySQL
// Sentencia SQL DaseDeDatos.Tabla(columnas)valores(%formato)
char INSERT_SQL[] = "INSERT INTO kaitiro.registros(contador,valor,dispositivo) VALUES ('%u','%u','%s')";
char query[128]; // Crea una cadena de caracteres de 128 caracteres
// Primary Domain  cks.com.co
// Shared IP Address 34.232.192.154

IPAddress server_addr(192, 168, 0, 8); // MySQL server IP
char db_user[] = "admin";              // MySQL user
char db_password[] = "Cks+0002";       // MySQL password

const int buttonPin = D2; // pin de entrada que lee el contactor
int buttonState = 0;      // inicializacion de la variable que define el estado del boton

void setup()
{

  Serial.begin(115200);           // iniciamos el monitor serial
  pinMode(buttonPin, INPUT);      // configuramos el pin de entrada
  Serial.print("Connecting to "); // imprimimos en el monitor serial
  Serial.println(ssid);           // imprimimos en el monitor serial el nombre de la red

  WiFi.begin(ssid, password); // se inicia la conexion al wifi

  while (WiFi.status() != WL_CONNECTED) // mientras no se conecte a la red
  {
    delay(500);        // esperamos 500 milisegundos
    Serial.print("."); // imprimimos en el monitor serial un punto
  }
  Serial.println("");               // imprimimos en el monitor serial un salto de linea
  Serial.println("WiFi connected"); // imprimimos en el monitor serial que se conecto a la red
  Serial.print("IP address: ");     // imprimimos en el monitor serial
  Serial.println(WiFi.localIP());   // imprimimos en el monitor serial la direccion IP local
  WiFi.macAddress(mac);             // obtenemos la direccion MAC de la placa
  Serial.print("MAC: ");            // imprimimos en el monitor serial la direccion MAC de la placa
  Serial.print(mac[5], HEX);
  Serial.print(":");
  Serial.print(mac[4], HEX);
  Serial.print(":");
  Serial.print(mac[3], HEX);
  Serial.print(":");
  Serial.print(mac[2], HEX);
  Serial.print(":");
  Serial.print(mac[1], HEX);
  Serial.print(":");
  Serial.println(mac[0], HEX);
  Serial.println("");

  Serial.println("Connecting to mysql server");                         // imprimimos en el monitor serial que se conecto a la red
  while (conn.connect(server_addr, 3306, db_user, db_password) != true) // se hace la conexion a la base de datos
  {
    delay(200);        // esperamos 200 milisegundos
    Serial.print("."); // imprimimos en el monitor serial un punto
  }
  Serial.println("");                           // imprimimos en el monitor serial un salto de linea
  Serial.println("Connected to mysql server!"); // imprimimos en el monitor serial que se conecto a la red
  ESP.wdtEnable(WDTO_8S);                       // habilita el watchdog de 8 segundos
}
int valor = 0;              // inicializamos las variables que se van a escribir en la base de datos
char dispositivo[] = "099"; // inicializamos las variables que se van a escribir en la base de datos
int contador = 0;

void loop()
{

  buttonState = digitalRead(buttonPin); // leemos el estado del contactor
  if (buttonState == HIGH)
  {
    Serial.println("Boton Encendido"); // si esta encendido nos lo indica e el monitor serial
  }
  if (buttonState == LOW)
  {
    Serial.println("Boton Apagado"); // si esta apagado nos lo indica en el monitor serial
  }

  if (buttonState == HIGH)
  {            // verifica nuevamente el estado del boton
    valor = 1; // guarda el dato anterior en la variable designada para que ser almacenada en la base de datos
  }
  else
  {
    valor = 0; // guarda el dato anterior en la variable designada para que ser almacenada en la base de datos
  }

  sprintf(query, INSERT_SQL, contador, valor, dispositivo); // escribe en el monitor serial los datos a subir en la base de datos
  Serial.println("Recording data.");                    // imprimimos en el monitor serial que se esta registrando los datos

  Serial.println(query);                              // imprimimos en el monitor serial la sentencia SQL
  MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn); // sube los datos a la BD
  cur_mem->execute(query);                        // sube los datos a la BD

  delay(49999); // 60 segundos de espera para evitar saturar la base de datos (no requerimos detalle seg a seg)
  delete cur_mem; // elimina el cursor
  contador++; // incrementa el contador para efectos de control
  if (contador > 5) // si el contador es mayor a 5
  {
    ESP.restart();  // reinicia el ESP
  };

  // nonBlock(10000); // period from 1 to 64.000 ms like delay(10000)
}

// void nonBlock(uint16_t period)
//{
//  uint32_t time_now = millis();
//  while(millis()  <  time_now + period)
//  {
//   wdt_reset();    //waiting!
//  }
// }
