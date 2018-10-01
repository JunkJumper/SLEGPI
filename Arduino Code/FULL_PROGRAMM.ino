#include <SPI.h>
#include <Ethernet.h>
#include <math.h>
#include <Servo.h>
#define WindSensorPin (2)


volatile unsigned long Rotations;
volatile unsigned long ContactBounceTime;

unsigned long duration;

float WindSpeed;
float T = 0;

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xD4, 0x22}; // @Arduino Ethernet
byte ip[] = {10, 66, 240, 59};

char server[] = "10.66.240.81"; // @PC

String readString;
boolean drapeau = false;


int D;
int LE;
int LI;
int S;
int AM;
char c;
int pin = 9;
int position = 0;

int F = 1 / T;
int Led = 7;
int bLed = 3;
int gLed = 4;
int rLed = 6;
int ST;

EthernetClient client;

void setup()
{
  pinMode(pin, INPUT);
  pinMode(bLed, OUTPUT);
  pinMode(gLed, OUTPUT);
  pinMode(rLed, OUTPUT);
  pinMode(Led, OUTPUT);
  monServomoteur.attach(8);
  Serial.begin(9600); // mise en marche liaison série
  //Ethernet.begin(mac, ip);
  if (Ethernet.begin(mac) == 0)
  {
    Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    for (;;)
      ;
  }
  delay(2000);
  Serial.println("connecting...");
}

void loop()
{
  //Luxmetre
  delay(500);
  duration = pulseIn(pin, HIGH);
  T = 2 * duration;
  Serial.print("Luminosite (lux): ");
  F = 1000000 * 1 / T;
  Serial.println(F, DEC);
  //Anemometre
  Rotations = 0;
  sei();
  delay(3000);
  cli();
  WindSpeed = (Rotations * 0.75) * 1.609344;
  Serial.print(Rotations);
  Serial.print("\t\t");
  Serial.println(WindSpeed);

  envoieBDD();
  LectureBDD();
  Traitement();
}

void isr_rotation()
{

  if ((millis() - ContactBounceTime) > 15)
  { // debounce the switch contact.
    Rotations++;
    ContactBounceTime = millis();
  }
}

void envoieBDD()
{
  if (client.connect(server, 80))
  {
    Serial.println("connected");
    client.print("GET /SLEGPI/ecriture.php?lux=");
    client.print(F);
    client.println(" HTTP/1.1");
    client.println("Host: 10.66.240.81");
    Serial.println(F);
    Serial.println("Connection: close");
    client.println();
    client.stop();
    client.println();
  }
  else
  {
    Serial.println("connection failed");
  }

  if (client.connect(server, 80))
  {
    Serial.println("connected");
    client.print("GET /SLEGPI/ecriture.php?vent=");
    client.print(WindSpeed);
    client.println(" HTTP/1.1");
    client.println("Host: 10.66.240.81");
    //Serial.println(F);
    Serial.println("Connection: close");
    client.println();
    client.stop();
    client.println();
  }
  else
  {
    Serial.println("connection failed");
  }
}

void LectureBDD()
{
  EthernetServer server(80);
  server.available();
  EthernetClient client = server.available();
  if (client)
  {
    Serial.println("attente serveur");
    while (client.connected())
    {
      client.println("z");       //pour la connexion
      while (client.available()) // Not if - you want to read all the data
      {
        char c = client.read(); //lecture caractère par caractère
        //on concatène les caractères et on ne sélectionne qu'un string total de longueur < 40
        if (readString.length() < 40)
          readString.concat(c);
        // détection de fin de ligne
        if (c == '\n')
        {
          Serial.println(readString); //écriture des 40 caractères dans le terminal série
          // index des recherches des mots "ON" et "OUV" dans la chaine readString
          // si absent alors =-1
          LI = readString.indexOf('Y');
          LE = readString.indexOf('Z');
          S = readString.indexOf('OUV');
          AM = readString.indexOf('WW');
          readString = ""; //initialisation de la variable chaîne readString
          client.stop();   //deconnection de l'arduino
          Serial.println();
        }
      }
    }
  }
}

void Traitement()
{
  if (AM > 0)
  {
    Serial.println("Mode automatique");

    if (F < 1000)
    {
      digitalWrite(bLed, HIGH);
      digitalWrite(gLed, HIGH);
      digitalWrite(rLed, HIGH);
      digitalWrite(Led, LOW);
      if (drapeau == true)
      {
        drapeau = false;
        position = 0;
        monServomoteur.write(position);
        delay(15);
      }
      D = 1;
      ST = 0;
      //allumer

      if (client.connect(server, 80))
      {
        Serial.println("connected");
        Serial.println("toto");
        client.print("GET /SLEGPI/ecriture.php?eInt=");
        client.print(D);
        Serial.println(D);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(F);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
      else
      {
        Serial.println("connection failed");
      }
      if (client.connect(server, 80))
      {
        Serial.println("connected");
        client.print("GET /SLEGPI/ecriture.php?eExt=");
        client.print(D);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(1);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
      if (client.connect(server, 80))
      {
        Serial.println("connected");
        client.print("GET /SLEGPI/ecriture.php?Store=");
        client.print(ST);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(1);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
    }

    if (F > 1000)
    {
      digitalWrite(bLed, LOW);
      digitalWrite(gLed, LOW);
      digitalWrite(rLed, LOW);
      digitalWrite(Led, HIGH);
      if (drapeau == false)
      {
        drapeau = true;
        for (int position = 0; position <= 180; position++)
        {
          monServomoteur.write(position);
          delay(15);
        }
      }
      D = 0;
      ST = 1;
      //et
      if (client.connect(server, 80))
      {
        Serial.println("connected");
        Serial.println("toto");
        client.print("GET /SLEGPI/ecriture.php?eInt=");
        client.print(D);
        Serial.println(D);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(F);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
      else
      {
        Serial.println("connection failed");
      }
      if (client.connect(server, 80))
      {
        Serial.println("connected");
        client.print("GET /SLEGPI/ecriture.php?eExt=");
        client.print(D);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(1);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
      if (client.connect(server, 80))
      {
        Serial.println("connected");
        Serial.println("toto");
        client.print("GET /SLEGPI/ecriture.php?Store=");
        client.print(ST);
        Serial.println(D);
        client.println(" HTTP/1.1");
        client.println("Host: 10.66.240.81");
        Serial.println(F);
        Serial.println("Connection: close");
        client.println();
        client.stop();
        client.println();
      }
    }
  } //Allumer les lumieres exterieurs
  else
  {
    Serial.println("Mode manuel");
    //Eteindre les lumieres exterieurs

    if (LI > 0)
    {
      digitalWrite(Led, LOW);
    } //Allumer les lumieres exterieurs
    else
    {
      digitalWrite(Led, HIGH);
    } //Eteindre les lumieres exterieurs

    if (LE > 0)
    {
      digitalWrite(bLed, HIGH);
      digitalWrite(gLed, HIGH);
      digitalWrite(rLed, HIGH);
    } //Allumer les lumieres exterieurs
    else
    {
      digitalWrite(bLed, LOW);
      digitalWrite(gLed, LOW);
      digitalWrite(rLed, LOW);
    } //Eteindre les lumieres exterieurs

    if (S > 0)
    {
      if (drapeau == false)
      {
        drapeau = true;
        for (int position = 0; position <= 180; position++)
        {
          monServomoteur.write(position);
          delay(15);
        }
      }
    }
    //Monter le Store
    else
    {

      if (drapeau == true)
      {
        drapeau = false;
        position = 0;
        monServomoteur.write(position);
        delay(15);
      }
    }
  } //Baisser le Store
}
