int pin = 10;
unsigned long duration;
float T = 0;
int F = 1/T;
int led = 9;
int BLUE = 6;                   
int GREEN = 3; 
int RED = 5; 
int brightness1 = 200;
int brightness2 = 255;
int brightness3 = 255;
int brightness4 = 0;
int brightness5 = 0;
int brightness6 = 0;

void setup()
{
  pinMode(pin, INPUT);
  pinMode(led, OUTPUT);
  Serial.begin(9600);
  digitalWrite(led, LOW);
}

void loop()
{
  delay(1000);
  duration = pulseIn(pin, HIGH);
T = 2*duration;
Serial.print("Luminosite (lux): ");
F = 1000000*1/T;
Serial.println(F, DEC);

if (F >= 500)
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
}

