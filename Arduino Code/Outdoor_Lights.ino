unsigned long duration;
float T = 0;

int bLed = 3;
int gLed = 4;
int rLed = 6;
int pin = 9;
int F = 1/T;

void setup()
{
  // put your setup code here, to run once:
  pinMode(pin, INPUT);
  Serial.begin(9600);
  pinMode(bLed, OUTPUT);
  pinMode(gLed, OUTPUT);
  pinMode(rLed, OUTPUT);
}

void loop()
{
  // put your main code here, to run repeatedly:
  delay(1000);
  duration = pulseIn(pin, HIGH);
  T = 2 * duration;
  Serial.print("F: ");
  F = 1000000 * 1 / T;
  Serial.println(F, DEC);

  if (F < 1000)
  {
    digitalWrite(bLed, HIGH);
    digitalWrite(gLed, HIGH);
    digitalWrite(rLed, HIGH);
    delay(1000);
  }

  if (F > 1000)
  {
    digitalWrite(bLed, LOW);
    digitalWrite(gLed, LOW);
    digitalWrite(rLed, LOW);
    delay(1000);
  }
}
