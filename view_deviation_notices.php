<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Deviation Notices</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="libraries/jQuery.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="functions/date_picker/css/pikaday.css">
</head>
<body>
<?php
session_start();
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	include 'functions/connect.php';
	
	if ($_GET['deviationID'] == "0") {
		echo "
		<div id='daily_agenda_wrapper'>
			<div id='daily_agenda'>
				<div class='daily_agenda_header'>
					View previous deviation notices.
				</div>
				<div class='incident_report_header'>
				</div>";
				$GetDeviationReportsQuery = mysql_query("SELECT * FROM deviation_log");
				$GetDeviationReportsNumRows = mysql_num_rows($GetDeviationReportsQuery);
				$GetDeviationReportsLoop = 0;
				echo "
				<div class='incident_report_search_results_container'>";
					if ($GetDeviationReportsNumRows > 0) {
						while ($GetDeviationReportsLoop < $GetDeviationReportsNumRows) {
							$DeviationIDNumber = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"DeviationID");
							$DeviationDate = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"DeviationDate");
							$StaffInvolved = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"StaffInvolved");
							$StaffReporting = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"StaffReporting");
							$Procedure = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"ProcedureDescription");
							$DeviationDetails = mysql_result($GetDeviationReportsQuery,$GetDeviationReportsLoop,"DeviationDetails");
							echo "
							<form action='view_deviation_notices.php?deviationID=$DeviationIDNumber' method='post'>
								<input type='hidden' value='$DeviationIDNumber' name='deviation_report_id'>
								<div class='incident_report_search_results_row'>
									<div class='incident_report_search_results_data'>
										Deviation ID:
									</div>
									<div class='incident_report_search_results_reportIDNumber'>
										$DeviationIDNumber
									</div>
									<div class='incident_report_search_results_data_small'>
										Date:
									</div>
									<div class='incident_report_search_results_reportIDNumber'>
										$DeviationDate
									</div>
									<div class='incident_report_search_results_data'>
										Staff involved:
									</div>
									<div class='incident_report_search_results_field_smaller_center'>
										$StaffInvolved
									</div>
									<div class='incident_report_search_results_data'>
										Staff reporting:
									</div>
									<div class='incident_report_search_results_field_smaller_center'>
										$StaffReporting
									</div>
									<div class='incident_report_search_results_data_small'>
										Procedure:
									</div>
									<div class='incident_report_search_results_field_procedure'>
										$Procedure
									</div>
									<input type='submit' class='incident_report_search_results_view_report' value=''>
								</div>
							</form>";
							$GetDeviationReportsLoop ++;
						}
					echo "
				</div>
				<div class='guides_schedule_footer'>
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>";
					} else {
						echo "No results.";	
					}
	echo "
	<script src='functions/date_picker/pikaday.js'></script>
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
			$DeviationID = $_GET["deviationID"];
			$GetDeviationDetailsQuery = mysql_query("SELECT * FROM deviation_log WHERE DeviationID = '$DeviationID'");
			$GetDeviationDetailsNumRows = mysql_num_rows($GetDeviationDetailsQuery);
			if ($GetDeviationDetailsNumRows > 0) {
				$DeviationDate = mysql_result($GetDeviationDetailsQuery,0,"DeviationDate");
				$StaffInvolved = mysql_result($GetDeviationDetailsQuery,0,"StaffInvolved");
				$StaffReporting = mysql_result($GetDeviationDetailsQuery,0,"StaffReporting");
				$Procedure = mysql_result($GetDeviationDetailsQuery,0,"ProcedureDescription");
				$IncidentDetails = mysql_result($GetDeviationDetailsQuery,0,"DeviationDetails");
				echo "
				<div id='daily_agenda_wrapper'>
					<div id='daily_agenda'>
						<div class='daily_agenda_header'>
							View 'Deviation From Procedure' Notice
						</div>
						<div class='incident_report_header'>
							Use the fileds below to complete the deviation report.
						</div>
						<div class='incident_report_section'>
							<div class='incident_report_section_row'>
								Use the box to select the date.
								<input type='text' class='incident_report_field' id='datepicker' name='deviation_date' autocomplete='off' readonly='readonly' value='$DeviationDate'>
							</div>
						</div>
				<div class='incident_report_section'>
					<div class='incident_report_section_row'>
						Select the staff member involved.
						<select class='incident_report_field' name='staff_involved'>
							<option>$StaffInvolved</option>
						</select>
					</div>
				</div>
				<div class='incident_report_section'>
					<div class='incident_report_section_row'>
						Staff member reporting.
						<input type='text' class='incident_report_field' value='$StaffReporting' name='staff_reporting' readonly='readonly'>
					</div>
				</div>
				<div class='incident_report_section_wide'>
					<div class='incident_report_section_row_wider'>
						Select the category relating to the procedure deviated from. Procedures must be formally written into the SMP or staff contract to be considered.
						<select class='incident_report_field' name='procedure'>
							<option>$Procedure</option>
						</select>
					</div>
				</div>
				<div class='incident_report_section_wide'>
					<div class='incident_report_section_row_wide'>
						Incident details.
						<textarea name='incident_details' class='incident_report_incident_details_textarea' readonly='readonly'>$IncidentDetails</textarea>
					</div>
				</div>
				<div class='guides_schedule_footer'>
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
				<script src='functions/date_picker/pikaday.js'></script>
				<script>
					var picker = new Pikaday(
					{
					field: document.getElementById('datepicker'),
					firstDay: 1,
					minDate: new Date(2000, 0, 1),
					maxDate: new Date(2020, 12, 31),
					yearRange: [2000,2020]
					});
				</script>
			</div>
		</div>";				
			} else {
				echo "
				No results.";	
			}
		
	}
} else {
	echo "not logged in";	
}
?>
</body>
</html>