#include <SPI.h>
#include <Ethernet.h>
#include <math.h>
#define WindSensorPin (2)
volatile unsigned long Rotations;
volatile unsigned long ContactBounceTime; 
float WindSpeed; 
int pin = 9;
unsigned long duration;
float T = 0;
int F = 1/T;
int led = 8;
int BLUE = 6;                   
int GREEN = 3; 
int RED = 5; 
int brightness1 = 200;
int brightness2 = 255;
int brightness3 = 255;
int brightness4 = 0;
int brightness5 = 0;
int brightness6 = 0;
 EthernetClient client;
byte mac[] = { 0x90, 0xA2, 0xDA, 0x0E, 0xD4, 0x22 }; 
byte ip[] = { 192, 168, 1, 102 }; //ip arduino
char server[] = "192.168.1.101"; //ip raspberry

void setup() { 

    pinMode(WindSensorPin, INPUT);
attachInterrupt(digitalPinToInterrupt(WindSensorPin), isr_rotation, FALLING);

Serial.println("Rotations\tKm/h");

   pinMode(led, OUTPUT);
   pinMode(pin, INPUT);
   Serial.begin(9600);
   digitalWrite(led, LOW);

  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    for(;;)
      ;
  }
  delay(500);
  Serial.println("connecting...");
}

void loop() {
  
  //luxmetre
  delay(500);
  duration = pulseIn(pin, HIGH);
T = 2*duration;
Serial.print("Luminosite (lux): ");
F = 1000000*1/T;
Serial.println(F, DEC);
if (F >= 1000)
{
  digitalWrite(led, HIGH);
  analogWrite(RED, brightness4);
  analogWrite(GREEN, brightness5);
  analogWrite(BLUE, brightness6);
}
else
{
  digitalWrite(led, LOW);
  analogWrite(RED, brightness1);
  analogWrite(GREEN, brightness2);
  analogWrite(BLUE, brightness3);
}
  
  if (client.connect(server, 80)) {
    Serial.println("connected");
     client.print("GET /SLEGPI/ecriture.php?lux="); 
     client.print(F);
     client.println(" HTTP/1.1");
     client.println("Host: 192.168.1.101"); 
     //Serial.println(F);  
   Serial.println( "Connection: close" );
    client.println();
    client.stop();   
    client.println();
  }
  else {
    Serial.println("connection failed");
  }
delay(500);

  //anémometre
Rotations = 0;
sei();
delay (3000);
cli();
WindSpeed = (Rotations * 0.75) * 1.609344;
Serial.print(Rotations); Serial.print("\t\t");
Serial.println(WindSpeed);

  if (client.connect(server, 80)) {
    Serial.println("connected");
     client.print("GET /SLEGPI/ecriture.php?vent="); 
     client.print(WindSpeed);
     client.println(" HTTP/1.1");
     client.println("Host: 192.168.1.101"); 
     //Serial.println(F);  
   Serial.println( "Connection: close" );
    client.println();
    client.stop();   
    client.println();
  }
   else {
    Serial.println("connection failed");
  }
  }
void isr_rotation () {

if ((millis() - ContactBounceTime) > 15 ) { // debounce the switch contact.
Rotations++;
ContactBounceTime = millis();
}
}
