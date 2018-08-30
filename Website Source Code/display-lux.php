<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "database";
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
?>
<!DOCTYPE html>
<html lang="fr" >
	<head>
		<link href="css/display-lux.css" rel="stylesheet">
	</head>
	<body>
		<div class="displ-rl" id=lux>
			<text>
	 			<?php
					while ($donnees = $reponse->fetch())
					{
						echo $donnees['lux'] . '<br />';
					}
					$reponse->closeCursor();
				?>
			</text>
		</div>
	</body>
</html>