<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Incident Reports</title>
	<?php include 'functions/meta_links.php';?>
	<link rel='stylesheet' href='functions/date_picker/css/pikaday.css'>
	<script src='functions/date_picker/pikaday.js'></script>
	<script src='libraries/validator/js/validator.js'></script>
</head>
<body>
	<?php
	session_start();
	echo "<div class='container-fluid'>";
	include 'navigation.php';
	if (!empty($_SESSION["username"])) {
		include 'functions/connect.php';
		if ($_GET['submit'] == "true") {
			$reportID = $_POST['report_id'];
			$incident_date = $_POST['incident_date'];
			$incident_date_day = substr($incident_date,8,2);
			$incident_date_month = substr($incident_date,4,3);
			$incident_date_month = date("m", strtotime($incident_date_month));
			$incident_date_year = substr($incident_date,11,4);
			$incident_date = date("Y-m-d", mktime(0,0,0,$incident_date_month,$incident_date_day,$incident_date_year));
			$departure_name = $_POST['departure_name'];
			$departure_time = $_POST['departure_time'];
			$incident_level = $_POST['incident_level'];
			$staff_involved = $_POST['staff_involved'];
			if (!isset($_POST['group_size'])) {$rain = 'Unspecified';} else {$group_size = $_POST['group_size'];}
			if (!isset($_POST['ascending_descending'])) {$ascending_descending = 'Unspecified';} else {$ascending_descending = $_POST['ascending_descending'];}
			$incident_location = $_POST['incident_location'];
			if (!isset($_POST['group_size'])) {$group_size = 'Unspecified';} else {$group_size = $_POST['group_size'];}
			if (!isset($_POST['client_name'])) {$client_name = 'Unspecified';} else {$client_name = $_POST['client_name'];}
			if (!isset($_POST['client_name'])) {$client_name = 'Unspecified';} else {$client_name = $_POST['client_name'];}
			if (!isset($_POST['client_age'])) {$client_age = 'Unspecified';} else {$client_age = $_POST['client_age'];}
			if (!isset($_POST['client_sex'])) {$client_sex = 'Unspecified';} else {$client_sex = $_POST['client_sex'];}
			if (!isset($_POST['client_nationality'])) {$client_nationality = 'Unspecified';} else {$client_nationality = $_POST['client_nationality'];}
			if (!isset($_POST['client_ability'])) {$client_ability = 'Unspecified';} else {$client_ability = $_POST['client_ability'];}
			if (!isset($_POST['client_email'])) {$client_email = 'Unspecified';} else {$client_email = $_POST['client_email'];}
			if (!isset($_POST['rain'])) {$rain = 'Unspecified';} else {$rain = $_POST['rain'];}
			if (!isset($_POST['wind'])) {$wind = 'Unspecified';} else {$wind = $_POST['wind'];}
			if (!isset($_POST['ice'])) {$wind = 'Unspecified';} else {$wind = $_POST['ice'];}
			if (!isset($_POST['temperature'])) {$temperature = 'Unspecified';} else {$temperature = $_POST['temperature'];}
			if (!isset($_POST['forecast'])) {$forecast = 'Unspecified';} else {$forecast = $_POST['forecast'];}
			if (!isset($_POST['ice'])) {$ice = 'Unspecified';} else {$ice = $_POST['ice'];}
			$incident_details = $_POST['incident_details'];
			$rescue_details = $_POST['rescue_details'];
			$first_aid_details = $_POST['first_aid_details'];
			$evacuation_details = $_POST['evacuation_details'];
			if (!isset($_POST['incident_cause'])) {$incident_cause = 'Unspecified';} else {$incident_cause = $_POST['incident_cause'];}
			
			$AddIncidentReportQuery = mysqli_query($connect, "INSERT INTO `incident_reports`(`ReportID`, `InvestigationID`, `IncidentDate`, `DepartureInvolved`, `IncidentTime`, `IncidentLocation`, `IncidentLevel`, `AscendingDescending`, `GuideInvolved`, `GroupSize`, `ClientInvolved`, `ClientName`, `ClientSex`, `ClientAge`, `ClientEmail`, `ClientNationality`, `ClientAbility`, `Rain`, `Wind`, `Ice`, `Temperature`, `Forecast`, `IncidentDetails`, `RopeRescue`, `RescueDetails`, `FirstAidRequired`, `FirstAidDetails`, `EvacuationRequired`, `EvacuationDetails`, `MainCause`, Operator) VALUES ('$reportID', NULL, '$incident_date', '$departure_name', '$departure_time', '$incident_location', '$incident_level', '$ascending_descending', '$staff_involved', '$group_size', '', '$client_name', '$client_sex', '$client_age', '$client_email', '$client_nationality', '$client_ability', '$rain', '$wind', '$ice', '$temperature', '$forecast', '$incident_details', '', '$rescue_details', '', '$first_aid_details', '', '$evacuation_details', '$incident_cause', '".$_SESSION["operator"]."') ON DUPLICATE KEY UPDATE ReportID = '$reportID', InvestigationID = 'NULL', IncidentDate = '$incident_date', DepartureInvolved = '$departure_name', IncidentTime = '$departure_time', IncidentLocation = '$incident_location', IncidentLevel = '$incident_level', AscendingDescending = '$ascending_descending', GuideInvolved = '$staff_involved', GroupSize = '$group_size', ClientInvolved = 'NULL', ClientName = '$client_name', ClientSex = '$client_sex', ClientAge = '$client_age', ClientEmail = '$client_email', ClientNationality = '$client_nationality', ClientAbility = '$client_ability', Rain = '$rain', Wind = '$wind', Ice = '$ice', Temperature = '$temperature', Forecast = '$forecast', IncidentDetails = '$incident_details', RopeRescue = '$rescue_details', RescueDetails = '', FirstAidRequired = '$first_aid_details', FirstAidDetails = '', EvacuationRequired = '$evacuation_details', EvacuationDetails = '', MainCause = '$incident_cause', Operator = '".$_SESSION["operator"]."'");
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h3>Incident report successfully saved!</h3>
						<p>The operations management team have been notified.</p>";
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
						$mail->Subject  = "Level '$incident_level' Reported";
						$mail->Body     = "$incident_details.";
						$mail->WordWrap = 50;
						if(!$mail->Send()) {
							echo ' Message was not sent.';
							echo 'Mailer error: ' . $mail->ErrorInfo;
						}
						echo "
					</div>
				</div>";
			} else {
				$GetLatestIncidentReportIDQuery = mysqli_query($connect, "SELECT MAX(ReportID) FROM incident_reports WHERE Operator = '".$_SESSION["operator"]."'");
				$GetLatestIncidentReportIDNumRows = mysqli_num_rows($GetLatestIncidentReportIDQuery);
				foreach ($GetLatestIncidentReportIDQuery as $value) {
					if ($value["MAX(ReportID)"] == NULL) {
						$ReportIDNumber = 1;
					} else {
						$ReportIDNumber = $value["MAX(ReportID)"];
						$ReportIDNumber ++;
					}
				}
				echo "
				<form role='form' data-toggle='validator' method='post' action='add_incident_report.php?submit=true' class='form-horizontal'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='well'>
								<h4>Add New Incident</h4>
							</div>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										Report ID Number $ReportIDNumber. Select the date, departure and time.
									</div>
									<input type='hidden' name='report_id' value='$ReportIDNumber'>
									<div class='panel-body'>
										<div class='col-sm-8'>
											<div class='form-group'>
												<select name='departure_name' class='form-control' data-error='Departure name required!' required>
													<option value='' disabled='disabled' selected='selected'>Select the name of the departure...</option>";
													$GetDeparturesQuery = mysqli_query($connect, "SELECT DISTINCT TripID FROM daily_diary_trips WHERE Operator = '".$_SESSION["operator"]."'");
													$GetDeparturesNumRows = mysqli_num_rows($GetDeparturesQuery);
													if ($GetDeparturesNumRows > 0) {
														foreach ($GetDeparturesQuery as $value) {
															echo "
															<option>".$value["TripID"]."</option>";
														}
													}
													echo "
													<option value='Other'>Other</option>
												</select>
												<div class='help-block with-errors'></div>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='departure_time' class='form-control' data-error='Departure time required!' required>
													<option value='' disabled='disabled' selected='selected'>Select departure time...</option>";
													$GetDepartureTimesQuery = mysqli_query($connect, "SELECT DISTINCT TripDepartureTime FROM daily_diary_trips WHERE Operator = '".$_SESSION["operator"]."'");
													$GetDepartureTimesNumRows = mysqli_num_rows($GetDepartureTimesQuery);
													if ($GetDepartureTimesNumRows > 0) {
														foreach ($GetDepartureTimesQuery as $value) {
															echo "
															<option>".$value["TripDepartureTime"]."</option>";
														}
													}
													echo "
													<option value='Other'>Other</option>
												</select>
												<div class='help-block with-errors'></div>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<input type='text' required data-error='Incident date required!' id='datepicker' name='incident_date' autocomplete='off' class='form-control' placeholder='Select the incident date...'>
												<div class='help-block with-errors'></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										Detail the incident level, location and staff/group information.
									</div>
									<div class='panel-body'>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='incident_level' class='form-control' data-error='Incident level required!' required>
													<option value='' disabled='disabled' selected='selected'>Select incident level...</option>
													<option>Near Miss</option>
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
												</select>
												<div class='help-block with-errors'></div>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='group_size' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Group size...</option>
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
													<option>5</option>
													<option>6</option>
													<option>7</option>
													<option>8</option>
													<option>9</option>
													<option>10</option>
													<option>11</option>
													<option>12</option>
													<option>13</option>
													<option>14</option>
													<option>15</option>
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='staff_involved' class='form-control' data-error='Staff involved required!' required>
													<option value='' disabled='disabled' selected='selected'>Who was involved?</option>";
													$GetStaffInvolved = mysqli_query($connect, "SELECT GuideName FROM guides WHERE Operator = '".$_SESSION["operator"]."'");
													foreach ($GetStaffInvolved as $value) {
														echo "<option>".$value["GuideName"]."</option>";
													}
													echo "
												</select>
												<div class='help-block with-errors'></div>
											</div>
										</div>
										<div class='col-sm-3'>
											<div class='form-group'>
												<select name='ascend_descend' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Were the group ascending or descending?</option>
													<option>Ascending</option>
													<option>Descending</option>
												</select>
											</div>
										</div>
										<div class='col-sm-3'>
											<div class='form-group'>
												<select name='incident_location' class='form-control' data-error='Location required!' required>
													<option value='' disabled='disabled' selected='selected'>Where did the incident occur?</option>
													<option>Kings Landing.</option>
													<option>At the Skaftafell booking office.</option>
													<option>In the car park outside the Skaftafell booking office.</option>
													<option>On route to the glacier car park.</option>
													<option>In the glacier car park.</option>
													<option>In the valley.</option>
													<option>Around the terminal face of the glacier.</option>
													<option>The lower section of Falljokull.</option>
													<option>The middle section of Falljokull.</option>
													<option>The upper section of Falljokull.</option>
													<option>Virkisjokull.</option>
													<option>Hvannadalshnjuker.</option>
													<option>Other.</option>
												</select>
												<div class='help-block with-errors'></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										If a client was involved, fill out their information.
									</div>
									<div class='panel-body'>
										<div class='col-sm-2'>
											<div class='form-group'>
												<input type='text' name='client_name' class='form-control' placeholder='Enter name of client...'>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='client_age' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Select client's age...</option>							
													<option>10-14</option>								
													<option>15-19</option>								
													<option>20-24</option>								
													<option>25-29</option>								
													<option>30-34</option>								
													<option>35-39</option>								
													<option>40-44</option>								
													<option>45-49</option>								
													<option>50-54</option>								
													<option>55-59</option>								
													<option>60-64</option>								
													<option>65+</option>								
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='client_sex' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Gender?</option>
													<option>Male</option>								
													<option>Female</option>								
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='client_nationality' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Nationality?</option>";
													include 'incident_reports/nationality_dropdown.php';
													echo "
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='client_ability' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Client's fitness/ability...</option>
													<option>Low</option>
													<option>Average</option>
													<option>High</option>
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<input type='text' name='client_email' class='form-control' placeholder='Enter client email address...'>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										Record the environmental conditions.
									</div>
									<div class='panel-body'>
										<div class='col-sm-3'>
											<div class='form-group'>
												<select name='rain' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Rain</option>
													<option>Low</option>
													<option>Moderate</option>
													<option>High</option>
													<option>Extreme</option>
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='wind' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Wind</option>
													<option>Low</option>
													<option>Moderate</option>
													<option>High</option>
													<option>Extreme</option>
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='temperature' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Temperature</option>
													<option>Low</option>
													<option>Moderate</option>
													<option>High</option>
													<option>Extreme</option>
												</select>
											</div>
										</div>
										<div class='col-sm-2'>
											<div class='form-group'>
												<select name='ice' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Ice</option>							
													<option>Low</option>
													<option>Moderate</option>
													<option>High</option>
													<option>Extreme</option>
												</select>
											</div>
										</div>
										<div class='col-sm-3'>
											<div class='form-group'>
												<select name='forecast' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Forecast</option>
													<option>Low</option>
													<option>Moderate</option>
													<option>High</option>
													<option>Extreme</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										Describe the incident in detail.
									</div>
									<div class='panel-body'>
										<div class='col-sm-12'>
											<div class='form-group'>
												<textarea class='form-control' rows='2' placeholder='Enter as much information about the incident as possible...' name='incident_details' data-error='Incident details required!' required></textarea>
												<div class='help-block with-errors'></div>
											</div>
										</div>
									</div>
									<div class='panel-body'>
										<div class='col-sm-12'>
											<div class='form-group'>
												<textarea class='form-control' rows='2' placeholder='If a rope rescue was involved, describe the details...' name='rescue_details'></textarea>
											</div>
										</div>
									</div>
									<div class='panel-body'>
										<div class='col-sm-12'>
											<div class='form-group'>
												<textarea class='form-control' rows='2' placeholder='Describe in detail any first aid administered...' name='first_aid_details'></textarea>
											</div>
										</div>
									</div>
									<div class='panel-body'>
										<div class='col-sm-12'>
											<div class='form-group'>
												<textarea class='form-control' rows='2' placeholder='If an evacuation was required, describe the details...' name='evacuation_details'></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default'>
									<div class='panel-heading'>
										What would you describe as the main cause for this incident?
									</div>
									<div class='panel-body'>
										<div class='col-sm-11'>
											<div class='form-group'>
												<select name='incident_cause' class='form-control'>
													<option value='' disabled='disabled' selected='selected'>Select the main cause of this incident...</option>
													<option>Tripping/Slipping.</option>
													<option>Rockfall.</option>
													<option>Icefall.</option>
													<option>Catching crampons.</option>
													<option>Disclosed pre-existing medical condition.</option>
													<option>Undisclosed pre-existing medical condition.</option>
													<option>Environmental factors.</option>
													<option>Equipment failure.</option>
													<option>Improper use of equipment.</option>
													<option>Client/Guide fitness or ability.</option>
													<option>Road traffic accident.</option>
													<option>Other.</option>
												</select>						
											</div>
										</div>
										<div class='col-sm-1'>
											<button type='submit' class='btn btn-success'>Submit</button>					
										</div>
									</form>		
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
		}
	} else {
		echo "not logged in";	
	}
	?>
</body>
</html>