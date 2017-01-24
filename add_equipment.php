<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add Equipment</title>
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
	if ($submit == "true") {
		$equipment_type = $_POST["type"];
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Add New $equipment_type</h4>
				</div>
			</div>
		</div>";
		switch ($equipment_type) {			
			case "Guide First Aid Kit":
				$get_latest_id_query = mysqli_query($connect, "SELECT MAX(FirstAidKitCount) FROM first_aid_kits WHERE Operator = '".$_SESSION["operator"]."'");
				$get_latest_id_numrows = mysqli_num_rows($get_latest_id_query);
				if ($get_latest_id_numrows > 0) {
					foreach ($get_latest_id_query as $value) {
						$latest_id = ($value["MAX(FirstAidKitCount)"] + 1);
					} 
				} else {
					$latest_id = "1";	
				}
				$ID = "FA";
				echo "
					<div class='row'>
						<div class='col-sm-12'>
							<form class='form-horizontal' method='post' action='add_equipment.php?submit=submit'>
							<fieldset>
								<div class='form-group black_text'>
									<label class='col-md-4 control-label' for='equipment_type'>Equipment Type</label>  
									<div class='col-md-5'>
										<input id='equipment_type' name='equipment_type' class='form-control' value='$equipment_type' readonly='readonly' type='text'>
									</div>
								</div>
								<div class='form-group black_text'>
									<label class='col-md-4 control-label' for='equipment_id'>$equipment_type ID*</label>  
									<div class='col-md-5'>
										<input id='equipment_id' name='equipment_id' class='form-control' value='$ID$latest_id' type='text' readonly='readonly'>
										<span class='help-block'>*The latest available ID is generated automatically.</span> 
									</div>
								</div>
								<div class='form-group'>
									<label class='col-md-4 control-label' for='submit_button'></label>
									<div class='col-md-4'>
										<button id='submit_button' name='submit' class='btn btn-success'>Submit</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
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
	} else if ($submit == "false") {
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Select equipment type to add.</h4>
				</div>
			</div>
		</div>
		<form role='form' data-toggle='validator' method='post' action='add_equipment.php?submit=true'>
		<div class='row black_text'>
			<div class='col-sm-12'>
				<div class='form-group'>
					<div class='input-group'>
						<span class='input-group-addon text-left'>Equipment Type:</span>
						<select class='form-control' name='type'>
							<option>Guide First Aid Kit</option>
							<option>Edge Kit</option>
							<option>Helmet</option>
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
		</form>
		</div>";
	} else {
		if ($submit == "submit") {
			$equipment_type = $_POST["equipment_type"];	
			$equipment_id = $_POST["equipment_id"];
			switch ($equipment_type) {
				case "Guide First Aid Kit":
					$count = ltrim($equipment_id,"FA");
					$insert_equipment_query = mysqli_query($connect, "INSERT INTO first_aid_kits (FirstAidKitID, Size, FirstAidKitCount, Operator) VALUES ('$equipment_id', '$equipment_type', '$count', '".$_SESSION["operator"]."')");
					break;
			}
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>$equipment_id successfully added.</h4>
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