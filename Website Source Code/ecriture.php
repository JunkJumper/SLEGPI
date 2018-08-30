<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "database";
echo"test mysql";
if (isset($_GET['vent']))   
{
$vent=$_GET['vent']; 
$connexion=mysql_connect($host,$user,$pass) OR die('<p>Connexion impossible à la base de données</p>');
mysql_select_db($bdd);

$query = "UPDATE capteurs SET vent='$vent' WHERE id =1"; 
	  $result = mysql_query($query);	
	  } 
	  else $vent="vide";
	  
  
echo"test mysql";
if (isset($_GET['lux']))   
{
$lux=$_GET['lux']; 
$connexion=mysql_connect($host,$user,$pass) OR die('<p>Connexion impossible à la base de données</p>');
mysql_select_db($bdd);
$query = "UPDATE capteurs SET lux='$lux' WHERE id =1"; 
	  $result = mysql_query($query);	
	  } 
	  else $lux="vide";

echo"test mysql";
if (isset($_GET['eInt']))   
{
$eInt=$_GET['eInt']; 
$connexion=mysql_connect($host,$user,$pass) OR die('<p>Connexion impossible à la base de données</p>');
mysql_select_db($bdd);
$query = "UPDATE capteurs SET eInt='$eInt' WHERE id =1"; 
	  $result = mysql_query($query);	
	  } 
	  else $eInt="vide";

echo"test mysql";
if (isset($_GET['eExt']))   
{
$eExt=$_GET['eExt']; 
$connexion=mysql_connect($host,$user,$pass) OR die('<p>Connexion impossible à la base de données</p>');
mysql_select_db($bdd);
$query = "UPDATE capteurs SET eExt='$eExt' WHERE id =1"; 
	  $result = mysql_query($query);	
	  } 
	  else $eExt="vide";

echo"test mysql";
if (isset($_GET['Store']))   
{
$Store=$_GET['Store']; 
$connexion=mysql_connect($host,$user,$pass) OR die('<p>Connexion impossible à la base de données</p>');
mysql_select_db($bdd);
	  $query = "UPDATE capteurs SET Store='$Store' WHERE id =1"; 
	  $result = mysql_query($query);	
	  } 
	  else $Store="vide";
?>