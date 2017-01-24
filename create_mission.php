<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Create Mission</title>
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
	echo "<div class='container-fluid'>";
	include 'navigation.php';
	if (!empty($_SESSION["username"])) {
		if ($_SESSION["priviledge"] == "admin") {
			/*Connect to database.*/
			include 'functions/connect.php';
			$submit = $_GET["submit"];
			if ($submit == "false") {
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Create New Mission</h4>
						</div>
					</div>
				</div>
				<form class='form-horizontal' role='form' data-toggle='validator' method='post' action='create_mission.php?submit=true'>
					<fieldset>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_title'>Mission Title</label>  
							<div class='col-md-5'>
								<input id='mission_title' name='mission_title' placeholder='Name of mission.' class='form-control input-md' required='' type='text'>
								<span class='help-block'>* Enter a brief mission description.</span>  
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='created_for'>Mission For</label>
							<div class='col-md-5'>
								<select id='created_for' name='created_for' class='form-control'>";
									$today = date("Y-m-d");
									$staff_names = mysqli_query($connect, "SELECT GuideName FROM guides WHERE end_date > $today AND Operator = '".$_SESSION["operator"]."'");
									foreach ($staff_names as $value) {
										echo "
										<option value='".$value["GuideName"]."'>".$value["GuideName"]."</option>";
									}
									echo "
								</select>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='created_by'>Created By</label>  
							<div class='col-md-5'>";
								$created_by = ucfirst($_SESSION["username"]);
								echo "
								<input id='created_by' name='created_by' readonly='readonly' value='$created_by' class='form-control input-md' type='text'>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_status'>Mission Status</label>  
							<div class='col-md-5'>
								<input id='mission_status' name='mission_status' readonly='readonly' value='In Progress' class='form-control input-md' type='text'>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_description'>Mission Description</label>
							<div class='col-md-5'>                  
								<textarea rows='5' class='form-control' id='mission_description' name='mission_description' placeholder='Enter Mission Details...'></textarea>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_deadline'>Mission Deadline</label>  
							<div class='col-md-5'>
								<input id='mission_deadline' name='mission_deadline' required='' value='".date("Y-m-d", strtotime("+1 day"))."' class='form-control input-md' type='text'>
								<span class='help-block'>* Enter a mission deadline.</span> 
							</div>
						</div>
						<div class='form-group'>
							<label class='col-md-4 control-label' for='submit'></label>
							<div class='col-md-4'>
								<button id='submit' name='submit' class='btn btn-success'>Save Mission</button>
							</div>
						</div>
					</fieldset>
				</form>
				<script>
					var picker = new Pikaday(
					{
						field: document.getElementById('mission_deadline'),
						firstDay: 1,
						minDate: new Date(2000, 0, 1),
						maxDate: new Date(2020, 12, 31),
						yearRange: [2000,2020]
					});
				</script>";
			} else {
				$createdFor = $_POST["created_for"];
				$createdBy = $_POST["created_by"];
				$missionTitle = mysqli_real_escape_string($connect, $_POST["mission_title"]);
				$missionStatus = $_POST["mission_status"];
				$missionDescription = mysqli_real_escape_string($connect, $_POST["mission_description"]);
				$missionDeadline = $_POST["mission_deadline"];

				$missionDeadline = $_POST['mission_deadline'];
				$missionDeadline_day = substr($missionDeadline,8,2);
				$missionDeadline_month = substr($missionDeadline,4,3);
				$missionDeadline_month = date("m", strtotime($missionDeadline_month));
				$missionDeadline_year = substr($missionDeadline,11,4);
				$missionDeadline = date("Y-m-d", mktime(0,0,0,$missionDeadline_month,$missionDeadline_day,$missionDeadline_year));

				$add_mission = mysqli_query($connect, "INSERT INTO mission_log (CreatedFor, CreatedBy, MissionTitle, MissionStatus, MissionDescription, MissionDeadline, Operator) VALUES ('$createdFor', '$createdBy', '$missionTitle', '$missionStatus', '$missionDescription', '$missionDeadline', '".$_SESSION["operator"]."')");
				echo "
				<div class='well'>
					<h4>Mission successfully logged for $createdFor.</h4>
				</div>";

				require("libraries/php_mailer/PHPMailerAutoload.php");
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = true;
				$mail->Username = $config["email_username"];                 
				$mail->Password = $config["email_password"];
				$mail->SMTPSecure = "tls"; 
				$mail->Port = 587;                                   
				$mail->FromName = $config["brand"];
				$mail->From     = $config["email_from_address"];
				$mail->AddAddress($config["email_add_address"]);
				$recipients = explode(" ", $config["email_add_internal_cc"]);
				foreach ($recipients as $email_address)	{
					$mail->AddCC("".$email_address."");
				}
				$mail->Subject  = "New Mission logged for ".$createdFor." by ".$createdBy.".";
				$mail->Body     = "Mission details: $missionDescription.";
				$mail->WordWrap = 50;
				if(!$mail->Send()) {
					echo ' Message was not sent.';
					echo 'Mailer error: ' . $mail->ErrorInfo;
				}
			}
		} else {
			echo "
			<div class='well'>
				<h4>Only Guide Managers can log new missions.</h4>
			</div>";
		}
	} else {
		echo "not logged in</div>";	
	}
	?>
</body>
</html>