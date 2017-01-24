<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Assessment</title>
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
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Add Assessment</h4>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
					<a href='#' data-toggle='collapse' data-target='#assessment_criteria'>+ Click to see which assessments are required for which guiding positions.</a>
				</div>
				<div class='col-sm-12'>
					&nbsp;
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
					<div id='assessment_criteria' class='collapse'>
						<div class='panel-group'>
							<div class='panel panel-success'>
								<div class='panel-heading'>
									Required for Guide position.
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									Required for Senior Guide position.
								</div>
							</div>
							<div class='panel panel-warning'>
								<div class='panel-heading'>
									Required for Guide Manager position.
								</div>
							</div>
							<div class='panel panel-info'>
								<div class='panel-heading'>
									Required for Ice Climbing guide qualification.
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<ul class='nav nav-tabs' role='tablist'>
					<li role='presentation' class='active'><a href='#basic_knots' class='guide_requirement' aria-controls='basic_knots' role='tab' data-toggle='tab'>Basic Knots</a></li>
					<li role='presentation'><a href='#advanced_knots' class='senior_requirement' aria-controls='advanced_knots' role='tab' data-toggle='tab'>Advanced Knots</a></li>
					<li role='presentation'><a href='#simple_rescue' class='guide_requirement' aria-controls='simple_rescue' role='tab' data-toggle='tab'>Simple Rescue</a></li>
					<li role='presentation'><a href='#advanced_rescue' class='senior_requirement' aria-controls='advanced_rescue' role='tab' data-toggle='tab'>Advanced Rescue</a></li>
					<li role='presentation'><a href='#gw_assessment' class='guide_requirement' aria-controls='gw_assessment' role='tab' data-toggle='tab'>Glacier Wonders</a></li>
					<li role='presentation'><a href='#ge_assessment' class='guide_requirement' aria-controls='ge_assessment' role='tab' data-toggle='tab'>Glacier Explorer</a></li>
					<li role='presentation'><a href='#senior_guide_assessment' class='senior_requirement' aria-controls='senior_guide_assessment' role='tab' data-toggle='tab'>Senior Guide Assessment</a></li>
					<li role='presentation'><a href='#glacier_xtreme' class='gx_requirement' aria-controls='glacier_xtreme_assessment' role='tab' data-toggle='tab'>Glacier Xtreme</a></li>
				</ul>
				<div class='tab-content'>
					<div role='tabpanel' class='tab-pane active' id='basic_knots'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='basic_knots_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/basic_knots.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='advanced_knots'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='advanced_knots_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/advanced_knots.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='simple_rescue'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='simple_rescue_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/simple_rescue.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='advanced_rescue'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='advanced_rescue_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/advanced_rescue.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='gw_assessment'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='gw_assessment_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/gw_assessment.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='ge_assessment'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='ge_assessment_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/ge_assessment.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='senior_guide_assessment'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='senior_guide_assessment_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/senior_guide.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
					<div role='tabpanel' class='tab-pane' id='glacier_xtreme'>
						<form action='add_assessment.php?submit=true' method='post'>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Name:</span>
											<input type='text' class='form-control' name='guide_name' value='$GuideName' readonly='readonly'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-12'>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon min_width_150 text-left'>Assessment Date:</span>
											<input type='text' class='form-control' placeholder='Select a date...' value='".date("D M d Y")."' id='glacier_xtreme_assessment_date' required data-error='Start date cannot be empty.' readonly='readonly' name='assessment_date'>
										</div>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
							<div class='row black_text'>
								<div class='col-sm-12'>
									<div class='panel panel-danger'>
										<div class='panel-body'>";
											include "functions/assessments/glacier_xtreme.php";
											echo "
										</div>
									</div>
								</div>									
							</div>
						</form>
					</div>
				</div>	
			</div>
		</div>";
	} else {
		$GuideName = $_POST["guide_name"];
		$AssessmentName = $_POST["assessment_name"];
		$RoleRequired = $_POST["role_required"];
		$Date = $_POST["assessment_date"];
		$Date_day = substr($Date,8,2);
		$Date_month = substr($Date,4,3);
		$Date_month = date("m", strtotime($Date_month));
		$Date_year = substr($Date,11,4);
		$Date = date("Y-m-d", mktime(0,0,0,$Date_month,$Date_day,$Date_year));
		$Comments = $_POST["summary_report"];
		$Comments = mysqli_real_escape_string($connect, $Comments);	
		$Assessor = $_POST["assessor"];
		$Verdict = $_POST["verdict"];

		switch ($AssessmentName) {
			case "Advanced Knots":
			$NextDue = date('Y-m-d', strtotime("+ 3 months", strtotime($Date)));
			$NextDue = "'$NextDue'";
			break;
			case "Basic Knots":
			$NextDue = date('Y-m-d', strtotime("+ 3 months", strtotime($Date)));
			$NextDue = "'$NextDue'";
			break;
			case "Simple Rescue":
			$NextDue = date('Y-m-d', strtotime("+ 3 months", strtotime($Date)));
			$NextDue = "'$NextDue'";
			break;
			case "Advanced Rescue":
			$NextDue = date('Y-m-d', strtotime("+ 3 months", strtotime($Date)));
			$NextDue = "'$NextDue'";
			break;
			default:
			$NextDue = "NULL";
		}
		
		$criteria1 = $_POST["criteria1"];
		if ($criteria1 != "NULL") {$criteria1 = "'$criteria1'";}
		$criteria2 = $_POST["criteria2"];
		if ($criteria2 != "NULL") {$criteria2 = "'$criteria2'";}
		$criteria3 = $_POST["criteria3"];
		if ($criteria3 != "NULL") {$criteria3 = "'$criteria3'";}
		$criteria4 = $_POST["criteria4"];
		if ($criteria4 != "NULL") {$criteria4 = "'$criteria4'";}
		$criteria5 = $_POST["criteria5"];
		if ($criteria5 != "NULL") {$criteria5 = "'$criteria5'";}
		$criteria6 = $_POST["criteria6"];
		if ($criteria6 != "NULL") {$criteria6 = "'$criteria6'";}
		$criteria7 = $_POST["criteria7"];
		if ($criteria7 != "NULL") {$criteria7 = "'$criteria7'";}
		$criteria8 = $_POST["criteria8"];
		if ($criteria8 != "NULL") {$criteria8 = "'$criteria8'";}
		$criteria9 = $_POST["criteria9"];
		if ($criteria9 != "NULL") {$criteria9 = "'$criteria9'";}
		$criteria10 = $_POST["criteria10"];
		if ($criteria10 != "NULL") {$criteria10 = "'$criteria10'";}
		$criteria11 = $_POST["criteria11"];
		if ($criteria11 != "NULL") {$criteria11 = "'$criteria11'";}
		$criteria12 = $_POST["criteria12"];
		if ($criteria12 != "NULL") {$criteria12 = "'$criteria12'";}
		$criteria13 = $_POST["criteria13"];
		if ($criteria13 != "NULL") {$criteria13 = "'$criteria13'";}
		$criteria14 = $_POST["criteria14"];
		if ($criteria14 != "NULL") {$criteria14 = "'$criteria14'";}
		$criteria15 = $_POST["criteria15"];
		if ($criteria15 != "NULL") {$criteria15 = "'$criteria15'";}
		$criteria16 = $_POST["criteria16"];
		if ($criteria16 != "NULL") {$criteria16 = "'$criteria16'";}
		$criteria17 = $_POST["criteria17"];
		if ($criteria17 != "NULL") {$criteria17 = "'$criteria17'";}
		$criteria18 = $_POST["criteria18"];
		if ($criteria18 != "NULL") {$criteria18 = "'$criteria18'";}
		$criteria19 = $_POST["criteria19"];
		if ($criteria19 != "NULL") {$criteria19 = "'$criteria19'";}
		$criteria20 = $_POST["criteria20"];
		if ($criteria20 != "NULL") {$criteria20 = "'$criteria20'";}
		
		$verdict1 = $_POST["verdict1"];
		if ($verdict1 != "NULL") {$verdict1 = "'$verdict1'";}
		$verdict2 = $_POST["verdict2"];
		if ($verdict2 != "NULL") {$verdict2 = "'$verdict2'";}
		$verdict3 = $_POST["verdict3"];
		if ($verdict3 != "NULL") {$verdict3 = "'$verdict3'";}
		$verdict4 = $_POST["verdict4"];
		if ($verdict4 != "NULL") {$verdict4 = "'$verdict4'";}
		$verdict5 = $_POST["verdict5"];
		if ($verdict5 != "NULL") {$verdict5 = "'$verdict5'";}
		$verdict6 = $_POST["verdict6"];
		if ($verdict6 != "NULL") {$verdict6 = "'$verdict6'";}
		$verdict7 = $_POST["verdict7"];
		if ($verdict7 != "NULL") {$verdict7 = "'$verdict7'";}
		$verdict8 = $_POST["verdict8"];
		if ($verdict8 != "NULL") {$verdict8 = "'$verdict8'";}
		$verdict9 = $_POST["verdict9"];
		if ($verdict9 != "NULL") {$verdict9 = "'$verdict9'";}
		$verdict10 = $_POST["verdict10"];
		if ($verdict10 != "NULL") {$verdict10 = "'$verdict10'";}
		$verdict11 = $_POST["verdict11"];
		if ($verdict11 != "NULL") {$verdict11 = "'$verdict11'";}
		$verdict12 = $_POST["verdict12"];
		if ($verdict12 != "NULL") {$verdict12 = "'$verdict12'";}
		$verdict13 = $_POST["verdict13"];
		if ($verdict13 != "NULL") {$verdict13 = "'$verdict13'";}
		$verdict14 = $_POST["verdict14"];
		if ($verdict14 != "NULL") {$verdict14 = "'$verdict14'";}
		$verdict15 = $_POST["verdict15"];
		if ($verdict15 != "NULL") {$verdict15 = "'$verdict15'";}
		$verdict16 = $_POST["verdict16"];
		if ($verdict16 != "NULL") {$verdict16 = "'$verdict16'";}
		$verdict17 = $_POST["verdict17"];
		if ($verdict17 != "NULL") {$verdict17 = "'$verdict17'";}
		$verdict18 = $_POST["verdict18"];
		if ($verdict18 != "NULL") {$verdict18 = "'$verdict18'";}
		$verdict19 = $_POST["verdict19"];
		if ($verdict19 != "NULL") {$verdict19 = "'$verdict19'";}
		$verdict20 = $_POST["verdict20"];
		if ($verdict20 != "NULL") {$verdict20 = "'$verdict20'";}

		if ($Verdict == "Pass") {
			$clear_next_due = mysqli_query($connect, "UPDATE assessment_log SET NextDue = NULL WHERE AssessmentName = '$AssessmentName' AND GuideName = '$GuideName' AND Operator = '".$_SESSION["operator"]."'");
		} else {
			$NextDue == NULL;
		}
		$InsertAssessment = mysqli_query($connect, "INSERT INTO assessment_log (AssessmentLogID, Date, AssessmentName, AssessedBy, GuideName, Comments, Criteria1, Criteria2, Criteria3, Criteria4, Criteria5, Criteria6, Criteria7, Criteria8, Criteria9, Criteria10, Criteria11, Criteria12, Criteria13, Criteria14, Criteria15, Criteria16, Criteria17, Criteria18, Criteria19, Criteria20, Verdict1, Verdict2, Verdict3, Verdict4, Verdict5, Verdict6, Verdict7, Verdict8, Verdict9, Verdict10, Verdict11, Verdict12, Verdict13, Verdict14, Verdict15, Verdict16, Verdict17, Verdict18, Verdict19, Verdict20, Verdict, NextDue, RoleRequired, Operator) VALUES (NULL, '".$Date."', '".$AssessmentName."', '".$Assessor."', '".$GuideName."', '".$Comments."', ".$criteria1.", ".$criteria2.", ".$criteria3.", ".$criteria4.", ".$criteria5.", ".$criteria6.", ".$criteria7.", ".$criteria8.", ".$criteria9.", ".$criteria10.", ".$criteria11.", ".$criteria12.", ".$criteria13.", ".$criteria14.", ".$criteria15.", ".$criteria16.", ".$criteria17.", ".$criteria18.", ".$criteria19.", ".$criteria20.", ".$verdict1.", ".$verdict2.", ".$verdict3.", ".$verdict4.", ".$verdict5.", ".$verdict6.", ".$verdict7.", ".$verdict8.", ".$verdict9.", ".$verdict10.", ".$verdict11.", ".$verdict12.", ".$verdict13.", ".$verdict14.", ".$verdict15.", ".$verdict16.", ".$verdict17.", ".$verdict18.", ".$verdict19.", ".$verdict20.", '".$Verdict."', ".$NextDue.", '".$RoleRequired."', '".$_SESSION["operator"]."')");
		mysqli_error($connect);
		echo "
		<div class='well'>
			<h4>Assessment Log for $GuideName successfully updated.</h4>
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
		$mail->Subject  = "$AssessmentName Assessment Logged for $GuideName by $Assessor.";
		$mail->Body     = "$Verdict.";
		$mail->WordWrap = 50;
		if(!$mail->Send()) {
			echo 'Message was not sent.';
			echo 'Mailer error: ' . $mail->ErrorInfo;
		}

	}
} else {
	header('Location: index.php');
}
?>
</body>
</html>