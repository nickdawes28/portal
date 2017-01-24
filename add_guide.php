<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Guide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="libraries/jQuery.js"></script>
	<script src="libraries/bootstrap.js"></script>
	<script src='libraries/validator/js/validator.js'></script>
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
		if ($_SESSION["priviledge"] == "admin") {
			include 'functions/connect.php';
			$submit = $_GET["submit"];
			if ($submit == "false") {
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Add New Guide</h4>
						</div>
					</div>
				</div>
				<form role='form' data-toggle='validator' method='post' action='add_guide.php?submit=true'>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon text-left'>Name:</span>
									<input type='text' class='form-control' placeholder='Single name only. This is also the username!' required data-error='A valid name is required. First name only, lowercase with no spaces or special characters.' pattern='^[a-z0-9_\-]+$' name='staff_name'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Email:</span>
								<input type='email' class='form-control' placeholder='An email address to contact them on.' name='staff_email'>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Role:</span>
								<select class='form-control' name='staff_role'>
									<option value='trainee_guide'>Trainee Guide</option>
									<option value='guide'>Guide</option>
									<option value='senior_guide'>Senior Guide</option>
									<option value='guide_manager'>Guide Manager</option>
									<option value='ops'>Operations Team</option>
									<option value='sales'>Front of House Team</option>
									<option value='driver'>Driver</option>
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Privileges:</span>
								<select class='form-control' name='staff_privilege'>
									<option value='standard'>Standard User</option>
									<option value='admin'>Administrator</option>
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>Driver's License</span>
								<select class='form-control' name='staff_license'>
									<option value='None'>N/A</option>
									<option value='small_bus'>Small License</option>
									<option value='big_bus'>Big License</option>
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon text-left'>End Date:</span>
								<input type='date' class='form-control' placeholder='Leave blank untill staff employment has ended.' disabled='disabled' name='end_date' readonly='readonly'>
							</div>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon text-left'>Start Date:</span>
									<input type='text' class='form-control' placeholder='Select a start date...' id='datepicker' name='start_date' required data-error='Please select a start date.' readonly='readonly'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
						</div>
					</div>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									Additional Abilities
								</div>
								<div class='panel-body'>
									<div class='checkbox'>
										<label>
											<input type='checkbox' name='staff_ability[]' value='first_responder'>
											Wilderness First Responder Qualified
										</label>
									</div>
									<div class='checkbox'>
										<label>
											<input type='checkbox' name='staff_ability[]' value='ice_climbing'>
											Ice Climber
										</label>
									</div>
									<div class='checkbox'>
										<label>
											<input type='checkbox' name='staff_ability[]' value='summit'>
											Summit Guide
										</label>
									</div>
								</div>	
							</div>
						</div>
					</div>";
					if ($_SESSION["priviledge"] == "admin") {
						echo "
						<div class='row text-right'>
							<div class='col-sm-12'>
								<div class='panel-group'>
									<button type='submit' class='btn btn-success'>Submit</button>		
								</form>
							</div>
						</div>
					</div>";
				}
				echo "
			</form>
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
			$staffName = $_POST["staff_name"];
			$staffEmail = "";
			if (isset($_POST["staff_email"])) {
				$staffEmail = $_POST["staff_email"];
			}
			$staffRole = $_POST["staff_role"];
			if (isset($_POST["staff_ability"])) {
				$staffAbility = $_POST["staff_ability"];
			}
			$staffPrivilege = $_POST["staff_privilege"];
			$staffStartDate = $_POST["start_date"];
			$staffStartDate_day = substr($staffStartDate,8,2);
			$staffStartDate_month = substr($staffStartDate,4,3);
			$staffStartDate_month = date("m", strtotime($staffStartDate_month));
			$staffStartDate_year = substr($staffStartDate,11,4);
			$staffStartDate = date("Y-m-d", mktime(0,0,0,$staffStartDate_month,$staffStartDate_day,$staffStartDate_year));
			$staffLicense = $_POST["staff_license"];
			
			$add_guide_user = mysqli_query($connect, "INSERT INTO users (Username, Password, Priviledge, Operator) VALUES ('$staffName', 'glacier', '$staffPrivilege', '".$_SESSION["operator"]."')");
			echo mysqli_error($connect);
			if ($add_guide_user) {
				$guide_name_for_query = ucfirst($staffName);
				$add_staff_guides = mysqli_query($connect, "INSERT INTO guides (GuideName, Role, start_date, end_date, Operator) VALUES ('$guide_name_for_query', '$staffRole', '$staffStartDate', '2020-01-01', '".$_SESSION["operator"]."')");
				echo mysqli_error($connect);
			}
			if ($add_staff_guides) {
				$add_staff_role = mysqli_query($connect, "INSERT INTO guide_abilities (Ability, GuideName, DisplayOrder, Operator) VALUES ('$staffRole', '$staffName', 'a', '".$_SESSION["operator"]."')");
				echo mysqli_error($connect);
			}
			if ($add_staff_role) {
				if ($staffLicense != "None") {
					$add_staff_license = mysqli_query($connect, "INSERT INTO guide_abilities (Ability, GuideName, DisplayOrder, Operator) VALUES ('$staffLicense', '$staffName', 'b', '".$_SESSION["operator"]."')");
					echo mysqli_error($connect);
				}
			}
			if ($add_staff_role) {
				if (isset($_POST["staff_ability"])) {;
					foreach ($staffAbility as $value) {
						switch($value) {
							case "first_responder":
							$display_order = "c";
							break;
							case "ice_climbing":
							$display_order = "d";
							break;
							case "summit":
							$display_order = "e";
							break;
						}
						$add_staff_abilities = mysqli_query($connect, "INSERT INTO guide_abilities (Ability, GuideName, DisplayOrder, Operator) VALUES ('$value', '$staffName', '$display_order', '".$_SESSION["operator"]."')");
						echo mysqli_error($connect);
					}
				}
			}
			echo "
			<div class='well'>
				<h4>$guide_name_for_query successfully added.</h4>
			</div>";
		}
	} else {
		echo "you shouldn't be here.";	
	}
} else {
	header('Location: index.php');
}
?>
</body>
</html>