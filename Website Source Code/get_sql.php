<?php

include 'database.php';



	try
	{
// Connection MySQL.
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
}
catch(Exception $e)
{
    // Si il y a une erreur, arret du script.
        die('Erreur : '.$e->getMessage());
}
// Récupération du contenu de la table capteurs
$reponse = $bdd->query('SELECT lux FROM capteurs WHERE id=1');

while ($donnees = $reponse->fetch())
{
	echo $donnees['lux'] . '<br />';
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>