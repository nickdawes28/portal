<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Daily Agenda</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>  
	<script src='libraries/validator/js/validator.js'></script>
	<script src="functions/daily_agenda/daily_agenda_inc_dec.js"></script>
	<script>
		$(document).on("click", "a.submit_email", function(e) {
			e.preventDefault();
			var goAhead = confirm('Are you sure you want to send this message?');
			if (goAhead) {
				var this_btn = $(this);
				var email_addresses = this_btn.closest('.form_wrapper').find('.email_addresses').val();
				var email_content = this_btn.closest('.form_wrapper').find('.email_content').val();
				$.ajax({
					type: "POST",
					url: "functions/daily_agenda/submit_emails.php",
					data: {email_addresses : email_addresses, email_content : email_content},
					dataType: 'json',
					beforeSend: function() {
						this_btn.closest('.form_wrapper').find('.alert').html("Sending emails...");
					},
					success: function() {
						this_btn.closest('.form_wrapper').find('.alert').removeClass('alert-info');
						this_btn.closest('.form_wrapper').find('.alert').addClass('alert-success');
						this_btn.closest('.form_wrapper').find('.alert').html("The email was sent successfully!");
					}
				});
			}
		});
	</script>
	<script>
		$(document).on("click", "a.template_cancel", function(e) {
			e.preventDefault();
			var this_btn = $(this);
			var email_content = this_btn.closest('.form_wrapper').find('.email_content');
			email_content.text("Hello, This is a message from Glacier Guides to inform you that unfortunately due to severe weather forecast for the area tomorrow (09/12/2016), we have made the decision to cancel our departures. 

				Very strong rain is forecast for the area throughout the day, resulting in the flooding of the Crystal Ice Cave and preventing safe access. Although this is likely to be unwelcome news, your safety will always be our first priority. If you would like further information regarding the weather or road conditions, please visit en.vedur.is and www.road.is. We would be happy to discuss rescheduling your activity for another day - however we are not always able to guarantee availability as well as the future weather conditions. Additionally, you may prefer to book an alternative tour through our parent company, Arctic Adventures (www.adventures.is), who provide both sightseeing and adventure activity tours - unfortunately the glacier tours on Sólheimajökull are also cancelled for tomorrow (09/12/2016). If neither of these options are suitable and you would prefer a full refund please respond to this email at info@glacierguides.is. You are welcome to reply to this email or call our booking office on +354 562 7000 to discuss your options. We apologise on behalf of Icelandic nature and hope that you are able to join us another time! Kind regards, Glacier Guides Direct number: +354-659-7000 www.glacierguides.is");
		});
	</script>
	<script>
		$(document).ready(function() {  

			$('textarea[maxlength]').keyup(function(){  
				var limit = parseInt($(this).attr('maxlength'));  
				var text = $(this).val();  
				var chars = text.length;  

				if(chars > limit){  
					var new_text = text.substr(0, limit);  

					$(this).val(new_text);  
				}  
			});  

		}); 
	</script>
	<script>
		$(document).on("click", "a.submit_sms", function(e) {
			e.preventDefault();
			var goAhead = confirm('Are you sure you want to send this message?');
			if (goAhead) {
				var this_btn = $(this);
				var phone_numbers = this_btn.closest('.form_wrapper').find('.phone_numbers').val();
				var sms_content = this_btn.closest('.form_wrapper').find('.sms_content').val();
				$.ajax({
					type: "POST",
					url: "functions/daily_agenda/submit_sms.php",
					data: {phone_numbers : phone_numbers, sms_content : sms_content},
					dataType: 'json',
					beforeSend: function() {
						this_btn.closest('.form_wrapper').find('.alert').html("Sending SMS...");
					},
					success: function() {
						this_btn.closest('.form_wrapper').find('.alert').removeClass('alert-info');
						this_btn.closest('.form_wrapper').find('.alert').addClass('alert-success');
						this_btn.closest('.form_wrapper').find('.alert').html("The SMS messages were sent successfully!");
					}
				});
			}
		});
	</script>
	<link href="js/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="js/bootstrap-toggle-master/js/bootstrap-toggle.js"></script>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
	<?php
	session_start();
	if (!empty($_SESSION["username"])) {
		echo "<div class='container-fluid'>";
		include 'navigation.php';
		include 'functions/connect.php';
		$date = ($_GET["year"]."-".$_GET["month"]."-".$_GET["day"]);
		$date = date("Y-m-d", strtotime($date));
		$day = $_GET["day"];
		$month = $_GET["month"];
		$year = $_GET["year"];
		include 'functions/custom_hmac.php';
		include 'libraries/httpful.phar';
		include 'functions/access_key.php';
		$days_in_month_total = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$display_days_loop = $days_in_month_total;
		$display_days = 0;
		echo "
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well'>
					<h4>Daily Agenda</h4>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-4'>
				<div class='well text-center'>
					<a href='daily_agenda.php?day=1&month=".date('n', mktime(0, 0, 0, $month -1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month -1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month -1, 1, $year))."</a>
				</div>
			</div>
			<div class='col-sm-4'>
				<div class='well text-center'>
					<strong>".date('F Y', mktime(0, 0, 0, $month, 1, $year))."</strong>
				</div>
			</div>
			<div class='col-sm-4'>
				<div class='well text-center'>
					<a href='daily_agenda.php?day=1&month=".date('n', mktime(0, 0, 0, $month +1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month +1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month +1, 1, $year))."</a>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<div class='table-responsive'>
					<div class='table_fix'>
						<table class='table'>
							<tr class='daily_agenda_table_header'>
								<td colspan='$days_in_month_total'>
									<h4>
										<a href='daily_agenda.php?day=".date('j', mktime(0, 0, 0, $month, $day -1, $year))."&month=".date('n', mktime(0, 0, 0, $month, $day -1, $year))."&year=".date('Y', mktime(0, 0, 0, $month, $day -1, $year))."' class='standard_link'>«</a> ".date("l j. F, Y", strtotime($date))." <a href='daily_agenda.php?day=".date('j', mktime(0, 0, 0, $month, $day +1, $year))."&month=".date('n', mktime(0, 0, 0, $month, $day +1, $year))."&year=".date('Y', mktime(0, 0, 0, $month, $day +1, $year))."' class='standard_link'>»</a>
									</h4>
								</td>
							</tr>
							<tr>";
								while ($display_days_loop > 0) {
									$display_days++;
									echo "
									<td class='guides_schedule_cell_navigation_by_day'>
										<a href='daily_agenda.php?day=".$display_days."&month=$month&year=$year'>$display_days</a>
									</td>";
									$display_days_loop--;
								};
								echo "
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>";
		if ($config["environmental_conditions"] > 0) {
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='panel panel-default'>
						<div class='panel-heading text-center'>
							Environmental Conditions
						</div>
						<div class='panel-body black_text'>
							<form class='form-horizontal' action='environmental_conditions_success.php' method='post'>
								<input type='hidden' value='$date' name='date'>
								<input type='hidden' value='AM' name='time'>";
								include 'functions/daily_agenda/environmental_conditions.php';
								$CheckAMEnvironmentalConditions = mysqli_query($connect, "SELECT * FROM environmental_conditions WHERE Date = '".$date."' AND Time = 'AM' AND Operator = '".$_SESSION["operator"]."'");
								$CheckAMEnvironmentalConditionsNumRows = mysqli_num_rows($CheckAMEnvironmentalConditions);
								if ($CheckAMEnvironmentalConditionsNumRows > 0) {
									foreach ($CheckAMEnvironmentalConditions as $row) {
										$AMEnvironmentalConditions = $row;
									}
									$rain = $AMEnvironmentalConditions["Rain"];
									$wind = $AMEnvironmentalConditions["Wind"];
									$ice = $AMEnvironmentalConditions["Ice"];
									$temperature = $AMEnvironmentalConditions["Temperature"];
									$forecast = $AMEnvironmentalConditions["Forecast"];
									environmentalConditions($rain, $wind, $ice, $temperature, $forecast, "AM");
								} else {
									environmentalConditions("0", "0", "0", "0", "0", "AM");
								}
								echo "
							</form>
							<form class='form-horizontal' action='environmental_conditions_success.php' method='post'>
								<input type='hidden' value='$date' name='date'>
								<input type='hidden' value='PM' name='time'>";
								$CheckPMEnvironmentalConditions = mysqli_query($connect, "SELECT * FROM environmental_conditions WHERE Date = '".$date."' AND Time = 'PM' AND Operator = '".$_SESSION["operator"]."'");
								$CheckPMEnvironmentalConditionsNumRows = mysqli_num_rows($CheckPMEnvironmentalConditions);
								if ($CheckPMEnvironmentalConditionsNumRows > 0) {
									foreach ($CheckPMEnvironmentalConditions as $row) {
										$PMEnvironmentalConditions = $row;
									}
									$rain = $PMEnvironmentalConditions["Rain"];
									$wind = $PMEnvironmentalConditions["Wind"];
									$ice = $PMEnvironmentalConditions["Ice"];
									$temperature = $PMEnvironmentalConditions["Temperature"];
									$forecast = $PMEnvironmentalConditions["Forecast"];
									environmentalConditions($rain, $wind, $ice, $temperature, $forecast, "PM");
								} else {
									environmentalConditions("0", "0", "0", "0", "0", "PM");
								}
								echo "
							</form>
						</div>
					</div>
				</div>
			</div>";
		}
		include 'functions/daily_agenda/call_server.php';
		include 'functions/daily_agenda/get_available_guides.php';
		echo "
		<form role='form' data-toggle='validator' class='form-horizontal' role='form' method='post' action='daily_agenda_success.php?day=".$day."&month=".$month."&year=".$year."'>
			<input type='hidden' name='DailyAgendaDate' value='".$date."'>";
			foreach ($s["results"] as $row) {
				if ($row["vendor"]["title"] == $config["vendor"] && $row["status"] != "CANCELLED" && $row["product"]["title"] != "Glacier Grand Slam - Glacier Hike (Internal Use)") {
					if (isset($row["fields"]["startTimeStr"])) {
						$get_all_departures[] = (rtrim($row["product"]["title"]," ").$row["fields"]["startTimeStr"]);
					} else if (isset($row["fields"]["customizedStartTime"])) {
						$get_all_departures[] = (rtrim($row["product"]["title"]," ").$row["fields"]["customizedStartTime"]);
					}
				}
			}
			$get_all_unique_departures = array_unique($get_all_departures);
			$get_all_unique_departures = array_values($get_all_unique_departures);
			asort($get_all_unique_departures);
			$check_tour_matches_previous = "false";
			$email_modal_id = 1000;
			$sms_modal_id = 2000;
			$medical_modal_id = 3000;
			foreach ($get_all_unique_departures as $value_a) {
				++$email_modal_id;
				++$sms_modal_id;
				++$medical_modal_id;
				$departure_name = substr("$value_a", 0, -5);
				$departure_name = rtrim($departure_name, " ");
				$departure_time = substr("$value_a", -5);
				$total_participants = 0;
				$missing_emails = 0;
				$valid_emails = 0;
				$total_emails = 0;
				$missing_sms = 0;
				$valid_sms = 0;
				$total_sms = 0;
				$email_bcc_string = "";
				$phone_numbers = "";
				foreach ($s["results"] as $value_b) {
					if (rtrim($value_b["product"]["title"], " ") == $departure_name && ($value_b["fields"]["startTimeStr"] == $departure_time OR $value_b["fields"]["customizedStartTime"]) && $value_b["status"] != "CANCELLED") {
						$total_participants = ($total_participants + $value_b["fields"]["totalParticipants"]);
						$booking_references[] = array($value_b["productConfirmationCode"], $value_b["customer"]["firstName"], $value_b["customer"]["lastName"], $value_b["fields"]["totalParticipants"], $value_b["fields"]["bookedExtras"], $value_b["paidType"]);
						if ($value_b["customer"]["email"] == "") {
							++$missing_emails;
						} else {
							++$valid_emails;
							$email_bcc_string = ($email_bcc_string . $value_b["customer"]["email"] . " ");
						}
						if ($value_b["customer"]["phoneNumber"] == "") {
							++$missing_sms;
						} else {
							++$valid_sms;
							$phone_numbers = ($phone_numbers . "+" . str_replace("+", "", $value_b["customer"]["phoneNumber"]) . "@textmagic.com ");
						}
					}
				}
				$phone_numbers = rtrim($phone_numbers, ",");
				$total_emails = $valid_emails + $missing_emails;
				$total_sms = $valid_sms + $missing_sms;
				echo "
				<div id='myModal$email_modal_id' class='modal fade' role='dialog'>
					<div class='modal-dialog modal-lg black_text'>
						<div class='modal-content form_wrapper'>
							<input type='hidden' value='$email_bcc_string' class='email_addresses'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal'>&times;</button>
								<h4 class='modal-title'>Email all clients.</h4>
							</div>
							<div class='modal-body'>
								<div class='alert alert-info'>
									Enter your message and press submit.
								</div>
								<div class='alert alert-warning'>
									<a href='#' id='template_cancel' class='template_cancel btn btn-primary'>Cancellation Template</a>
								</div>
								<div class='form-group'>
									<div class='col-sm-12'>
										<textarea rows='15' class='form-control email_content' id='textarea$email_modal_id'>This is a message from ".$config["vendor"]."</textarea>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 text-center'>
										<a href='#' id='submit_email' class='submit_email btn btn-primary'>Submit</a>
									</div>
								</div>
							</div>
							<div class='modal-footer'>
								<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</div>
				</div>
				<div id='myModal$sms_modal_id' class='modal fade' role='dialog'>
					<div class='modal-dialog modal-lg black_text'>
						<div class='modal-content form_wrapper'>
							<input type='hidden' value='$phone_numbers' class='phone_numbers'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal'>&times;</button>
								<h4 class='modal-title'>Send an SMS to the clients.</h4>
							</div>
							<div class='modal-body'>
								<div class='alert alert-info'>
									Enter your message and press submit. Character limit is <b>160</b>!
								</div>
								<div class='form-group'>
									<div class='col-sm-12'>
										<textarea maxlength='160' rows='4' class='form-control sms_content' id='textarea$sms_modal_id'>Enter SMS...</textarea>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 text-center'>
										<a href='#' id='submit_sms' class='submit_sms btn btn-primary'>Submit</a>
									</div>
								</div>
							</div>
							<div class='modal-footer'>
								<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</div>
				</div>
				<div id='myModal$medical_modal_id' class='modal fade' role='dialog'>
					<div class='modal-dialog modal-lg black_text'>
						<div class='modal-content'>
							<div class='modal-header'>";
								$get_medical_forms = mysqli_query($connect, "SELECT * FROM medical_log WHERE DepartureName = '$departure_name' AND DepartureTime = '$departure_time' AND DepartureDate = '$date'");
								$medical_forms_num_rows = mysqli_num_rows($get_medical_forms);
								echo "
								<div class='well standard_link'>
									<button type='button' class='close' data-dismiss='modal'>&times;</button>
									<h4 class='modal-title'>$departure_name $departure_time ($total_participants people)</h4>
								</div>
							</div>
							<div class='modal-body'>
								<table class='table table-hover'>
									<thead>
										<tr>
											<th>Booking Ref</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th class='text-center'>Total Clients</th>
											<th class='text-center'>Medicals</th>
											<th class='text-center'>Arrived</th>
											<th>Payment Status</th>
										</tr>
									</thead>
									<tbody>";
										if ($medical_forms_num_rows > 0) {
											foreach ($get_medical_forms as $key => $value_c) {
												foreach ($s["results"] as $value_e) {
													if ($value_e["status"] != "CANCELLED" && $value_e["productConfirmationCode"] == $value_c["BookingReference"]) {
														$medical_forms_result[] = $value_c;
														$medical_forms = "true";
													}
												}
											}
										} else {
											$medical_forms = "false";
										}	
										if ($medical_forms != "false") {
											foreach ($medical_forms_result as $value) {
												foreach ($booking_references as $key => $value_d) {
													if ($value_d["0"] == $value["BookingReference"]) {
														unset($booking_references["$key"]);
													}
												}
												$tr_class = "alert-info";
												if ($value["AnkleInjuries"] == "Yes" OR $value["HeartConditions"] == "Yes" OR $value["Pregnancy"] == "Yes" OR $value["KneeInjuries"] == "Yes" OR $value["VisualImpairment"] == "Yes" OR $value["Epilepsy"] == "Yes" OR $value["JointReplacement"] == "Yes" OR $value["Diabetes"] == "Yes" OR $value["SevereAllergies"] == "Yes" OR $value["Dislocations"] == "Yes" OR $value["Asthma"] == "Yes" OR $value["PreviousSurgery"] == "Yes" OR $value["NeckBackInjuries"] == "Yes" OR $value["RespiratoryConditions"] == "Yes" OR $value["BloodPressureMedication"] == "Yes" OR $value["Medication"] != "None" OR $value["OtherMedicalConditions"] != "None") {
													$tr_class = "alert-danger";
												}
												echo "
												<tr class='$tr_class'>
													<td>".$value["BookingReference"]."</td>
													<td>".$value["FirstName"]."</td>
													<td>".$value["LastName"]."</td>
													<td class='text-center'>".$value["ClientCount"]."</td>
													<td>";
														$medical_issues = "false";
														if ($value["AnkleInjuries"] == "Yes") {echo "Ankle Injuries<br>"; $medical_issues = "true";}
														if ($value["HeartConditions"] == "Yes") {echo "Heart Conditions<br>"; $medical_issues = "true";}
														if ($value["Pregnancy"] == "Yes") {echo "Pregnancy<br>"; $medical_issues = "true";}
														if ($value["KneeInjuries"] == "Yes") {echo "Knee Injuries<br>"; $medical_issues = "true";}
														if ($value["VisualImpairment"] == "Yes") {echo "Visual Impairment<br>"; $medical_issues = "true";}
														if ($value["Epilepsy"] == "Yes") {echo "Epilepsy<br>"; $medical_issues = "true";}
														if ($value["JointReplacement"] == "Yes") {echo "Joint Replacement<br>"; $medical_issues = "true";}
														if ($value["Diabetes"] == "Yes") {echo "Diabetes<br>"; $medical_issues = "true";}
														if ($value["SevereAllergies"] == "Yes") {echo "Severe Allergies<br>"; $medical_issues = "true";}
														if ($value["Dislocations"] == "Yes") {echo "Dislocations<br>"; $medical_issues = "true";}
														if ($value["Asthma"] == "Yes") {echo "Asthma<br>"; $medical_issues = "true";}
														if ($value["PreviousSurgery"] == "Yes") {echo "Previous Surgery<br>"; $medical_issues = "true";}
														if ($value["NeckBackInjuries"] == "Yes") {echo "Neck or Back Injuries<br>"; $medical_issues = "true";}
														if ($value["RespiratoryConditions"] == "Yes") {echo "Respiratory Conditions<br>"; $medical_issues = "true";}
														if ($value["BloodPressureMedication"] == "Yes") {echo "Blood Pressure Medication<br>"; $medical_issues = "true";}
														if ($value["Medication"] == "Yes") {echo "Medication: ".$value["Medication"]."<br>"; $medical_issues = "true";}
														if ($value["OtherMedicalConditions"] == "Yes") {echo "Other Medical Conditions: ".$OtherMedicalConditions."<br>"; $medical_issues = "true";}
														if ($medical_issues == "false") {echo "None";}
														echo "
													</td>
													<td class='text-center'>
														<div class='toggle_container'>";
															$get_checkin_status = mysqli_query($connect, "SELECT * FROM checkin_status WHERE BookingReference = '".$value["BookingReference"]."'");
															$get_checkin_status_num_rows = mysqli_num_rows($get_checkin_status);
															if ($get_checkin_status_num_rows > 0) {
																foreach ($get_checkin_status as $value_f) {
																	$check_booking_reference = $value_f["BookingReference"];
																	$check_checkin_status = $value_f["CheckinStatus"];
																}
																if ($check_checkin_status == "yes") {
																	echo "
																	<input type='hidden' value='yes' class='toggle_state'>
																	<input type='hidden' value='".$value["BookingReference"]."' class='toggle_data'>
																	<input data-toggle='toggle' checked type='checkbox' data-on='Yes' data-off='No'>";
																} else {
																	echo "
																	<input type='hidden' value='no' class='toggle_state'>
																	<input type='hidden' value='".$value["BookingReference"]."' class='toggle_data'>
																	<input data-toggle='toggle' type='checkbox' data-on='Yes' data-off='No'>";
																}
															} else {
																echo "
																<input type='hidden' value='no' class='toggle_state'>
																<input type='hidden' value='".$value["BookingReference"]."' class='toggle_data'>
																<input data-toggle='toggle' type='checkbox' data-on='Yes' data-off='No'>";
															}
															echo "
														</div>
													</td>
													<td class='text-center'>";
														if ($value["PaidType"] == "PAID_IN_FULL") {
															echo "<span class='label label-success'>Paid in full.</span>";
														} else {
															echo "<span class='label label-warning'>Check in at desk.</span>";
														}
														echo "
													</td>
												</tr>";
											}
										}
										foreach ($booking_references as $value) { 
											echo "
											<tr>
												<td>".$value["0"]."</td>
												<td>".$value["1"]."</td>
												<td>".$value["2"]."</td>
												<td class='text-center'>".$value["3"]."</td>
												<td class='text-center'>?</td>
												<td class='text-center'>
													<div class='toggle_container'>";
														$get_checkin_status = mysqli_query($connect, "SELECT * FROM checkin_status WHERE BookingReference = '".$value["0"]."'");
														$get_checkin_status_num_rows = mysqli_num_rows($get_checkin_status);
														if ($get_checkin_status_num_rows > 0) {
															foreach ($get_checkin_status as $value_f) {
																$check_booking_reference = $value_f["BookingReference"];
																$check_checkin_status = $value_f["CheckinStatus"];
															}
															if ($check_checkin_status == "yes") {
																echo "
																<input type='hidden' value='yes' class='toggle_state'>
																<input type='hidden' value='".$value["0"]."' class='toggle_data'>
																<input data-toggle='toggle' checked type='checkbox' data-on='Yes' data-off='No'>";
															} else {
																echo "
																<input type='hidden' value='no' class='toggle_state'>
																<input type='hidden' value='".$value["0"]."' class='toggle_data'>
																<input data-toggle='toggle' type='checkbox' data-on='Yes' data-off='No'>";
															}
														} else {
															echo "
															<input type='hidden' value='no' class='toggle_state'>
															<input type='hidden' value='".$value["0"]."' class='toggle_data'>
															<input data-toggle='toggle' type='checkbox' data-on='Yes' data-off='No'>";
														}
														echo "
													</div>
												</td>
												<td class='text-center'>";
													if ($value["5"] == "PAID_IN_FULL") {
														echo "<span class='label label-success'>Paid in full.</span>";
													} else {
														echo "<span class='label label-warning'>Check in at desk.</span>";
													}
													echo "
												</td>
											</tr>";
											foreach ($value["4"] as $value_g) {
												echo "
												<tr class='alert alert-warning'>
													<td colspan='2'>
														<b>".$value_g["unitCount"] . "x</b> " .$value_g["extra"]["title"] ."
													</td>
													<td colspan='5'>
														<b>Sizes</b> ";
														$rental_count = count($value_g["answers"]);
														$rental_loop = 0;
														foreach ($value_g["answers"] as $value_h) {
															++$rental_loop;
															if ($rental_count == $rental_loop) {
																echo $value_h["answer"];
															} else {
																echo $value_h["answer"] . ", ";
															}
														}
														echo "
													</td>
												</tr>";
											}
										}
										unset($booking_references);
										unset($medical_forms_result);
										echo "	
									</tbody>
								</table>														    
							</div>
							<div class='modal-footer'>
								<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</div>
				</div>";
				if ($check_tour_matches_previous == "false") {
					echo "
					<div class='row'>
						<div class='col-sm-12'>
							<div class='panel-group'>
								<div class='panel panel-default padding_bottom_20px'>
									<div class='panel-heading daily_agenda_fix'>
										$departure_name
									</div>";
								} else if ($check_tour_matches_previous != "false" && $check_tour_matches_previous != $departure_name) {
									echo "
								</div>
							</div>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='panel-group'>
										<div class='panel panel-default padding_bottom_20px'>
											<div class='panel-heading daily_agenda_fix'>
												$departure_name
											</div>";
										}
										$check_tour_matches_previous = $departure_name;
										echo "	
										<div class='panel-body no_padding'>
											<div class='col-sm-4'>
												<div class='input-group'>
													<div class='input-group-btn'>
														<input type='hidden' value='$departure_time' name='TripDepartureTime[]'>
														<input type='hidden' name='TripID[]' value='$departure_name'>
														<button type='button' class='btn btn-primary min_width_100px'>$departure_time</button>
														<button type='button' class='btn btn-default dropdown-toggle daily_agenda_dropdown_fix' data-toggle='dropdown'>
															<span class='caret'></span>
															<span class='sr-only'>Toggle Dropdown</span>
														</button>
														<ul class='dropdown-menu'>";
															if ($total_emails == $valid_emails) {
																$EmailLinkSpan = "text-success";
															} else {
																$EmailLinkSpan = "text-important";	
															}
															if ($missing_emails == $total_emails) {
																echo "
																<li>
																	<a href='#' data-toggle='modal' data-target='#myModal$email_modal_id'>Email Clients (0/$total_emails)</a>
																</li>";
															} else {
																echo "
																<li>
																	<a href='#' data-toggle='modal' data-target='#myModal$email_modal_id'>Email Clients ($valid_emails/$total_emails)</a>
																</li>";
															}
															if ($total_sms == $valid_sms) {
																$SMSLinkSpan = "text-success";
															} else {
																$SMSLinkSpan = "text-important";	
															}
															if ($missing_sms == $total_sms) {
																echo "
																<li>
																	<a href='#' data-toggle='modal' data-target='#myModal$sms_modal_id'>SMS Clients (0/$total_sms)</a>
																</li>";
															} else {
																echo "
																<li>
																	<a href='#' data-toggle='modal' data-target='#myModal$sms_modal_id'>SMS Clients ($valid_sms/$total_sms)</a>
																</li>";
															}
															echo "
															<li><a href='#' data-toggle='modal' data-target='#myModal$medical_modal_id'>Get Passenger List</a></li>
														</ul>
														<button class='btn btn-success inc plus' type='button'>+</button>
														<button class='btn btn-danger inc' type='button'>-</button>
													</div>
													<div class='adjust_numbers'>
														<input type='text' class='form-control text-center adjust' readonly='readonly' value='$total_participants' name='ClientTotal[]'>
													</div>
												</div>
											</div>";
											$GetGuidesOnTours = mysqli_query($connect, "SELECT * FROM daily_diary_guides WHERE DailyDiaryTripID LIKE '%$date' AND Operator = '".$_SESSION["operator"]."'");
											$GetGuidesOnToursNumRows = mysqli_num_rows($GetGuidesOnTours);
											if ($GetGuidesOnToursNumRows > 0) {
												foreach ($GetGuidesOnTours as $value) {
													$GuideName[] = $value;
												}
											}
											$GuidesOnToursCount = 0;
											$SelectBoxes = 5;
											$SelectBoxesLoop = 0;
											while ($SelectBoxes > $SelectBoxesLoop) {
												$MatchGuide = "false";
												++$SelectBoxesLoop;
												if ($GetGuidesOnToursNumRows > 0) {
													foreach ($GuideName as $value) {
														if ((strpos($value["DailyDiaryTripID"],$departure_name)) !== false && (strpos($value["DailyDiaryTripID"],$departure_time)) !== false && $value["SelectBoxPosition"] == $SelectBoxesLoop) {
															echo "
															<div class='col-sm-1'>
																<div class='form-group'>
																	<select class='form-control' name='Guide[]'>
																		<option value='".$departure_name.$departure_time.$date.",".$value["GuideName"].",".$SelectBoxesLoop."' selected='selected'>".$value["GuideName"]."</option>";
																		foreach ($AvailableGuides as $SelectGuide) {
																			echo "
																			<option value='".$departure_name.$departure_time.$date.",".$SelectGuide["GuideName"].",".$SelectBoxesLoop."'>".$SelectGuide["GuideName"]."</option>";
																		}
																		echo "
																	</select>
																</div>
															</div>";
															$MatchGuide = "true";
															break;
														}
													}
												}
												if ($MatchGuide == "false") {
													echo "
													<div class='col-sm-1'>
														<div class='form-group'>
															<select class='form-control' name='Guide[]'>
																<option value='' disabled='disabled' selected='selected'>Select guide...</option>";
																foreach ($AvailableGuides as $SelectGuide) {
																	echo "
																	<option value='".$departure_name.$departure_time.$date.",".$SelectGuide["GuideName"].",".$SelectBoxesLoop."'>".$SelectGuide["GuideName"]."</option>";
																}
																echo "
															</select>
														</div>
													</div>";
												}
											}
											echo "
											<div class='col-sm-3'>
												<div class='form-group no_right_margin'>
													<select class='form-control' name='Status[]'>
														<option value='No'>Running as scheduled!</option>
														<option value='Yes'>Cancelled</option>
													</select>
												</div>
											</div>
										</div>";
									}
									echo "
								</div>
							</div>
							<div class='row text-right'>";
								if ($_SESSION["priviledge"] == "admin") {
									echo "
									<div class='col-sm-10'>		
									</div>
									<div class='col-sm-1'>
										<button type='submit' class='btn btn-success'>Submit</button>
									</div>";
								}
								echo "
							</div>
						</form>";
						if ($_SESSION["priviledge"] == "admin") {
							echo "
							<div class='row text-right'>
								<div class='col-sm-12'>
									<form action='daily_agenda_success.php?day=$day&month=$month&year=$year' method='post'>
										<input type='hidden' name='delete_agenda' value='$date'>
										<button type='submit' class='btn btn-danger'>Delete Agenda</button>
									</form>
								</div>
							</div>";
						}
					} else {
						header('Location: index.php');
					}
					?>
				</body>
				</html>