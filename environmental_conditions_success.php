<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Daily Agenda</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="libraries/jQuery.js"></script>
<script src="libraries/bootstrap.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<?php
session_start();
echo "<div class='container-fluid'>";
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	include 'functions/connect.php';
	$rain = $_POST["rain"];
	$wind = $_POST["wind"];
	$ice = $_POST["ice"];
	$temperature = $_POST["temperature"];
	$forecast = $_POST["forecast"];
	$date = $_POST["date"];
	$time = $_POST["time"];
	
	if ($time == "AM") {
		$insert_environmental_conditions = mysqli_query($connect, "INSERT INTO environmental_conditions (Date, Time, Rain, Wind, Ice, Temperature, Forecast, Operator) VALUES ('$date', '$time', '$rain', '$wind', '$ice', '$temperature', '$forecast', '".$_SESSION["operator"]."') ON DUPLICATE KEY UPDATE Date = '$date', Time = '$time', Rain = '$rain', Ice = '$ice', Wind = '$wind', Temperature = '$temperature', Forecast = '$forecast', Operator = '".$_SESSION["operator"]."'");
	} else {
		$insert_environmental_conditions = mysqli_query($connect, "INSERT INTO environmental_conditions (Date, Time, Rain, Wind, Ice, Temperature, Forecast, Operator) VALUES ('$date', '$time', '$rain', '$wind', '$ice', '$temperature', '$forecast', '".$_SESSION["operator"]."') ON DUPLICATE KEY UPDATE Date = '$date', Time = '$time', Rain = '$rain', Ice = '$ice', Wind = '$wind', Temperature = '$temperature', Forecast = '$forecast', Operator = '".$_SESSION["operator"]."'");
	}
	
	echo "
	<div class='well'>
		<h4>Environmental conditions saved!</h4>
	</div>";
} else {
	echo "not logged in";	
}
?>
</body>
</html>