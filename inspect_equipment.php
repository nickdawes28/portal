<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Inspect Equipment</title>
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
echo "<div class='container-fluid'>";
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	include 'functions/connect.php';
	$submit = $_GET["submit"];
	if ($submit == "2") {
		$equipment_type = $_POST["type"];
		switch ($equipment_type) {
			case "Guide First Aid Kit":
				$get_all_equipment_query = mysqli_query($connect, "SELECT FirstAidKitID FROM first_aid_kits");
				$get_all_equipment_num_rows = mysqli_num_rows($get_all_equipment_query);
				break;
		}
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Select equipment to inspect from the list below.</h4>
				</div>
			</div>
		</div>
		<form role='form' data-toggle='validator' method='post' action='inspect_equipment.php?submit=3'>
		<div class='row black_text'>
			<div class='col-sm-12'>
				<div class='form-group'>
					<div class='input-group'>
						<span class='input-group-addon text-left'>Equipment ID:</span>
						<select class='form-control' name='equipment_id'>";
						if ($get_all_equipment_num_rows > 0) {
							foreach ($get_all_equipment_query as $value) {
								echo "<option>".$value["FirstAidKitID"]."</option>";
							}
						} else {
							echo "<option>No equipment to select...</option>";
						}	
						echo "
   		 				</select>
						<input type='hidden' name='equipment_type' value='$equipment_type'>
						<span class='input-group-btn'>
							<button type='submit' class='btn btn-success'>Submit</button>
						</span>
					</div>
				</div>
			</div>	
		</form>
		</div>";
	}
	if ($submit == "3") {
		$equipment_type = $_POST["equipment_type"];
		$equipment_id = $_POST["equipment_id"];
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Inspect Equipment</h4>
				</div>
			</div>
		</div>";
		switch ($equipment_type) {			
			case "Guide First Aid Kit":
				$check_who_assigned_to = mysqli_query($connect, "SELECT StaffName FROM assigned_equipment_log WHERE EquipmentID = '$equipment_id' AND CheckInDate IS NULL");
				$assigned_to = "Inventory";
				foreach ($check_who_assigned_to as $value1) {
					$assigned_to = $value1["StaffName"];
				}
				echo "
				<form class='form-horizontal' method='post' action='inspect_equipment.php?submit=true'>
				<input type='hidden' name='equipment_type' value='$equipment_type'>
				<fieldset class='black_text'>
					<div class='form-group'>
						<label class='col-md-4 control-label' for='equipment_id'>Equipment ID</label>  
						<div class='col-md-4'>
							<input id='equipment_id' name='equipment_id' class='form-control input-md' type='text' value='$equipment_id' readonly='readonly'>
							<span class='help-block'>* Currently assigned to $assigned_to</span> 
    					</div>
					</div>
					<div class='form-group'>
						<label class='col-md-4 control-label' for='inspection_date'>Inspection Date (today)</label>  
						<div class='col-md-4'>";
							$inspection_date = date("Y-m-d");
							echo "
							<input id='inspection_date' name='inspection_date' class='form-control input-md' type='text' value='$inspection_date' readonly='readonly'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-md-4 control-label' for='inspector'>Inspector</label>  
						<div class='col-md-4'>";
							$inspector = ucfirst($_SESSION["username"]);
							echo "
							<input id='inspector' name='inspector' class='form-control input-md' type='text' value='$inspector' readonly='readonly'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-md-4 control-label' for='next_assessment'>Date For Next Inspection</label>";
						$NextInspectionDue = date('Y-m-d', strtotime('+2 months'));
						echo "
						<div class='col-md-4'>
							<input id='next_inspection' name='next_inspection' class='form-control input-md' type='text' value='$NextInspectionDue' readonly='readonly'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-md-4 control-label' for='singlebutton'></label>";
						$check_senior_or_above = mysqli_query($connect, "SELECT Role, GuideName FROM guides WHERE GuideName = '$inspector'");
						$check_senior_or_above_num_rows = mysqli_num_rows($check_senior_or_above);
						if ($check_senior_or_above_num_rows > 0) {
							foreach ($check_senior_or_above as $value) {
								$guide_role = $value["Role"];
							}
						}
						if ($guide_role == "senior_guide" OR "guide_manager" OR "ops") {
							echo "
							<div class='col-md-4'>
								<button id='singlebutton' name='singlebutton' class='btn btn-success'>Submit</button>
							</div>";	
						}
						echo "
					</div>
				</fieldset>
				</form>
				<div class='row'>
					<div class='col-sm-12'>
						&nbsp;
					</div>
				</div>
				<div class='row black_text'>
					<div class='col-sm-12'>
						<p>At a minimum, a Guide First Aid Kit should include the following:</p>
						<ul class='list-group'>
							<li class='list-group-item'><b>1</b> x Small Scissors</li>
							<li class='list-group-item'><b>1</b> x Tweezers</li>
							<li class='list-group-item'><b>1</b> x Thermometer</li>
							<li class='list-group-item'><b>2</b> x Pair Vinyl Examination Gloves</li>
							<li class='list-group-item'><b>1</b> x CPR Face Shield</li>
							<li>&nbsp;</li>
							<li class='list-group-item'>Adhesive Dressing (recommended 3 x small, 3 x medium, 2 x large, 1 x long strip)</li>
							<li class='list-group-item'><b>1</b> x Triangular Bandage</li>
							<li class='list-group-item'><b>2</b> x Small Gauze Dressing</li>
							<li class='list-group-item'><b>1</b> x Elasticated Bandage (recommended 4.5cm x 5m)</li>
							<li class='list-group-item'><b>2</b> x Non-elasticated Bandages</li>
							<li>&nbsp;</li>
							<li class='list-group-item'><b>3</b> x Safety Pins</li>
							<li class='list-group-item'><b>1</b> x Roll Adhesive Tape</li>
							<li class='list-group-item'><b>3</b> x Blister Plaster </li>
							<li class='list-group-item'><b>1</b> x Steri-Strips</li>
							<li class='list-group-item'><b>3</b> x Cleansing Wipe (Alcohol, Iodine)</li>
							<li class='list-group-item'><b>1</b> x Burn Gel</li>							
						</ul>
					</div>
				</div>";
				break;
		};
	} else if ($submit == "1") {
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Select equipment type to inspect.</h4>
				</div>
			</div>
		</div>
		<form role='form' data-toggle='validator' method='post' action='inspect_equipment.php?submit=2'>
		<div class='row black_text'>
			<div class='col-sm-12'>
				<div class='form-group'>
					<div class='input-group'>
						<span class='input-group-addon text-left'>Equipment Type:</span>
						<select class='form-control' name='type'>
							<option>Guide First Aid Kit</option>
							<option>Edge Kit</option>
							<option>Helmet</option>
   		 				</select>
						<span class='input-group-btn'>
							<button type='submit' class='btn btn-success'>Submit</button>
						</span>
					</div>
				</div>
			</div>		
		</form>
		</div>";
	} else {
		if ($submit == "true") {
			$equipment_type = $_POST["equipment_type"];	
			$equipment_id = $_POST["equipment_id"];
			$inspection_date = $_POST["inspection_date"];
			$inspector = $_POST["inspector"];
			$next_inspection = $_POST["next_inspection"];
			switch ($equipment_type) {
				case "Guide First Aid Kit":
					$reset_previous_inspection = mysqli_query($connect, "UPDATE first_aid_inspection_log SET NextDue = NULL WHERE FirstAidKitID = '$equipment_id'");
					$insert_equipment_query = mysqli_query($connect, "INSERT INTO first_aid_inspection_log (FirstAidKitID, Size, InspectionDate, NextDue, InspectedBy) VALUES ('$equipment_id', '$equipment_type', '$inspection_date', '$next_inspection', '$inspector')");
					break;
			}
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Inspection successfully added for $equipment_id.</h4>
					</div>
				</div>
			</div>";
		}
	}
} else {
	echo "not logged in</div>";	
}
?>
</body>
</html>