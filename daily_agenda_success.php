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
	$date = ($_GET["year"]."-".$_GET["month"]."-".$_GET["day"]);
	$date = date("Y-m-d", strtotime($date));
	$day = $_GET["day"];
	$month = $_GET["month"];
	$year = $_GET["year"];
	if (isset($_POST['delete_agenda'])) {
		$delete_agenda_date = $_POST['delete_agenda'];
		$delete_agenda_query = mysqli_query($connect, "DELETE FROM daily_diary_trips WHERE DiaryDate = '$delete_agenda_date' AND Operator = '".$_SESSION["operator"]."'");
		$delete_guides_query = mysqli_query($connect, "DELETE FROM daily_diary_guides WHERE DailyDiaryTripID LIKE '%$delete_agenda_date' AND Operator = '".$_SESSION["operator"]."'");
		echo "
		<div class='well'>
			<h4>Daily agenda successfully deleted!</h4>
		</div>";
	} else {
		include 'functions/daily_agenda/daily_agenda_submit.php';
		if ($error_message != "false") {
			echo "
			<div class='well'>
				<h4>$error_message</h4>
			</div>";
		} else {
			echo "
			<div class='well'>
				<h4>Daily agenda successfully saved!</h4>
			</div>";
		}
	}
} else {
	echo "not logged in";	
}
?>
</body>
</html>