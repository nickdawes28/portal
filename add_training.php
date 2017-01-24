<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Training</title>
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
		include 'functions/connect.php';
		$submit = $_GET["submit"];
		if ($submit == "false") {
			$GuideName = $_GET["GuideName"];
			$ShadowGuide = ucfirst($_SESSION["username"]);
			if ($GuideName != $ShadowGuide) {
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Add Training</h4>
						</div>
					</div>
				</div>
				<form role='form' data-toggle='validator' method='post' action='add_training.php?submit=true'>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon text-left'>Name:</span>
									<input type='text' class='form-control' name='staff_name' value='$GuideName' readonly='readonly'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
						</div>
						<div class='col-sm-12'>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon text-left'>Training Date:</span>
									<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='datepicker' required data-error='Start date cannot be empty.' readonly='readonly' name='training_date'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
						</div>
					</div>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='panel panel-default'>
								<div class='panel-group'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											Shadow Guiding (with $ShadowGuide)
										</div>
										<div class='panel-body'>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Glacier Wonders shadow' checked='checked'>
													Glacier Wonders
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Glacier Explorer shadow'>
													Glacier Explorer
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Into the Glacier shadow'>
													Into the Glacier
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Crystal Ice Cave shadow'>
													Crystal Ice Cave
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Glacier Xtreme shadow'>
													Glacier Xtreme
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Alpine Tour shadow'>
													Alpine Tour
												</label>
											</div>
										</div>
										<div class='panel-heading'>
											Courses
										</div>
										<div class='panel-body'>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Wilderness First Responder Course'>
													Wilderness First Responder
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Glacier Guides Alpine Course'>
													Glacier Guides Alpine Course
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Glacier Guides Entry Level Guiding Course'>
													Glacier Guides Entry Level Guiding
												</label>
											</div>
										</div>
										<div class='panel-heading'>
											Rescue Training
										</div>
										<div class='panel-body'>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Basic Crevasse Rescue Training'>
													Basic Crevasse Rescue Training
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Advanced Crevasse Rescue Training'>
													Advanced Crevasse Rescue Training
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Advanced Ropes Rescue Training'>
													Advanced Ropes Rescue Training
												</label>
											</div>
										</div>
										<div class='panel-heading'>
											Other Training (with $ShadowGuide)
											<input type='hidden' value='$ShadowGuide' name='shadow_guide'>
										</div>
										<div class='panel-body'>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Have read and understood the Glacier Guides SMP'>
													Have read and understood the Glacier Guides SMP
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Track Maintanance Training'>
													Track Maintanance Training
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Guiding Training'>
													Guiding Training
												</label>
											</div>
											<div class='checkbox'>
												<label>
													<input type='radio' name='training' value='Other Training'>
													Other
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class='panel-body'>
									<textarea class='form-control' rows='2' placeholder='Feedback or additional comments...' name='comments'></textarea>
								</div>	
							</div>
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
			echo "
			<div class='well'>
				<h4>Sorry, you can't train yourself...</h4>
			</div>";
		}
	} else {
		$GuideName = $_POST["staff_name"];
		$TrainingName = $_POST["training"];
		$Date = $_POST["training_date"];
		$Date_day = substr($Date,8,2);
		$Date_month = substr($Date,4,3);
		$Date_month = date("m", strtotime($Date_month));
		$Date_year = substr($Date,11,4);
		$Date = date("Y-m-d", mktime(0,0,0,$Date_month,$Date_day,$Date_year));
		$Comments = $_POST["comments"];
		$Comments = mysqli_real_escape_string($connect, $Comments);
		$ShadowGuide = $_POST["shadow_guide"];
		switch ($TrainingName) {
			case "Wilderness First Responder Course":
			$Course = "yes";
			break;
			case "Glacier Guides Entry Level Guiding Course":
			$Course = "yes";
			break;
			case "Glacier Guides Alpine Course":
			$Course = "yes";
			break;
			default:
			$Course = "no";
		}
		$InsertTraining = mysqli_query($connect, "INSERT INTO training_log (TrainingLogID, GuideName, TrainingName, Date, Comments, ShadowGuide, Course, Operator) VALUES (NULL, '$GuideName', '$TrainingName', '$Date', '$Comments', '$ShadowGuide', '$Course', '".$_SESSION["operator"]."')");
		mysqli_error($connect);
		echo "
		<div class='well'>
			<h4>Training Log for $GuideName successfully updated.</h4>
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
		$mail->Subject  = "$TrainingName logged for $GuideName by $ShadowGuide.";
		$mail->Body     = "$Comments";
		$mail->WordWrap = 50;
		if(!$mail->Send()) {
			echo ' Message was not sent.';
			echo 'Mailer error: ' . $mail->ErrorInfo;
		}
	}
} else {
	header('Location: index.php');
}
?>
</body>
</html>