<?php
if (isset($_POST["LI"])) $LI= $_POST["LI"]; else $LI ="";
if (isset($_POST["LE"]))  $LE= $_POST["LE"]; else $LE ="";
if (isset($_POST["S"]))  $S= $_POST["S"]; else $S ="";


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

	$conn3 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
	$conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e)
	{
    // Si il y a une erreur, arret du script.
        die('Erreur : '.$e->getMessage());
	}

	$sql = "UPDATE `capteurs` SET `A/M` = '0' WHERE `capteurs`.`id` = 1";
	
    // Prepare statement
    $stmt = $conn->prepare($sql);
	
    // execute the query
	$stmt->execute();

$conn = null;

?>
<html>
	<head>
		<link href="css/hawthorne_type2_color3.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/displayers.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
			<script>
				setTimeout(function () {
	    		window.location.href = "index.php#disp-result";
    			}, 3000);
			</script>
	</head>
	<body>
		<div id="mid-mid">
			<center>
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				<p>Data sent, redirection to the main page in few seconds...<br /><br />
				<div class="radial-timer s-animate">
   					<div class="radial-timer-half"></div>
    				<div class="radial-timer-half"></div>
	  					</div><br /><br /><br />
				The sended data are :<br \>
				<br \><br \>- For Indoor Lights = <?php if ($LI == 'Y') {echo "Turning on the lights";}	elseif ($LI == 'non') {echo "Turning off the lights";} else {echo "Nothing was sent";}?>
				<br \><br \>- For Outdoor Lights = <?php if ($LE == 'Z') {echo "Turning on the lights";}	elseif ($LE == 'wrong') {echo "Turning off the lights";} else {echo "Nothing was sent";}?>
				<br \><br \>- For the blind = <?php if ($S == 'false') {echo "Raising down the blind";} elseif ($S == 'OUV') {echo "Raising up the blind";} else {echo "Nothing was sent";}?></p>
			</center>
		</div>
	</body>
</html>
<?php
if ($LI == 'Y')
	{
	$sql1 = "UPDATE `capteurs` SET `eInt` = '1' WHERE `capteurs`.`id` = 1";
	$stmt = $conn1->prepare($sql1);
	$stmt->execute();
	}
elseif ($LI == 'non')
	{
	$sql2 = "UPDATE `capteurs` SET `eInt` = '0' WHERE `capteurs`.`id` = 1";
	$stmt2 = $conn1->prepare($sql2);
    $stmt2->execute();
	}

//=================================================================================================================================================================================================================
	if ($LE == 'Z')
	{
	$sql3 = "UPDATE `capteurs` SET `eExt` = '1' WHERE `capteurs`.`id` = 1";
	$stmt3 = $conn2->prepare($sql3);
	$stmt3->execute();
	}
	elseif ($LE == 'wrong')
	{
	$sql4 = "UPDATE `capteurs` SET `eExt` = '0' WHERE `capteurs`.`id` = 1";
	$stmt4 = $conn2->prepare($sql4);
	$stmt4->execute();
	}
//=================================================================================================================================================================================================================
	if ($S == 'false')
	{
	$sql5 = "UPDATE `capteurs` SET `Store` = '1' WHERE `capteurs`.`id` = 1";
	$stmt5 = $conn3->prepare($sql5);
	$stmt5->execute();
	}
elseif ($S == 'OUV')
	{
	$sql6 = "UPDATE `capteurs` SET `Store` = '0' WHERE `capteurs`.`id` = 1";
	$stmt6 = $conn3->prepare($sql6);
	$stmt6->execute();
	}

	//$stmt = $conn->prepare($sql);
	//$stmt->execute();
?>
