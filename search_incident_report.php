<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Search Incident Report</title>
<?php include 'functions/meta_links.php';?>
<link rel='stylesheet' href='functions/date_picker/css/pikaday.css'>
<script src='functions/date_picker/pikaday.js'></script>
<script src='libraries/validator/js/validator.js'></script>
</head>
<body>
<?php
session_start();
echo "<div class='container-fluid'>";
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	include 'functions/connect.php';
	$step = $_GET['step'];
	echo "
	<div class='row'>
		<div class='col-sm-12'>
			<div class='well'>
				<h4>Search for Incident Report Form</h4>
			</div>
		</div>
	</div>";
	if ($step == "3") {
		$start_date = $_POST['start_date'];
		$start_date_day = substr($start_date,8,2);
		$start_date_month = substr($start_date,4,3);
		$start_date_month = date("m", strtotime($start_date_month));
		$start_date_year = substr($start_date,11,4);
		$start_date = date("Y-m-d", mktime(0,0,0,$start_date_month,$start_date_day,$start_date_year));
		$end_date = $_POST['end_date'];	
		$end_date_day = substr($end_date,8,2);
		$end_date_month = substr($end_date,4,3);
		$end_date_month = date("m", strtotime($end_date_month));
		$end_date_year = substr($end_date,11,4);
		$end_date = date("Y-m-d", mktime(0,0,0,$end_date_month,$end_date_day,$end_date_year));
		$GetIncidentReportsQuery = mysqli_query($connect,"SELECT * FROM incident_reports WHERE Operator = '".$_SESSION["operator"]."' AND IncidentDate BETWEEN '$start_date' AND '$end_date'");
		$GetIncidentReportsNumRows = mysqli_num_rows($GetIncidentReportsQuery);
		$GetIncidentReportsLoop = 0;
		if ($GetIncidentReportsNumRows > 0) {
			while ($value = mysqli_fetch_assoc($GetIncidentReportsQuery)) {
				$IncidentReport[] = $value;	
			}
			echo "
			<div class='panel-group'>
				<div class='row'>
					<div class='col-sm-12 black_text'>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<div class='row'>
									<div class='col-sm-2'>
										Report ID Number
									</div>
									<div class='col-sm-1'>
										Incident Level
									</div>
									<div class='col-sm-1'>
										Incident Date
									</div>
									<div class='col-sm-5'>
										Departure Involved
									</div>
									<div class='col-sm-3'>
										Guide Involved
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12 black_text'>
						<div class='panel panel-default'>";
							foreach ($IncidentReport as $row) {
								$ReportIDNumber = $row["ReportID"];
								$IncidentLevel = $row["IncidentLevel"];
								$IncidentDate = $row["IncidentDate"];
								$DepartureInvolved = $row["DepartureInvolved"];
								$GuideInvolved = $row["GuideInvolved"];
								echo "
								<div class='panel panel-default'>
									<div class='panel-body'>
										<form role='form' class='form-horizontal' action='edit_incident_report.php?submit=false' method='post'>	
											<div class='col-sm-2'>
												<input type='hidden' value='$ReportIDNumber' name='report_id'>
												$ReportIDNumber
											</div>
											<div class='col-sm-1'>
												$IncidentLevel
											</div>
											<div class='col-sm-1'>
												$IncidentDate
											</div>
											<div class='col-sm-5'>
												$DepartureInvolved
											</div>
											<div class='col-sm-2 text-center'>
												$GuideInvolved
											</div>
											<div class='col-sm-1 text-center'>
												<button type='submit' class='btn btn-success btn-sm'>View Report</button>
											</div>
										</form>
									</div>
								</div>";
								$GetIncidentReportsLoop ++;
								}
								echo "
							</div>
						</div>
					</div>
				</div>
			</div>";
		} else {
			echo "no results";	
		}
	} else {
		$step ++;
		echo "
		<form role='form' class='form-inline' action='search_incident_report.php?step=$step&submit=false' method='post'>";
		$step --;
		if ($step != "3") {
			echo "
			<div class='row black_text'>
				<div class='col-sm-12'>
					<div class='panel panel-default'>
						<div class='panel-heading'>";
							switch($step) {
								case "1":
									echo "Select the beginning of the date range you would like to search.";
									break;	
								case "2":
									echo "Select the end of the date range you would like to search.";
									break;
								case "3";
									echo "test 3";
									break;	
							}
							echo "
						</div>
						<div class='panel-body'>";
							if ($step == "1") {
								echo "
								<div class='col-sm-4'>
									<div class='form-group'>
										<label for='start_date'>Beginning of date range:</label>
										<input type='text' class='form-control' id='datepicker' name='start_date' autocomplete='off'>
									</div>
								</div>
								<div class='col-sm-4'>
								</div>";
							} else {
								$start_date = $_POST['start_date'];
								echo "
								<div class='col-sm-4'>
									<div class='form-group'>
										<label for='start_date'>End of date range:</label>
										<input type='text' class='form-control' name='start_date' autocomplete='off' readonly='readonly' value='$start_date'>
									</div>
								</div>";					
							}
							if ($step == "2") {
								echo "
								<div class='col-sm-4'>
									<div class='form-group'>
										<label for='end_date'>End of date range:</label>
										<input type='text' class='form-control' id='datepicker' name='end_date' autocomplete='off'>
									</div>
								</div>";
							}
							if ($step < 3) {
								echo "
								<div class='col-sm-4 text-right'>
									<div class='form-group'>";
										switch($step) {
											case "1":
												echo "<button type='submit' class='btn btn-primary'>Next</button>";
												break;
											case "2":
												echo "<button type='submit' class='btn btn-success'>Search Incident Reports</button>";
												break;
										}
										echo "
									</div>
								</div>";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		echo "
		</div>
	</div>
</div>
</form>";
}
	echo "
	<script src='functions/date_picker/pikaday.js'></script>
	<script>
		var picker = new Pikaday(
		{
			field: document.getElementById('datepicker'),
			firstDay: 1,
			minDate: new Date(2000, 0, 1),
			maxDate: new Date(2020, 12, 31),
			yearRange: [2000,2020]
		});
	</script>";
} else {
	echo "not logged in";	
}
?>
</body>
</html>