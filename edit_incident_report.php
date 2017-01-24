<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Incident Report</title>
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
	$guide_involved = $_POST['guide_involved'];
	$group_size = $_POST['group_size'];
	$ascending_descending = $_POST['ascending_descending'];
	$incident_location = $_POST['incident_location'];
	$client_involved = $_POST['client_involved'];
	$client_name = $_POST['client_name'];
	$client_age = $_POST['client_age'];
	$client_sex = $_POST['client_sex'];
	$client_nationality = $_POST['client_nationality'];
	$client_ability = $_POST['client_ability'];
	$client_email = $_POST['client_email'];
	$rain = $_POST['rain'];
	$wind = $_POST['wind'];
	$temperature = $_POST['temperature'];
	$forecast = $_POST['forecast'];
	$ice = $_POST['ice'];
	$incident_details = $_POST['incident_details'];
	$rope_rescue = $_POST['rope_rescue'];
	$rescue_details = $_POST['rescue_details'];
	$first_aid_administered = $_POST['first_aid_administered'];
	$first_aid_details = $_POST['first_aid_details'];
	$evacuation_required = $_POST['evacuation_required'];
	$evacuation_details = $_POST['evacuation_details'];
	$incident_cause = $_POST['incident_cause'];	

	$AddIncidentReportQuery = mysql_query("UPDATE incident_reports SET IncidentDate = '$incident_date', DepartureInvolved = '$departure_name', IncidentTime = '$departure_time', IncidentLocation = '$incident_location', IncidentLevel = '$incident_level', AscendingDescending = '$ascending_descending', GuideInvolved = '$guide_involved', GroupSize = '$group_size', ClientInvolved = '$client_involved', ClientName = '$client_name', ClientSex = '$client_sex', ClientAge = '$client_age', ClientEmail = '$client_email', ClientNationality = '$client_nationality', ClientAbility = '$client_ability', Rain = '$rain', Wind = '$wind', Ice = '$ice', Temperature = '$temperature', Forecast = '$forecast', IncidentDetails = '$incident_details', RopeRescue = '$rope_rescue', RescueDetails = '$rope_rescue', FirstAidRequired = '$first_aid_administered', FirstAidDetails = '$first_aid_details', EvacuationRequired = '$evacuation_required', EvacuationDetails = '$evacuation_details', MainCause = '$incident_cause' WHERE ReportID = '$reportID'");
	echo "
	<div id='guide_schedule'>
		<div class='daily_agenda_success_header'>
			Incident report successfully saved.<br><br>Click here to print.
		</div>
	</div>";
} else {
	$incident_report_id = $_POST['report_id'];
	$GetIncidentReportDetailsQuery = mysqli_query($connect, "SELECT * FROM incident_reports WHERE ReportID = '$incident_report_id' AND Operator = '".$_SESSION["operator"]."'");
	while ($value = mysqli_fetch_assoc($GetIncidentReportDetailsQuery)) {
		$IncidentReport = $value;		
	}
	$incident_date = $IncidentReport["IncidentDate"];
	$departure_name = $IncidentReport["DepartureInvolved"];
	$departure_time = $IncidentReport["IncidentTime"];
	$incident_level = $IncidentReport["IncidentLevel"];
	$guide_involved = $IncidentReport["GuideInvolved"];
	$group_size = $IncidentReport["GroupSize"];
	$ascending_descending = $IncidentReport["AscendingDescending"];
	$incident_location = $IncidentReport["IncidentLocation"];
	$client_involved = $IncidentReport["ClientInvolved"];
	$client_name = $IncidentReport["ClientName"];
	$client_age = $IncidentReport["ClientAge"];
	$client_sex = $IncidentReport["ClientSex"];
	$client_nationality = $IncidentReport["ClientNationality"];
	$client_ability = $IncidentReport["ClientAbility"];
	$client_email = $IncidentReport["ClientEmail"];
	$rain = $IncidentReport["Rain"];
	$wind = $IncidentReport["Wind"];
	$temperature = $IncidentReport["Temperature"];
	$forecast = $IncidentReport["Forecast"];
	$ice = $IncidentReport["Ice"];
	$incident_details = $IncidentReport["IncidentDetails"];
	$rope_rescue = $IncidentReport["RopeRescue"];
	$rescue_details = $IncidentReport["RescueDetails"];
	$first_aid_administered = $IncidentReport["FirstAidRequired"];
	$first_aid_details = $IncidentReport["FirstAidDetails"];
	$evacuation_required = $IncidentReport["EvacuationRequired"];
	$evacuation_details = $IncidentReport["EvacuationDetails"];
	$incident_cause = $IncidentReport["MainCause"];

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
								Report ID Number $incident_report_id. Select the date, departure and time.
							</div>
							<input type='hidden' name='report_id' value='$incident_report_id'>
    						<div class='panel-body'>
								<div class='col-sm-8'>
									<div class='form-group'>
										<select name='departure_name' class='form-control' data-error='Departure name required!' required>
											<option value='$departure_name'>$departure_name</option>";
											$GetDeparturesQuery = mysqli_query($connect, "SELECT DISTINCT TripID FROM daily_diary_trips WHERE Operator = '".$_SESSION["operator"]."'");
											$GetDeparturesNumRows = mysqli_num_rows($GetDeparturesQuery);
											if ($GetDeparturesNumRows > 0) {
												foreach ($GetDeparturesQuery as $value) {
													echo "
													<option>".$value["TripID"]."</option>";
												}
											}
											echo "
										</select>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<select name='departure_time' class='form-control' data-error='Departure time required!' required>
											<option value='$departure_time'>$departure_time</option>";
											$GetDepartureTimesQuery = mysqli_query($connect, "SELECT DISTINCT TripDepartureTime FROM daily_diary_trips WHERE Operator = '".$_SESSION["operator"]."'");
											$GetDepartureTimesNumRows = mysqli_num_rows($GetDepartureTimesQuery);
											if ($GetDepartureTimesNumRows > 0) {
												foreach ($GetDepartureTimesQuery as $value) {
													echo "
													<option>".$value["TripDepartureTime"]."</option>";
												}
											}
											echo "
										</select>
										<div class='help-block with-errors'></div>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<input type='text' required data-error='Incident date required!' id='datepicker' name='incident_date' autocomplete='off' class='form-control' value='$incident_date'>
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
											<option value='$incident_level'>$incident_level</option>
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
											<option value='$group_size'>$group_size</option>
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
											<option value='$guide_involved'>$guide_involved</option>";
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
											<option value='$ascending_descending'>$ascending_descending</option>
											<option>Ascending</option>
											<option>Descending</option>
										</select>
									</div>
								</div>
								<div class='col-sm-3'>
									<div class='form-group'>
										<select name='incident_location' class='form-control' data-error='Location required!' required>
											<option value='$incident_location'>$incident_location</option>
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
										<input type='text' name='client_name' class='form-control' value='$client_name'>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<select name='client_age' class='form-control'>
											<option value='$client_age'>$client_age</option>							
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
											<option value='$client_sex'>$client_sex</option>
											<option>Male</option>								
											<option>Female</option>								
										</select>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<select name='client_nationality' class='form-control'>
											<option value='$client_nationality'>$client_nationality</option>";
											include 'incident_reports/nationality_dropdown.php';
											echo "
										</select>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<select name='client_ability' class='form-control'>
											<option value='$client_ability'>$client_ability</option>
											<option>Low</option>
											<option>Average</option>
											<option>High</option>
										</select>
									</div>
								</div>
								<div class='col-sm-2'>
									<div class='form-group'>
										<input type='text' name='client_email' class='form-control' value='$client_email'>
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
											<option value='$rain'>$rain</option>
											<option>Low</option>
											<option>Moderate</option>
											<option>High</option>
											<option>Extreme</option>
										</select>
									</div>
								</div>
								<div class='col-sm-3'>
									<div class='form-group'>
										<select name='wind' class='form-control'>
											<option value='$wind'>$wind</option>
											<option>Low</option>
											<option>Moderate</option>
											<option>High</option>
											<option>Extreme</option>
										</select>
									</div>
								</div>
								<div class='col-sm-3'>
									<div class='form-group'>
										<select name='temperature' class='form-control'>
											<option value='$temperature'>$temperature</option>									
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
											<option value='$forecast'>$forecast</option>
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
										<textarea class='form-control' rows='2' name='incident_details' data-error='Incident details required!' required>$incident_details</textarea>
										<div class='help-block with-errors'></div>
									</div>
								</div>
							</div>
	   	 					<div class='panel-body'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<textarea class='form-control' rows='2' name='rescue_details'>$rescue_details</textarea>
									</div>
								</div>
							</div>
    						<div class='panel-body'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<textarea class='form-control' rows='2' name='first_aid_details'>$first_aid_details</textarea>
									</div>
								</div>
							</div>
	   						<div class='panel-body'>
								<div class='col-sm-12'>
									<div class='form-group'>
										<textarea class='form-control' rows='2' name='evacuation_details'>$evacuation_details</textarea>
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
											<option value='$incident_cause'>$incident_cause</option>
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
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel-group'>
						<div class='panel panel-default'>
  							<div class='panel-heading'>
								Incident Sign Off
							</div>
   		 					<div class='panel-body black_text'>
								<div class='row'>
									<div class='col-sm-2'>
										<h5>Client Declaration:</h5>
									</div>
									<div class='col-sm-10'>
										<h5>By signing this form, you agree that the information above is accurate and release Glacier Guides from any liability.</h5>
									</div>
								</div>
								<div class='row'>
									<div class='col-sm-2'>
										<h5>Client Signature:</h5>
									</div>
									<div class='col-sm-3 incident_signature'>
										<h5>&nbsp</h5>
									</div>
									<div class='col-sm-2'>
										<h5>Guide Signature:</h5>
									</div>
									<div class='col-sm-3'>
									</div>
									<div class='col-sm-2 text-right'>
										<button type='submit' class='btn btn-primary' onclick='window.print();'>Print</button>
									</div>
								</div>
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