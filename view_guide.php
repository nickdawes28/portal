<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>View Guide Details</title>
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
	if (!empty($_SESSION["username"])) {
		echo "<div class='container-fluid'>";
		include 'navigation.php';
		include 'functions/connect.php';	
		$submit = $_GET["submit"];
		if ($submit == "false") {
			$query = mysqli_query($connect, "SELECT GuideName FROM guides WHERE end_date > '".date("Y-m-d")."' AND Operator = '".$_SESSION["operator"]."'");
			foreach ($query as $value) {
				$GuideName[] = $value;
			}
			echo "
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Select Guide</h4>
					</div>
				</div>
			</div>
			<form role='form' data-toggle='validator' method='post' action='view_guide.php?submit=true'>
				<div class='row black_text'>
					<div class='col-sm-12'>
						<div class='form-group'>
							<div class='input-group'>
								<span class='input-group-addon min_width_150 text-left'>Select Guide:</span>
								<select class='form-control' name='guide_name'>";
									foreach ($GuideName as $value) {					
										echo "
										<option>".$value["GuideName"]."</option>";
									} 
									echo "
								</select>
								<span class='input-group-btn'>
									<button type='submit' class='btn btn-success'>Submit</button>
								</span>
							</div>
						</div>
					</div>		
				</form>
			</div>";
		} else {
			if ($submit == "update") {
				$staffName = $_POST["staff_name"];
				$staffEmail = "";
				if (isset($_POST["staff_email"])) {
					$staffEmail = $_POST["staff_email"];
				}
				$staffRole = $_POST["staff_role"];
				$staffPrivilege = $_POST["staff_privilege"];
				$staffStartDate = $_POST["start_date"];
				$staffStartDate_day = substr($staffStartDate,8,2);
				$staffStartDate_month = substr($staffStartDate,4,3);
				$staffStartDate_month = date("m", strtotime($staffStartDate_month));
				$staffStartDate_year = substr($staffStartDate,11,4);
				$staffStartDate = date("Y-m-d", mktime(0,0,0,$staffStartDate_month,$staffStartDate_day,$staffStartDate_year));
				$staffEndDate = $_POST["end_date"];
				if ($staffEndDate != "") {
					$staffEndDate_day = substr($staffEndDate,8,2);
					$staffEndDate_month = substr($staffEndDate,4,3);
					$staffEndDate_month = date("m", strtotime($staffEndDate_month));
					$staffEndDate_year = substr($staffEndDate,11,4);
					$staffEndDate = date("Y-m-d", mktime(0,0,0,$staffEndDate_month,$staffEndDate_day,$staffEndDate_year));
				} else {
					$staffEndDate = "2020-01-01";	
				}
				$staffLicense = $_POST["staff_license"];
				$UpdateGuides = mysqli_query($connect, "UPDATE guides SET Role = '$staffRole', start_date = '$staffStartDate', end_date = '2020-01-01' WHERE GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");
				$UpdateAbilityLevel = mysqli_query($connect, "UPDATE guide_abilities SET Ability = '$staffRole' WHERE DisplayOrder = 'a' AND GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");
				mysqli_error($connect);
				$UpdatePriviledge = mysqli_query($connect, "UPDATE users SET Priviledge = '$staffPrivilege' WHERE Username = '$staffName' AND Operator = '".$_SESSION["operator"]."'");
				mysqli_error($connect);
				if ($staffLicense != "None") {
					$delete_license = mysqli_query($connect, "DELETE FROM guide_abilities WHERE Ability IN ('big_bus', 'small_bus') AND GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");	
					$insert_license = mysqli_query($connect, "INSERT INTO guide_abilities (Ability, GuideName, DisplayOrder, Operator) VALUES ('$staffLicense', '$staffName', 'b', '".$_SESSION["operator"]."')");
					mysqli_error($connect);
				} else {
					$delete_license = mysqli_query($connect, "DELETE FROM guide_abilities WHERE Ability IN ('big_bus', 'small_bus') AND GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");	
				}
				$UpdateDate = mysqli_query($connect, "UPDATE guides SET start_date = '$staffStartDate', end_date = '$staffEndDate' WHERE GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");
				mysqli_error($connect);
				$delete_abilities = mysqli_query($connect, "DELETE FROM guide_abilities WHERE Ability IN ('first_responder', 'summit', 'ice_climbing') AND GuideName = '$staffName' AND Operator = '".$_SESSION["operator"]."'");
				if (isset($_POST["staff_ability"])) {
					$staffAbility = $_POST["staff_ability"];
					mysqli_error($connect);
					foreach ($staffAbility as $value) {
						switch($value) {
							case "first_responder":
							$display_order = "c";
							break;
							case "summit":
							$display_order = "e";
							break;
							case "ice_climbing":
							$display_order = "d";
							break;
						}
						$insert_ability = mysqli_query($connect, "INSERT INTO guide_abilities (Ability, GuideName, DisplayOrder, Operator) VALUES ('$value', '$staffName', '$display_order', '".$_SESSION["operator"]."')");
					}
				}
				echo "
				<div class='well'>
					<h4>Details for $staffName successfully updated.</h4>
				</div>";
			} else {
				$GuideName = $_POST["guide_name"];
				$GetAbilities = mysqli_query($connect, "SELECT * FROM guide_abilities WHERE GuideName = '$GuideName' AND Operator = '".$_SESSION["operator"]."'");
				if (mysqli_num_rows($GetAbilities) > 0) {
					while ($row = mysqli_fetch_assoc($GetAbilities)) {
						$GuideAbilities[] = $row["Ability"];
					}
				}
				$GetDetails = mysqli_query($connect, "SELECT * FROM guides WHERE GuideName = '$GuideName' AND Operator = '".$_SESSION["operator"]."'");
				while ($row = mysqli_fetch_assoc($GetDetails)) {
					$GuideDetails = $row;	
				}
				$GetPriviledge = mysqli_query($connect, "SELECT * FROM users WHERE username = '$GuideName' AND Operator = '".$_SESSION["operator"]."'");
				while ($row = mysqli_fetch_assoc($GetPriviledge)) {
					$GuidePriviledge = $row["Priviledge"];					
				}
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>View Guide Details</h4>
						</div>
					</div>
				</div>
				<form role='form' data-toggle='validator' method='post' action='view_guide.php?submit=update'>
					<div class='row black_text'>
						<div class='col-sm-12'>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon min_width_150 text-left'>Name:</span>
									<input type='text' class='form-control' value='$GuideName' name='staff_name' readonly='readonly'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
							<div class='input-group'>
								<span class='input-group-addon min_width_150 text-left'>Email:</span>
								<input type='email' class='form-control' placeholder='An email address to contact them on.' name='staff_email'>
							</div>
							<div class='input-group'>
								<span class='input-group-addon min_width_150 text-left'>Role:</span>
								<select class='form-control' name='staff_role'>";
									switch($GuideDetails["Role"]) {
										case "trainee_guide":
										$select_value = "Trainee Guide";
										break;
										case "guide":
										$select_value = "Guide";
										break;
										case "senior_guide";
										$select_value = "Senior Guide";
										break;
										case "guide_manager";
										$select_value = "Guide Manager";
										break;
										case "ops";
										$select_value = "Operations Team";
										break;
										case "sales";
										$select_value = "Front of House Team";
										break;
										case "driver";
										$select_value = "Driver";
										break;
									}
									echo "
									<option value='".$GuideDetails["Role"]."'>$select_value</option>
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
								<span class='input-group-addon min_width_150 text-left'>Privileges:</span>
								<select class='form-control' name='staff_privilege'>";
									switch ($GuidePriviledge) {
										case "admin":
										$priviledge_select = "Administrator";
										break;
										case "standard":
										$priviledge_select = "Standard User";
										break;
									}
									echo "
									<option value='$GuidePriviledge'>$priviledge_select</option>
									<option value='standard'>Standard User</option>
									<option value='admin'>Administrator</option>
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon min_width_150 text-left'>Driver's License</span>";
								echo "
								<select class='form-control' name='staff_license'>";
									if (mysqli_num_rows($GetAbilities) > 0) {
										if (in_array("big_bus", $GuideAbilities)) {
											echo "<option value='big_bus'>Big License</option>";	
										}
										if (in_array("small_bus", $GuideAbilities)) {
											echo "<option value='small_bus'>Small License</option>";	
										}
									}
									echo "
									<option value='None'>N/A</option>
									<option value='small_bus'>Small License</option>
									<option value='big_bus'>Big License</option>
								</select>
							</div>
							<div class='input-group'>
								<span class='input-group-addon min_width_150 text-left'>End Date:</span>";
								if ($GuideDetails["end_date"] == "2020-01-01") {
									echo "
									<input type='text' class='form-control' placeholder='Select a date...' id='end_date' name='end_date' readonly='readonly'>";
								} else {
									echo "
									<input type='text' class='form-control' placeholder='Select a date...' id='end_date' name='end_date' value='".$GuideDetails["end_date"]."' readonly='readonly'>";	
								}
								echo "
							</div>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon min_width_150 text-left'>Start Date:</span>
									<input type='text' class='form-control' placeholder='Select a start date...' id='start_date' name='start_date' required data-error='Start date cannot be empty.' value='".$GuideDetails["start_date"]."' readonly='readonly'>
								</div>
								<div class='help-block with-errors'></div>
							</div>
						</div>
					</div>
					<div>
						<ul class='nav nav-tabs' role='tablist'>
							<li role='presentation' class='active'><a href='#abilities' aria-controls='abilities' role='tab' data-toggle='tab'>Additional Abilities</a></li>
							<li role='presentation'><a href='#training_log' aria-controls='training_log' role='tab' data-toggle='tab'>Training Log</a></li>
							<li role='presentation'><a href='#assessment_log' aria-controls='assessment_log' role='tab' data-toggle='tab'>Assessment Log</a></li>
						</ul>
						<div class='tab-content'>
							<div role='tabpanel' class='tab-pane active' id='abilities'>
								<div class='row black_text'>
									<div class='col-sm-12'>
										<div class='panel panel-default'>
											<div class='panel-body'>
												<div class='checkbox'>
													<label>";
														if (mysqli_num_rows($GetAbilities) > 0) {
															if (in_array("first_responder", $GuideAbilities)) {
																echo "
																<input type='checkbox' name='staff_ability[]' value='first_responder' checked='checked'>";
															} else {
																echo "
																<input type='checkbox' name='staff_ability[]' value='first_responder'>";
															}
														} else { 
															echo "
															<input type='checkbox' name='staff_ability[]' value='first_responder'>";
														}
														echo "
														Wilderness First Responder Qualified
													</label>
												</div>
												<div class='checkbox'>
													<label>";
														if (mysqli_num_rows($GetAbilities) > 0) {
															if (in_array("ice_climbing", $GuideAbilities)) {
																echo "
																<input type='checkbox' name='staff_ability[]' value='ice_climbing' checked='checked'>";
															} else {
																echo "
																<input type='checkbox' name='staff_ability[]' value='ice_climbing'>";
															}
														} else {
															echo "
															<input type='checkbox' name='staff_ability[]' value='ice_climbing'>";	
														}
														echo "
														Ice Climber
													</label>
												</div>
												<div class='checkbox'>
													<label>";
														if (mysqli_num_rows($GetAbilities) > 0) {
															if (in_array("summit", $GuideAbilities)) {
																echo "
																<input type='checkbox' name='staff_ability[]' value='summit' checked='checked'>";
															} else {
																echo "
																<input type='checkbox' name='staff_ability[]' value='summit'>";
															}
														} else {
															echo "
															<input type='checkbox' name='staff_ability[]' value='summit'>";
														}
														echo "
														Summit Guide
													</label>
												</div>
											</div>	
										</div>
									</div>
								</div>
							</div>
							<div role='tabpanel' class='tab-pane' id='training_log'>
								<div class='row black_text'>
									<div class='col-sm-12 text-right'>
										<div class='panel panel-success'>
											<div class='panel-body'>
												<a href='add_training.php?submit=false&GuideName=$GuideName' class='btn btn-success' role='button'>Add New Training</a>
											</div>
										</div>
									</div>";
									$GetTrainingLog = mysqli_query($connect, "SELECT * FROM training_log WHERE GuideName = '$GuideName' AND Operator = '".$_SESSION["operator"]."' ORDER BY Date DESC");
									$GetTrainingLogNumRows = mysqli_num_rows($GetTrainingLog);
									if ($GetTrainingLogNumRows > 0) {
										while ($row = mysqli_fetch_assoc($GetTrainingLog)) {
											$TrainingLogArray[] = $row;	
										}
									} else {
										$TrainingLogArray = 0;	
									}
									if ($TrainingLogArray != 0) {
										$training_collapse_id = 9999;
										foreach ($TrainingLogArray as $value) {
											$TrainingDate = date("d-m-Y", strtotime($value["Date"]));
											if ($value["Course"] == "no") {
												echo "
												<div class='col-sm-12'>
													<div class='panel panel-info'>
														<div class='panel-heading'>
															$TrainingDate <b>".$value["TrainingName"]."</b> with ".$value["ShadowGuide"]."
															(<a href='#$training_collapse_id' data-toggle='collapse'>more information</a>)
														</div>
														<div class='panel-body collapse' id='$training_collapse_id'>
															<div class='row'>
																<div class='col-sm-2'>
																	Feedback and comments:
																</div>
																<div class='col-sm-10'>
																	<textarea class='form-control' rows='5'>".$value["Comments"]."</textarea>
																</div>
															</div>
														</div>
													</div>
												</div>";
											} else {
												echo "
												<div class='col-sm-12'>
													<div class='panel panel-success'>
														<div class='panel-heading'>
															$TrainingDate <b>".$value["TrainingName"]."</b>
														</div>
													</div>
												</div>";
											}
											$training_collapse_id ++;
										}
									}
									echo "
								</div>
							</div>
							<div role='tabpanel' class='tab-pane' id='assessment_log'>
								<div class='row black_text'>
									<div class='col-sm-12 text-right'>
										<div class='panel panel-success'>
											<div class='panel-body'>";
												if ($_SESSION["priviledge"] == "admin") {
													$assessment_button_text = "Add New Assessment";
												} else {
													$assessment_button_text = "View Assessment Criteria";
												}
												echo "
												<a href='add_assessment.php?submit=false&GuideName=$GuideName' class='btn btn-success' role='button'>$assessment_button_text</a>
											</div>
										</div>
									</div>";
									$GetAssessmentLog = mysqli_query($connect, "SELECT * FROM assessment_log WHERE GuideName = '$GuideName' AND Operator = '".$_SESSION["operator"]."' ORDER BY Date DESC");
									$GetAssessmentLogNumRows = mysqli_num_rows($GetAssessmentLog);
									if ($GetAssessmentLogNumRows > 0) {
										while ($row = mysqli_fetch_assoc($GetAssessmentLog)) {
											$AssessmentLogArray[] = $row;	
										}
									} else {
										$AssessmentLogArray = 0;	
									}
									function GetAssessment($Criteria, $Verdict) {
										if ($Criteria != NULL) {
											if ($Verdict == "Pass") {
												$pass = "checked='checked'";
												$fail = "";
												$text = "text-success";
											} else {
												$pass = "";
												$fail = "checked='checked'";	
												$text = "text-danger";
											}
											$string = "
											<div class='col-sm-2 text-center'>
												<input type='radio' $pass>
											</div>
											<div class='col-sm-2 text-center'>
												<input type='radio' $fail>
											</div>
											<div class='col-sm-8'><span class='$text'>$Criteria</span></div>";
											return $string;
										}
									};
									$checkGuideName = ucfirst($_SESSION["username"]);
									if ($_SESSION["priviledge"] == "admin" OR  $GuideName == $checkGuideName) {
										if ($AssessmentLogArray != 0) {
											$collapse_id = 0;
											foreach ($AssessmentLogArray as $value) {
												$AssessmentDate = date("d-m-Y", strtotime($value["Date"]));
												if ($value["Verdict"] == "Pass") {
													$panel = "panel-success";
												} else {
													$panel = "panel-danger";	
												}
												echo "
												<div class='col-sm-12'>
													<div class='panel $panel'>
														<div class='panel-heading'>
															$AssessmentDate <b>".$value["AssessmentName"]."</b> with ".$value["AssessedBy"].". Verdict: <b>".$value["Verdict"]."</b>
															(<a href='#$collapse_id' data-toggle='collapse'>more information</a>)
														</div>
														<div class='panel-body collapse' id='$collapse_id'>
															<div class='row'>
																<div class='col-sm-12'>
																	<div class='col-sm-2 text-center'><b>Pass</b></div>
																	<div class='col-sm-2 text-center'><b>Fail</b></div>
																	<div class='col-sm-8'><b>Criteria</b></div>
																	<div class='col-sm-12'>&nbsp;</div>";
																	echo GetAssessment($value["Criteria1"], $value["Verdict1"]);
																	echo GetAssessment($value["Criteria2"], $value["Verdict2"]);
																	echo GetAssessment($value["Criteria3"], $value["Verdict3"]);
																	echo GetAssessment($value["Criteria4"], $value["Verdict4"]);
																	echo GetAssessment($value["Criteria5"], $value["Verdict5"]);
																	echo GetAssessment($value["Criteria6"], $value["Verdict6"]);
																	echo GetAssessment($value["Criteria7"], $value["Verdict7"]);
																	echo GetAssessment($value["Criteria8"], $value["Verdict8"]);
																	echo GetAssessment($value["Criteria9"], $value["Verdict9"]);
																	echo GetAssessment($value["Criteria10"], $value["Verdict10"]);
																	echo GetAssessment($value["Criteria11"], $value["Verdict11"]);
																	echo GetAssessment($value["Criteria12"], $value["Verdict12"]);
																	echo GetAssessment($value["Criteria13"], $value["Verdict13"]);
																	echo GetAssessment($value["Criteria14"], $value["Verdict14"]);
																	echo GetAssessment($value["Criteria15"], $value["Verdict15"]);
																	echo GetAssessment($value["Criteria16"], $value["Verdict16"]);
																	echo GetAssessment($value["Criteria17"], $value["Verdict17"]);
																	echo GetAssessment($value["Criteria18"], $value["Verdict18"]);
																	echo GetAssessment($value["Criteria19"], $value["Verdict19"]);
																	echo GetAssessment($value["Criteria20"], $value["Verdict20"]);
																	echo "
																</div>
																<div class='col-sm-12'>&nbsp;</div>
																<div class='col-sm-2'>
																	Summary Report:
																</div>
																<div class='col-sm-10'>
																	<textarea class='form-control' rows='5'>".$value["Comments"]."</textarea>
																</div>
															</div>
														</div>
													</div>
												</div>";
												$collapse_id ++;
											}
										}
									} else {
										echo "		
										<div class='col-sm-12'>
											<div class='panel panel-danger'>
												<div class='panel-heading'>
													You cannot view other staff assessment logs.
												</div>
											</div>
										</div>";
									}
									echo "
								</div>
							</div>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "
								<span class='input-group-btn'>
									<button type='submit' class='btn btn-success'>Submit</button>
								</span>";
							}
							echo "
						</div>
					</div>
				</form>
				<script>
					var picker = new Pikaday(
					{
						field: document.getElementById('end_date'),
						firstDay: 1,
						minDate: new Date(2000, 0, 1),
						maxDate: new Date(2020, 12, 31),
						yearRange: [2000,2020]
					});
				</script>
				<script>
					var picker = new Pikaday(
					{
						field: document.getElementById('start_date'),
						firstDay: 1,
						minDate: new Date(2000, 0, 1),
						maxDate: new Date(2020, 12, 31),
						yearRange: [2000,2020]
					});
				</script>";		
			}
		}
	} else {
		header('Location: index.php');
	}
	?>
</body>
</html>