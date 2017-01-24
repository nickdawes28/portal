<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Comms</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="libraries/jQuery.js"></script>
	<script src="libraries/bootstrap.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
	<?php
	session_start();
	if (!empty($_SESSION["username"])) {
		include 'functions/connect.php';
		$event = $_GET["event"];
		echo 
		"<div class='container-fluid'>";
		include 'navigation.php';
		switch ($event) {
			case "daily_summary":
			$event = "Daily Summary";
			if ($_GET["submit"] == "true") {
				$date = date("d-m-Y");
				$departures = $_POST["departures"];
				if ($departures == "") { $departures = "-"; };
				$vehicles = $_POST["vehicles"];
				if ($vehicles == "") { $vehicles = "-"; };
				$ice_caves = $_POST["ice_caves"];
				if ($ice_caves == "") { $ice_caves = "-"; };
				$tracks = $_POST["tracks"];
				if ($tracks == "") { $tracks = "-"; };
				$staff = $_POST["staff"];
				if ($staff == "") { $staff = "-"; };
				$equipment = $_POST["equipment"];
				if ($equipment == "") { $equipment = "-"; };
				$facilities = $_POST["facilities"];
				if ($facilities == "") { $facilities = "-"; };
				$other = $_POST["other"];
				if ($other == "") { $other = "-"; };
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
				$recipients = explode(" ", $config["email_add_cc"]);
				foreach ($recipients as $email_address)	{
					$mail->AddCC("".$email_address."");
				}
				$mail->Subject  = "".$config["brand"]." Daily Summary $date";
				$mail->Body     = "
				<table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
					<tr>
						<td align='center' valign='top'>
							<table border='0' cellpadding='20' cellspacing='0' width='740' id='emailContainer'>
								<tr>
									<td align='center' valign='top'>
										<table border='0' cellpadding='20' cellspacing='0' width='100%' id='emailBody'>
											<tr>
												<td align='center' valign='top'>
													<img src='http://213.213.140.146/images/".$_SESSION["operator"]."_logo_small.jpg'><br><br>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 22px;'>
														Good evening!
														<br><br>
													</span>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 16px;'>
														This is a summary of today's events in ".$config["location"].".
														<br>
													</span>
												</td>
											</tr>
											<tr align='left'>
												<td>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 14px;'>
														<b>Departures</b><br>
														$departures
														<br><br>
														<b>Vehicles</b><br>
														$vehicles
														<br><br>
														<b>Ice Caves</b><br>
														$ice_caves
														<br><br>
														<b>Tracks</b><br>
														$tracks
														<br><br>
														<b>Staff</b><br>
														$staff
														<br><br>
														<b>Equipment</b><br>
														$equipment
														<br><br>
														<b>Facilities</b><br>
														$facilities
														<br><br>
														<b>Other comments.</b><br>
														$other
														<br><br><br>
														- ".ucfirst($_SESSION["username"])."
													</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>";
				$mail->IsHTML(true);  
				$mail->WordWrap = 50;
				if(!$mail->Send()) {
					echo ' Message was not sent.';
					echo 'Mailer error: ' . $mail->ErrorInfo;
				}
				?>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Daily update sent successfully!</h4>
						</div>
					</div>
				</div>
				<?php
			} else {
				?>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4><?php echo $event ?></h4>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<form class="form-horizontal black_text" action="comms.php?event=daily_summary&submit=true" method="post">
							<fieldset>
								<label class="col-sm-2 control-label" for="departures">Departures</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="departures" name="departures" placeholder="Were there any issues with departures today? Examples might include groups arriving late, timing of the tours not working etc."></textarea>
								</div>
								<label class="col-sm-2 control-label" for="vehicles">Vehicles</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="vehicles" name="vehicles" placeholder="What is the current status of the vehicles in use? Anything that might become an issue in the near future?"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="ice_caves">Ice Caves</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="ice_caves" name="ice_caves" placeholder="What is the status of the ice caves? Be sure to include details of all caves- if there is no change, say that there is no change!"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="tracks">Tracks</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="tracks" name="tracks" placeholder="General summary of tracks. Any areas becomming particularly problematic? What are we doing to fix these?"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="staff">Staff</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="staff" name="staff" placeholder="Any staff related issues. For example are we short staffed? Is there a legitimate moral issue that needs remedying?"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="equipment">Equipment</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="equipment" name="equipment" placeholder="Would we benefit from any additional equipment? Is the equipment we have not working? Think operation-wide: radios, equipment management tools (barrels, drying facilities etc). What could make life easier?"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="facilities">Facilities</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="facilities" name="facilities" placeholder="How are the facilities working? Is the setup appropriate for the size of the team we employ?"></textarea>
								</div>
								<label class="col-sm-2 control-label" for="other">Other comments.</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="other" name="other" placeholder="Anything else to add?"></textarea>
								</div>
								<div class="col-sm-12 text-center">
									<button id="singlebutton" name="singlebutton" class="btn btn-success">Submit Email</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<?php
			}
			break;
			case "cancellation_notice":
			$event = "Cancellation Notice";
			if ($_GET["submit"] == "true") {
				$departures_affected = $_POST["departures_affected"];
				if ($departures_affected == "") { $departures_affected = "-"; };
				$date = $_POST["date"];
				if ($date == "") { $date = "-"; };
				$reason = $_POST["reason"];
				if ($reason == "") { $reason = "-"; };
				$options = $_POST["options"];
				if ($options == "") { $options = "-"; };
				$clients_informed = $_POST["clients_informed"];
				if ($clients_informed == "") { $clients_informed = "-"; };
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
				$recipients = explode(" ", $config["email_add_cc"]);
				foreach ($recipients as $email_address)	{
					$mail->AddCC("".$email_address."");
				}
				$mail->Subject  = "".$config["brand"]." Cancellation Notice";
				$mail->Body     = "
				<table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
					<tr>
						<td align='center' valign='top'>
							<table border='0' cellpadding='20' cellspacing='0' width='740' id='emailContainer'>
								<tr>
									<td align='center' valign='top'>
										<table border='0' cellpadding='20' cellspacing='0' width='100%' id='emailBody'>
											<tr>
												<td align='center' valign='top'>
													<img src='http://213.213.140.146/images/".$_SESSION["operator"]."_logo_small.jpg'><br><br>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 22px;'>
														Hello!
														<br><br>
													</span>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 16px;'>
														This is a cancellation notice from ".$config["brand"].".
														<br>
													</span>
												</td>
											</tr>
											<tr align='left'>
												<td>
													<span style='font-family: Arial, Helvetica, sans-serif; font-size: 14px;'>
														<b>Which date is affected?</b><br>
														$date
														<br><br>
														<b>Which departures are affected?</b><br>
														$departures_affected
														<br><br>
														<b>What is the reason for the cancellation?</b><br>
														$reason
														<br><br>
														<b>Have the clients been informed?</b><br>
														$clients_informed
														<br><br>
														<b>What alternatives are we offering?</b><br>
														$options
														<br><br><br>
														- ".ucfirst($_SESSION["username"])."
													</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>";
				$mail->IsHTML(true);  
				$mail->WordWrap = 50;
				if(!$mail->Send()) {
					echo ' Message was not sent.';
					echo 'Mailer error: ' . $mail->ErrorInfo;
				}
				?>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Cancellation notice sent successfully!</h4>
						</div>
					</div>
				</div>
				<?php
			} else {
				?>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4><?php echo $event ?></h4>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<form class="form-horizontal black_text" action="comms.php?event=cancellation_notice&submit=true" method="post">
							<fieldset>
								<label class="col-sm-2 control-label" for="date">Cancellation for which date?</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea rows="1" class="form-control" id="date" name="date"><?php echo date("d-m-Y", strtotime(date("d-m-Y") . '+ 1 day'))?></textarea>
								</div>
								<label class="col-sm-2 control-label" for="departures_affected">Departures affected:</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="departures_affected" name="departures_affected" placeholder="Which departures are affected by the cancellation? Remember to include individual departure times."></textarea>
								</div>
								<label class="col-sm-2 control-label" for="reason">Reason</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="reason" name="reason" placeholder="What is the reason for the cancellation? Please provide details."></textarea>
								</div>
								<label class="col-sm-2 control-label" for="clients_informed">Have the clients been informed?</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<select id="clients_informed" name="clients_informed" class="form-control">
										<option value="No">No</option>
										<option value="Yes">Yes</option>
									</select>
								</div>
								<label class="col-sm-2 control-label" for="options">What alternatives have been offered?</label>
								<div class="col-sm-10 margin_bottom_10px">                     
									<textarea class="form-control" id="options" name="options" placeholder="Rescheduling? Other Arctic Adventures tours? Full refund?"></textarea>
								</div>
								<div class="col-sm-12 text-center">
									<button id="singlebutton" name="singlebutton" class="btn btn-success">Submit Email</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<?php
			}
			break;
		}
	} else {
		echo "must be logged in";	
	}
	?>