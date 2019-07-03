<?php

include 'database.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$conn1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// Connection MySQL for imgs displaying.
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	}
	catch(Exception $e)
	{
    // Si il y a une erreur, arret du script.
        die('Erreur : '.$e->getMessage());
	}

    $sql = "UPDATE `capteurs` SET `A/M` = '1' WHERE `capteurs`.`id` = 1";

    // Prepare statement
    $stmt = $conn->prepare($sql);
	
    // execute the query
	$stmt->execute();

$conn = null;

//Simulation of Arduino sensors reception
$randl = rand(0, 9999);
$randw = rand(0, 50);

//send generated numbers to database
$sql1 = "UPDATE `capteurs` SET `lux` = '$randl' WHERE `capteurs`.`id` = 1";
$stmt = $conn1->prepare($sql1);
$stmt->execute();

$sql2 = "UPDATE `capteurs` SET `vent` = '$randw' WHERE `capteurs`.`id` = 1";
$stmt2 = $conn2->prepare($sql2);
$stmt2->execute();
?>
<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<!-- En tête du site -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Slegpi - Projet SIN 2018</title>
		<meta name="description" content="SLEGPI">
		<link href="css/hawthorne_type2_color3.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/displayers.css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<script src="js/vendor/modernizr.js"></script>
			<script>
				setTimeout(function () {
	    		window.location.href = "auto.php";
    			}, 5000);
			</script>
		<div class="row">
	<div class="small-12 medium-12 large-12 small-centered columns">
		<header>		
				<a href="index.php">
						<center>
							<img src="img/logo_slegpi.png"  width="328", height="100%" align="center" /><br />
						</center>
				</a>
			</h1>
			<h2 class="slogan">
				<a href="index.php">Stores et Lumières Electriques Gérés Par Informatique</a>
			</h2>
		</header>
	</div>
	<div class="small-12 medium-12 large-12 small-centered columns">
		<nav>
			<ul class="inline-list-custom">
				<li><a href="index.php" class="current">Use the system</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="https://junkjumper.github.io/SLEGPI/">Back to the presentation page</a></li>							
			</ul>
		</nav>
	</div>
</div>
	</head>
<body>
<div class="row">
	<div class="small-12 medium-12 large-12 columns">
		<ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-3 inline-list-custom">


            			<!-- Début Case 1 -->
						<li>
				<div class="thumbnail">
					<div class="thumbnail-img">
							<?php
							$etateInt = $bdd->query('SELECT `lux` FROM `capteurs` WHERE id=1');
							$result = $etateInt->fetch();
							$count = $result[0];
							if ($count < 3000)
							{
							echo '<img src="img/allume.png" Lumières Intérieures Allumées" width="50%" height="100px">';
							}
							else
							{
							echo '<img src="img/eteint.png" alt="Lumières Intérieures Eteintes" width="30%" height="100px">';
							} 
							?>
						<div class="thumbnail-caption">
						<p>Position of the blind</p>
						</div>
					</div>
				</div>
			</li>
						<!-- FIN Case 1 -->

            			<!-- Début Case 2 -->
						<li>
				<div class="thumbnail" id="disp-result1">
					<div class="thumbnail-img">
							<?php
							$etatStore = $bdd->query('SELECT `vent` FROM `capteurs` WHERE id=1');
							$result2 = $etatStore->fetch();
							$count2 = $result2[0];
							if ($count2 < 30)
							{
							echo '<img src="img/monte.png" alt="Store en position Haute" width="50%" height="100px">';
							}
							else
							{
							echo '<img src="img/descendu.png" alt="Store en position Basse" width="50%" height="100px">';
							} 
							?>
						<div class="thumbnail-caption">
						<p>State of the Outdoor Lights</p>
						</div>
					</div>
				</div>
			</li>
						<!-- FIN Case 2 -->


            			<!-- Début Case 3 -->
			<li>
				<div class="thumbnail">
					<div class="thumbnail-img">
							<?php
							$etateExt = $bdd->query('SELECT `lux` FROM `capteurs` WHERE id=1');
							$result1 = $etateExt->fetch();
							$count1 = $result1[0];
							if ($count1 < 3000)
							{
							echo '<img src="img/allume.png" Lumières Extérieures Allumées" width="50%" height="100px">';
							}
							else
							{
							echo '<img src="img/eteint.png" alt="Lumières Extérieures Eteintes" width="30%" height="100px">';
							} 
							?>
						<div class="thumbnail-caption">
						<p>State of the Outdoor Lights</p>
						</div>
					</div>
				</div>
			</li>
						<!-- FIN Case 3 -->


            			<!-- Début Case 4 -->
			<li>
				<div class="thumbnail" id="rl-lux">
					<div class="thumbnail-img">
						<iframe src="display-lux.php" style="border:0px #ffffff hidden;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="120px" width="328px" allowfullscreen></iframe>
					</div>
						<div class="thumbnail-caption">
						<p>Amount of light (in µW/cm²)</p>
						</div>
				</div>
			</li>
						<!-- FIN Case 4 -->

            			<!-- Début Case 5 -->
						<li>
				<div class="thumbnail">
						<div class="thumbnail-img">
	                    	<br />
								<a href="index.php#disp-result"><img src="img/auto/on.png" border="0" id="send" width="280", height="100%" /></a>
						</div>
						<div class="thumbnail-caption"><a href="auto.php">Automatic Mode</a></div>
				</div>
			</li>
						<!-- FIN Case 5 -->

            			<!-- Début Case 6 -->
						<li>
				<div class="thumbnail" id="rl-wind">
					<div class="thumbnail-img">
						<iframe src="display-vent.php" style="border:0px #ffffff hidden;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="120px" width="328px" allowfullscreen></iframe>
					</div>
						<div class="thumbnail-caption">
						<p>Wind Speed (km/h)</p>
						</div>
				</div>
			</li>
						<!-- FIN Case 6 -->
		</ul>
	</div>
</div>
</body>
<footer>
	<div>
	<div>
			<ul>
				<li>&copy; 2018 <a href="index.php">SLEGPI</a>. Projet SIN 2017/2018.</li>
				<li><br /><a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a> This page is available under the terms of the <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"> Creative Commons Attribution 4.0 International License</a>.</p></li>
				<li><a href="mailto:contact@junkjumper-projects.com"><i class="fa fa-envelope-o"></i>contact@junkjumper-projects.com</a></li>
			</ul>
		</div>
	</div>
</footer>
</html>
