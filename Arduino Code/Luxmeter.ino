unsigned long duration;
float T = 0;

int pin = 10;
int F = 1/T;
int led = 9;
int BLUE = 6;                   
int GREEN = 3; 
int RED = 5; 
int lum1 = 255;
int lum0 = 0;

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
    analogWrite(RED, lum0);
    analogWrite(GREEN, lum0);
    analogWrite(BLUE, lum0);
  }
  else
  {
    digitalWrite(led, LOW);
    analogWrite(RED, lum1);
    analogWrite(GREEN, lum1);
    analogWrite(BLUE, lum1);
  }
}