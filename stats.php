<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Stats</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="libraries/jQuery.js"></script>
	<script src="libraries/bootstrap.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
	<?php
	session_start();
	if (!empty($_SESSION["username"])) {
		include 'functions/connect.php';
		$date = ($_GET["year"]."-".$_GET["month"]."-".$_GET["day"]);
		$date = date("Y-m-d", strtotime($date));
		$day = $_GET["day"];
		$month = $_GET["month"];
		$year = $_GET["year"];
		$days_in_month_total = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$display_days_loop = $days_in_month_total;
		$display_days = 0;
		echo "
		<div class='container-fluid'>";
			include 'navigation.php';
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Stats</h4>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-4'>
					<div class='well text-center'>
						<a href='stats.php?day=1&month=".date('n', mktime(0, 0, 0, $month -1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month -1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month -1, 1, $year))."</a>
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='well text-center'>
						<strong>".date('F Y', mktime(0, 0, 0, $month, 1, $year))."</strong>
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='well text-center'>
						<a href='stats.php?day=1&month=".date('n', mktime(0, 0, 0, $month +1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month +1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month +1, 1, $year))."</a>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
					<div class='table-responsive'>
						<div class='table_fix'>
							<table class='table'>
								<tr>
									<td class='guides_schedule_cell_available_guides'>Departures</td>";
									while ($display_days_loop > 0) {
										$display_days++;
										$maketime = mktime(0, 0, 0, $month, $display_days, $year);
										$day1 = date("D", $maketime);
										$day1 = substr($day1, 0, 1);
										$day2 = date("Y-m-d", $maketime);
										if ($day1 == "S") {
											if ($day2 == date("Y-m-d")) {
												echo "<td class='guides_schedule_cell_navigation_by_day_weekend_today'>";						
											} else {
												echo "<td class='guides_schedule_cell_navigation_by_day_weekend'>";						
											}
										} else {
											if ($day2 == date("Y-m-d")) {
												echo "<td class='guides_schedule_cell_navigation_by_day_today'>";
											} else {
												echo "<td class='guides_schedule_cell_navigation_by_day'>";
											}
										}
										echo "
										$display_days</td>";
										$display_days_loop--;
									}
									echo "
								</tr>";
								$GetTripsQueryDate = date("m",mktime(0, 0, 0, $month, $day, $year));
								$GetTripsQuery = mysqli_query($connect,"SELECT DailyDiaryTripID, DiaryDate, TripID, TripDepartureTime, ClientTotal, Cancel FROM daily_diary_trips WHERE MONTH(DiaryDate) = '$GetTripsQueryDate' AND YEAR(DiaryDate) = '$year' AND Operator = '".$_SESSION["operator"]."'");
								$GetTripsNumRows = mysqli_num_rows($GetTripsQuery);
								while($row = mysqli_fetch_assoc($GetTripsQuery)) {
									$trips[] = $row;
								}
								if ($GetTripsNumRows > 0) {
									include 'functions/stats/stats_trip.php';
									foreach ($TripsForStats as $TripStats) {
										$TripDepartureTime = substr($TripStats["TripDepartureTime"], 0, -3);
										stats_trip($TripStats["TripID"],$TripDepartureTime);
									}
									echo "
								</tr>";
								include 'stats/stats_daily_total.php';
								echo "
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-4'>
					<div class='well'>
						<div class='stats_cancelled'>
						</div>
						Cancelled
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='well'>
						<div class='stats_booked'>
						</div>
						Clients Booked
					</div>		
				</div>
				<div class='col-sm-4'>
					<div class='well'>
						<div class='stats_soldout'>
						</div>
						Sold Out
					</div>
				</div>
			</div>";
			include 'stats/stats_per_trip_monthly_total.php';
			include 'stats/stats_monthly_total.php';
		}
	} else {
		header('Location: index.php');
	}
	?>