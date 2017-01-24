<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assign Equipment</title>
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
	if ($submit == "false") {
		$query = mysqli_query($connect, "SELECT GuideName FROM guides WHERE end_date > '".date("Y-m-d")."' AND Operator = '".$_SESSION["operator"]."'");
		while ($row = mysqli_fetch_assoc($query)) {
			$GuideName[] = $row;	
		}
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Select staff to assign equipment to.</h4>
				</div>
			</div>
		</div>
		<form role='form' data-toggle='validator' method='post' action='assign_equipment.php?submit=true'>
			<div class='row black_text'>
				<div class='col-sm-12'>
					<div class='form-group'>
						<div class='input-group'>
							<span class='input-group-addon text-left'>Select Staff:</span>
							<select class='form-control' name='guide_name'>";
								foreach ($GuideName as $value) {
									echo "
									<option>".$value["GuideName"]."</option>";
								}
								echo "
		   	 				</select>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "
								<span class='input-group-btn'>
									<button type='submit' class='btn btn-success'>Submit</button>
								</span>";
							}
							echo "
						</div>
					</div>
				</div>	
			</div>	
		</form>";
	} else {
		if ($submit == "update") {
			$GuideName = $_POST["guide_name"];
			$EquipmentID = $_POST["equipment_id"];
			$ExistingFirstAidKitID = $_POST["existing_first_aid_kit_id"];
			$Date = $_POST["date"];
			
			$UpdateLogQuery = mysqli_query($connect, "UPDATE assigned_equipment_log SET CheckInDate = '$Date' WHERE CheckInDate IS NULL AND StaffName = '$GuideName' AND EquipmentID = '$ExistingFirstAidKitID' AND Operator = '".$_SESSION["operator"]."'");
			
			$InsertLogQuery = mysqli_query($connect, "INSERT INTO assigned_equipment_log (StaffName, EquipmentID, CheckOutDate, CheckInDate, Operator) VALUES ('$GuideName', '$EquipmentID', '$Date', NULL, '".$_SESSION["operator"]."')");
			
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Equipment successfully assigned.</h4>
					</div>
				</div>
			</div>";
		} else {
			$GuideName = $_POST["guide_name"];
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Staff Details</h4>
					</div>
				</div>
			</div>
			<div class='row black_text'>
				<div class='col-sm-12'>
					<div class='form-group'>
						<div class='input-group'>
							<span class='input-group-addon text-left'>Name:</span>
							<input type='text' class='form-control' value='$GuideName' readonly='readonly'>
						</div>
						<div class='help-block with-errors'></div>
					</div>
				</div>
			</div>
			<div>
				<ul class='nav nav-tabs' role='tablist'>
					<li role='presentation' class='active'><a href='#first_aid_kit' aria-controls='first_aid_kit' role='tab' data-toggle='tab'>First Aid Kit</a></li>
					<li role='presentation'><a href='#edge_kit' aria-controls='edge_kit' role='tab' data-toggle='tab'>Edge Kit</a></li>
					<li role='presentation'><a href='#uniform' aria-controls='uniform' role='tab' data-toggle='tab'>Uniform</a></li>
				</ul>
				<div class='tab-content'>
					<div role='tabpanel' class='tab-pane active' id='first_aid_kit'>
						<div class='row'>
							<div class='col-sm-12'>
								&nbsp;
							</div>
						</div>
						<div class='row black_text'>
							<div class='col-sm-12'>
								<form class='form-horizontal' method='post' action='assign_equipment.php?submit=update'>
									<input type='hidden' value='$GuideName' name='guide_name'>
									<input type='hidden' value='".date("Y-m-d")."' name='date'>";
									$get_existing_first_aid_kit = mysqli_query($connect, "SELECT EquipmentID FROM assigned_equipment_log WHERE EquipmentID LIKE 'FA%' AND CheckInDate IS NULL AND StaffName = '$GuideName' AND Operator = '".$_SESSION["operator"]."'");
									$get_existing_first_aid_kit_num_rows = mysqli_num_rows($get_existing_first_aid_kit);
									if ($get_existing_first_aid_kit_num_rows > 0) {
										foreach ($get_existing_first_aid_kit as $value) {
											$existing_first_aid_kit_id = $value["EquipmentID"];
										}
										echo "<input type='hidden' name='existing_first_aid_kit_id' value='$existing_first_aid_kit_id'>";
									} else {
										$existing_first_aid_kit_id = "None";
										echo "<input type='hidden' name='existing_first_aid_kit_id' value='$existing_first_aid_kit_id'>";	
									}
									echo "
									
									<div class='row black_text'>
									<fieldset>
										<div class='form-group'>
											<label class='col-md-4 control-label' for='equipment_id'>First Aid Kit ID</label>
											<div class='col-md-4'>
												<select id='equipment_id' name='equipment_id' class='form-control'>";
												$get_available_first_aid_kits = mysqli_query($connect, "SELECT FirstAidKitID FROM first_aid_kits WHERE Size = 'Guide First Aid Kit' AND FirstAidKitID NOT IN (SELECT EquipmentID FROM assigned_equipment_log WHERE CheckInDate IS NULL) AND Operator = '".$_SESSION["operator"]."'");
												$get_available_first_aid_kits_numrows = mysqli_num_rows($get_available_first_aid_kits);
												if ($existing_first_aid_kit_id != "None") {
													echo "<option>$existing_first_aid_kit_id</option>";
												}
												if ($get_available_first_aid_kits_numrows > 0) {
													foreach ($get_available_first_aid_kits as $value) {
														echo "
														<option>".$value["FirstAidKitID"]."</option>";	
													}
												} else {
													echo "
													<option value='None'>Select First Aid Kit</option>";	
												}
												echo "
 												</select>
											</div>
										</div>
										<div class='form-group'>
											<label class='col-md-4 control-label' for='submit_button'></label>
											<div class='col-md-4'>
												<button id='singlebutton' name='singlebutton' class='btn btn-success'>Submit</button>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div role='tabpanel' class='tab-pane' id='edge_kit'>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='panel panel-default'>
								<div class='panel-body'>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div role='tabpanel' class='tab-pane' id='uniform'>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='panel panel-default'>
								<div class='panel-body'>
								</div>
							</div>	
						</div>
					</div>
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