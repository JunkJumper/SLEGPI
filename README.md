# SLEGPI-Website
[![Build Status](https://travis-ci.org/JunkJumper/SLEGPI.svg?branch=master)](https://travis-ci.org/JunkJumper/SLEGPI)
SLEGPI is my project for my exams of june 2018. I have work on it from October 2017 to May 2018.

In what consist SLEGPI-Website ?

First, SLEGPI mean in french "Electrical blind and Lights Piloted by Informatic" ("Store Electrique Géré Par Informatique" is the full french name)

So My project consist to Pilote with a website a Venician blind and 2 lights with a website. This website is hosted on a Raspberry Pi 3 (the raspberry is the server). The Server have a MySQL database and when the binaries values on the database changes, an arduino card execute an action (turn on/off the lights or raising up/down the venician blind).

Here is all the files of my project that are hosted on the Raspberry Pi 3.

To Work, the card need to have Apache, PHP5 and MySQL Database (with PDO function) package (In other words, it need LAMP). 

A database must execute the captbdd.sql file to make the project works.
