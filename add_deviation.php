<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Deviation from Procedure</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="libraries/jQuery.js"></script>
	<script src="libraries/bootstrap.js"></script>
	<script src='functions/date_picker/pikaday.js'></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel='stylesheet' href='functions/date_picker/css/pikaday.css'>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
	<?php
	session_start();
	if (!empty($_SESSION["username"])) {
		echo "<div class='container-fluid'>";
		include 'navigation.php';
		include 'functions/connect.php';
		if ($_GET['submit'] == "true") {
			$DeviationDate = $_POST['deviation_date'];
			$DeviationDateDay = substr($DeviationDate,8,2);
			$DeviationDateMonth = substr($DeviationDate,4,3);
			$DeviationDateMonth = date("m", strtotime($DeviationDateMonth));
			$DeviationDateYear = substr($DeviationDate,11,4);
			$DeviationDate = date("Y-m-d", mktime(0,0,0,$DeviationDateMonth,$DeviationDateDay,$DeviationDateYear));
			$StaffInvolved = $_POST['staff_involved'];
			$StaffReporting = $_POST['staff_reporting'];
			$Procedure = $_POST['procedure'];
			$IncidentDetails = $_POST['incident_details'];

			$AddDeviationReportQuery = mysqli_query($connect, "INSERT INTO deviation_log (`DeviationID`, `StaffInvolved`, `StaffReporting`, `ProcedureDescription`, `DeviationDetails`, `DeviationDate`, Operator) VALUES (NULL, '$StaffInvolved', '$StaffReporting', '$Procedure', '$IncidentDetails', '$DeviationDate', '".$_SESSION["operator"]."')");
			
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Deviation Successfully added.</h4>
					</div>
				</div>
			</div>";
		} else {
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Issue a 'Deviation from Procedure' Notice</h4>
					</div>
				</div>
			</div>
			<form role='form' data-toggle='validator' method='post' action='add_deviation.php?submit=true'>
				<div class='row black_text'>
					<div class='col-sm-12'>
						<div class='form-group'>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Staff Involved:</span>
								<select class='form-control' name ='staff_involved'>
									<option>Select Staff</option>";
									$GuideNameDate = date("Y-m-d");
									$GuideName = ucfirst($_SESSION["username"]);
									$GetGuidesQuery = mysqli_query($connect, "SELECT GuideName FROM guides WHERE GuideName <> '".$GuideName."' AND end_date >= '$GuideNameDate' AND start_date <= '$GuideNameDate' AND Operator = '".$_SESSION["operator"]."'");
									$GetGuidesQueryNumRows = mysqli_num_rows($GetGuidesQuery);
									$GetGuidesQueryLoop = 0;
									foreach ($GetGuidesQuery as $value) {
										echo "<option>".$value["GuideName"]."</option>";
									}
									echo "
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Date:</span>
								<input type='text' class='form-control' placeholder='Select the date the incident took place.' id='start_date' name='deviation_date' required data-error='Start date cannot be empty.' readonly='readonly'>
							</div>
							<div class='help-block with-errors'></div>
						</div>
						<div class='input-group'>
							<span class='input-group-addon text-left'>Staff Reporting:</span>";
							$StaffReporting = ucfirst($_SESSION["username"]);
							echo "
							<input type='text' class='form-control' name='staff_reporting' value='$StaffReporting' readonly='readonly'>
						</div>
					</div>
				</div>
				<div class='input-group'>
					<span class='input-group-addon text-left'>Select the category relating to the procedure deviated from. Procedures must be formally written into the SMP or staff contract to be considered.</span>
					<select class='form-control' name='procedure'>
						<option>Select from list.</option>
						<option>Breach of Safety Management Plan</option>
						<option>Breach of contract - Staff Facility</option>
						<option>Breach of contract - Uniform</option>
						<option>Breach of contract - Work Hours</option>
						<option>Breach of contract - Roles and Responsibilities</option>
						<option>Breach of contract - Drugs and Alcohol</option>
						<option>Other</option>
					</select>
				</div>
				<div class='form-group'>
					<textarea class='form-control' name='incident_details' placeholder='Details of the incident...' rows='2' data-error='Departure name required!' required></textarea>
					<div class='help-block with-errors'></div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						&nbsp;
					</div>
				</div>
				<div class='row text-right'>
					<div class='col-sm-12'>
						<div class='panel-group'>
							<button type='submit' class='btn btn-success'>Submit</button>		
						</form>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
		var picker = new Pikaday(
		{
			field: document.getElementById('start_date'),
			firstDay: 1,
			minDate: new Date(2000, 0, 1),
			maxDate: new Date(2020, 12, 31),
			yearRange: [2000,2020]
		});
	</script>
	<script>
		var picker = new Pikaday(
		{
			field: document.getElementById('end_date'),
			firstDay: 1,
			minDate: new Date(2000, 0, 1),
			maxDate: new Date(2020, 12, 31),
			yearRange: [2000,2020]
		});
	</script>";			
}

} else {
	header('Location: index.php');
}
?>
</body>
</html>