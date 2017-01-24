<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Alerts</title>
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
		$query_date = date("Y-m-d");

		$GetMissingQuery_BasicKnots = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Basic Knots' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
		$GetMissingQuery_GE = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Glacier Explorer Assessment' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
		$GetMissingQuery_GW = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Glacier Wonders Assessment' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
		$GetMissingQuery_SMP = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM training_log WHERE TrainingName = 'Have read and understood the Glacier Guides SMP') AND Operator = '".$_SESSION["operator"]."'");
		$GetMissingQuery_SimpleRescue = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Simple Rescue' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
		$alerts_query_assessments_overdue = mysqli_query($connect, "SELECT * FROM assessment_log WHERE NextDue < '".date("Y-m-d")."' AND GuideName NOT IN (SELECT GuideName FROM guides WHERE end_date < '$query_date') AND Operator = '".$_SESSION["operator"]."'");
		$alerts_first_aid_inspection_missing = mysqli_query($connect, "SELECT FirstAidKitID, Size FROM first_aid_kits WHERE FirstAidKitID NOT IN (SELECT FirstAidKitID FROM first_aid_inspection_log) AND Operator = '".$_SESSION["operator"]."'");

		$GetOverdueQuery_NumRows = mysqli_num_rows($alerts_query_assessments_overdue);
		$GetMissingQuery_BasicKnots_NumRows = mysqli_num_rows($GetMissingQuery_BasicKnots);
		$GetMissingQuery_GW_NumRows = mysqli_num_rows($GetMissingQuery_GW);
		$GetMissingQuery_GE_NumRows = mysqli_num_rows($GetMissingQuery_GE);
		$GetMissingQuery_SimpleRescue_NumRows = mysqli_num_rows($GetMissingQuery_SimpleRescue);
		$GetMissingQuery_SMP_NumRows = mysqli_num_rows($GetMissingQuery_SMP);
		
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Alerts</h4>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<div class='panel panel-default'>
					<div class='panel-heading text-center'>
						Current Inspection Period
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-3 text-center'>
				<div class='panel panel-success'>
					<div class='panel-heading'>January 1st - March 31st<br><b>Green</b></div>
				</div>
			</div>
			<div class='col-sm-3 text-center'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>April 1st - June 31st<br><b>Red</b></div>
				</div>
			</div>
			<div class='col-sm-3 text-center'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>July 1st - September 31st<br><b>Blue</b></div>
				</div>
			</div>
			<div class='col-sm-3 text-center'>
				<div class='panel panel-warning'>
					<div class='panel-heading'>October 1st - December 31st<br><b>Yellow</b></div>
				</div>
			</div>
		</div>";
		if ($GetMissingQuery_BasicKnots_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following Guides have not yet had a <b>Basic Knots</b> assessment:<br>";
							foreach ($GetMissingQuery_BasicKnots as $value) {
								echo "<a href='add_assessment.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> ";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetMissingQuery_SMP_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following Guides have not yet read the <b>Safety Management Plan</b>:<br>";
							foreach ($GetMissingQuery_SMP as $value) {
								echo "<a href='add_training.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> ";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetMissingQuery_GE_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following Guides have not yet passed their <b>Glacier Explorer</b> assessment:<br>";
							foreach ($GetMissingQuery_GE as $value) {
								echo "<a href='add_assessment.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> ";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetMissingQuery_GW_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following Guides have not yet passed their <b>Glacier Wonders</b> assessment:<br>";
							foreach ($GetMissingQuery_GW as $value) {
								echo "<a href='add_assessment.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> ";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetMissingQuery_SimpleRescue_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following Guides have not yet passed their <b>Simple Rescue</b> assessment:<br>";
							foreach ($GetMissingQuery_SimpleRescue as $value) {
								echo "<a href='add_assessment.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> ";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetOverdueQuery_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-warning'>
						<div class='panel-heading'>
							The following guides are due for re-assessment:<br>";
							foreach ($alerts_query_assessments_overdue as $value) {
								switch ($value["RoleRequired"]) {
									case '0':
									$role_required = "0";
									break;
									case '1':
									$role_required = "1";
									break;
									case '2':
									$role_required = "2";
									break;
									case '3':
									$role_required = "3";
									break;
									default:
									$role_required = "0";
									break;
								}
								$check_guide_role = mysqli_query($connect, "SELECT Role FROM guides WHERE GuideName = '".$value["GuideName"]."' AND Operator = '".$_SESSION["operator"]."'");
								foreach ($check_guide_role as $value_a) {
									$guide_role = $value_a["Role"];
								}
								switch ($guide_role) {
									case "guide":
									$guide_role_value = "1";
									break;
									case "senior_guide":
									$guide_role_value = "2";
									break;
									case "guide_manager":
									$guide_role_value = "3";
									break;
									default:
									$guide_role_value = "0";
									break;
								}
								$date1 = date_create("".$query_date."");
								$date2 = date_create("".$value["NextDue"]."");
								$diff = date_diff($date1,$date2);
								$date3 = date_create("".$value["Date"]."");
								$date4 = date_create("".$value["NextDue"]."");
								$diff1 = date_diff($date3,$date4);
								if ($guide_role_value >= $role_required) {
									echo "<a href='add_assessment.php?submit=false&GuideName=".$value["GuideName"]."'>".$value["GuideName"]."</a> <b>".$value["AssessmentName"]."</b> last assessed by ".$value["AssessedBy"]." on ".$value["Date"].". Re-assessment is every ".$diff1->format('<b>%a days</b>.')." This assessment is ".$diff->format('<b>%a days</b> overdue.')."<br>";
								}
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
		if ($GetMissingFirstAidInspection_NumRows > 0) {	
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-danger'>
						<div class='panel-heading'>
							The following <b>First Aid Kits</b> have never been inspected:<br>";
							foreach ($alerts_first_aid_inspection_missing as $value) {
								$check_who_assigned_to_a = mysqli_query($connect, "SELECT StaffName FROM assigned_equipment_log WHERE EquipmentID = '".$value["FirstAidKitID"]."' AND CheckInDate IS NULL AND Operator = '".$_SESSION["operator"]."'");
								$assigned_to_a = "Inventory";
								foreach ($check_who_assigned_to_a as $value1) {
									$assigned_to_a = $value1["StaffName"];
								}
								echo "
								<form style='display:inline' action='inspect_equipment.php?submit=3' method='post'>
									<input type='hidden' name='equipment_id' value='".$value["FirstAidKitID"]."'>
									<input type='hidden' name='equipment_type' value='".$value["Size"]."'>
									<button type='submit' class='custom_button_link'>".$value["FirstAidKitID"]."</button>
								</form>
								currently assigned to <b>$assigned_to_a</b>.<br>";
							}
							echo "
						</div>
					</div>
				</div>
			</div>";
		}
	} else {
		header('Location: index.php');
	}
	?>
</body>
</html>