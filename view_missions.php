<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>View Missions</title>
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
			if (isset($_GET["deleteID"])) {
				$delete_mission = mysqli_query($connect, "DELETE FROM mission_log WHERE MissionID = '".$_GET["deleteID"]."' AND Operator = '".$_SESSION["operator"]."'");
				echo "
				<div class='alert alert-success' role='alert'>
					Mission successfully deleted.
				</div>";
				$deleter = ucfirst($_SESSION["username"]);
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
				$mail->Subject  = "Mission deleted by $deleter.";
				$mail->Body     = "$mission_comment.";
				$mail->WordWrap = 50;
				if(!$mail->Send()) {
					echo ' Message was not sent.';
					echo 'Mailer error: ' . $mail->ErrorInfo;
				}
			}
			if (isset($_GET["missionID"])) {
				$get_mission_details = mysqli_query($connect, "SELECT * FROM mission_log WHERE MissionID = '".$_GET["missionID"]."' AND Operator = '".$_SESSION["operator"]."'");
				foreach ($get_mission_details as $value) {
					$createdFor = $value["CreatedFor"];
					$createdBy = $value["CreatedBy"];
					$missionTitle = $value["MissionTitle"];
					$missionStatus = $value["MissionStatus"];
					$missionDescription = $value["MissionDescription"];
					$missionDeadline = $value["MissionDeadline"];
				}
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Mission Details</h4>
						</div>
					</div>
				</div>";
				if ($missionStatus != "Complete") {
					$get_latest_mission_comment = mysqli_query($connect, "SELECT * FROM mission_comments WHERE MissionID = '".$_GET["missionID"]."' AND Operator = '".$_SESSION["operator"]."' ORDER BY CommentTimestamp DESC LIMIT 1");
					$get_latest_mission_comment_num_rows = mysqli_num_rows($get_latest_mission_comment);
					if ($get_latest_mission_comment_num_rows > 0) {
						foreach ($get_latest_mission_comment as $value) {
							$latest_mission_comment_owner = $value["CommentOwner"];
							$latest_mission_comment_timestamp = date("D M j Y", strtotime($value["CommentTimestamp"]));
							$latest_mission_comment_time = date("G:i:s", strtotime($value["CommentTimestamp"]));
						}
						echo "
						<form class='form-horizontal'>
							<fieldset>
								<div class='form-group black_text'>
									<label class='col-md-4 control-label' for='textarea'>Last comment by ".$latest_mission_comment_owner."<br>".$latest_mission_comment_timestamp."<br>".$latest_mission_comment_time."</label>
									<div class='col-md-5'>                     
										<textarea class='form-control' readonly='readonly' id='textarea' name='textarea'>".$value["MissionComment"]."</textarea>
									</div>
								</div>
							</fieldset>";
						}
						echo "
					</form>
					<form class='form-horizontal' role='form' data-toggle='validator' method='post' action='view_missions.php?submit=add_comment'>
						<fieldset>
							<input type='hidden' name='missionID' value='".$_GET["missionID"]."'>";
							$comment_owner = ucfirst($_SESSION["username"]);
							echo "
							<input type='hidden' name='comment_owner' value='$comment_owner'>
							<input type='hidden' name='mission_title' value='$missionTitle'>
							<div class='form-group black_text'>
								<label class='col-md-4 control-label' for='mission_comment'>Add new comment.</label>
								<div class='col-md-5'>                     
									<textarea class='form-control' id='mission_comment' name='mission_comment'></textarea>
								</div>
							</div>
							<div class='form-group black_text'>
								<label class='col-md-4 control-label' for='submit'></label>
								<div class='col-md-4'>
									<button id='submit' name='submit' class='btn btn-primary'>Add New Comment</button>
								</div>
							</div>
							<br>
						</fieldset>
					</form>";
				}
				echo "
				<form class='form-horizontal' role='form' data-toggle='validator' method='post' action='view_missions.php?submit=update'>
					<fieldset>
						<input type='hidden' name='missionID' value='".$_GET["missionID"]."'>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_title'>Mission Title</label>  
							<div class='col-md-5'>
								<input id='mission_title' name='mission_title' value='".$missionTitle."' class='form-control input-md' required='' type='text'>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='created_for'>Mission For</label>
							<div class='col-md-5'>
								<select id='created_for' name='created_for' class='form-control'>
									<option value='$createdFor'>$createdFor</option>";
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
							<div class='col-md-5'>
								<input id='created_by' name='created_by' readonly='readonly' value='$createdBy' class='form-control input-md' type='text'>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_status'>Mission Status</label>  
							<div class='col-md-5'>
								<select id='mission_status' name='mission_status' class='form-control'>";
									if ($missionStatus == "Complete") {
										echo "<option>Complete</option>";
									} else {
										echo "
										<option value='In Progress'>In Progress</option>
										<option value='Complete'>Complete</option>";
									}
									echo "
								</select>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_description'>Mission Description</label>
							<div class='col-md-5'>                  
								<textarea rows='5' class='form-control' id='mission_description' name='mission_description'>$missionDescription</textarea>
							</div>
						</div>
						<div class='form-group black_text'>
							<label class='col-md-4 control-label' for='mission_deadline'>Mission Deadline</label>  
							<div class='col-md-5'>
								<input id='mission_deadline' name='mission_deadline' required='' value='".$missionDeadline."' class='form-control input-md' type='text'>
							</div>
						</div>
						<div class='form-group'>
							<label class='col-md-4 control-label' for='submit'></label>
							<div class='col-md-4'>
								<button id='submit' name='submit' class='btn btn-success'>Update Mission</button>
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
				</script><br>";
				$get_mission_comments = mysqli_query($connect, "SELECT * FROM mission_comments WHERE MissionID = '".$_GET["missionID"]."' AND Operator = '".$_SESSION["operator"]."' ORDER BY CommentTimestamp DESC");
				$get_mission_comments_num_rows = mysqli_num_rows($get_mission_comments);
				if ($get_mission_comments_num_rows > 0) {
					foreach ($get_mission_comments as $value) {
						echo "
						<form class='form-horizontal'>
							<fieldset>
								<div class='form-group black_text'>
									<label class='col-md-4 control-label' for='textarea'>".$value["CommentOwner"]."<br>".date("D M j Y", strtotime($value["CommentTimestamp"]))."<br>".date("G:i:s", strtotime($value["CommentTimestamp"]))."</label>
									<div class='col-md-5'>
										<textarea class='form-control' readonly='readonly' id='textarea' name='textarea'>".$value["MissionComment"]."</textarea>
									</div>
								</div>
							</fieldset>
						</form>";
					}
				} else {
					echo "no comments";
				}
			} else {
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='well'>
							<h4>Missions</h4>
						</div>
					</div>
				</div>";
				$StaffName = ucfirst($_SESSION["username"]);
				$get_staff_priviledges = mysqli_query($connect, "SELECT GuideName, Role FROM guides WHERE GuideName = '".$StaffName."' AND Operator = '".$_SESSION["operator"]."'");
				foreach ($get_staff_priviledges as $value) {
					$staff_role = $value["Role"];
				}
				if ($staff_role == "ops" OR $staff_role == "guide_manager") {
					$get_mission_details = mysqli_query($connect, "SELECT * FROM mission_log WHERE Operator = '".$_SESSION["operator"]."'");
				} else {
					$get_mission_details = mysqli_query($connect, "SELECT * FROM mission_log WHERE CreatedFor = '".$StaffName."' AND Operator = '".$_SESSION["operator"]."'");
				}
				$get_mission_details_num_rows = mysqli_num_rows($get_mission_details);
				if ($get_mission_details_num_rows > 0) {
					$complete_count = 0;
					$incomplete_count = 0;
					foreach ($get_mission_details as $mission_status_count) {
						if ($mission_status_count["MissionStatus"] == "Complete") {
							$complete_count ++;
						} else {
							$incomplete_count ++;
						}
					}
					echo "
					<div>
						<ul class='nav nav-tabs' role='tablist'>
							<li role='presentation' class='active'><a href='#active_missions' aria-controls='active_missions' role='tab' data-toggle='tab'>Active Missions ($incomplete_count)</a></li>
							<li role='presentation'><a href='#complete_missions' aria-controls='complete_missions' role='tab' data-toggle='tab'>Complete Missions ($complete_count)</a></li>
						</ul>
						<div class='tab-content'>
							<div role='tabpanel' class='tab-pane active' id='active_missions'>
								<div class='row black_text'>
									<div class='col-sm-12'>
										<div class='panel-group'>
											<div class='panel panel-default'>
												<div class='panel-body'>";
													foreach ($get_mission_details as $value) {
														if ($value["MissionStatus"] != "Complete") {
															if ($value["MissionDeadline"] > date("Y-m-d")) {
																$mission_status = "In Progress";
																$panel_type = "info";
															} else {
																$mission_status = "Overdue";
																$panel_type = "danger";
															}
															echo "
															<div class='panel panel-$panel_type'>
																<div class='panel-heading'>
																	Mission Title: <a href='view_missions.php?submit=false&missionID=".$value["MissionID"]."'><b>".$value["MissionTitle"]."</b><br></a>
																	Mission Deadline: <b>".date("D M j Y", strtotime($value["MissionDeadline"]))."</b><br>
																	Mission Status: <b>$mission_status</b>.<br>
																	Created for <b>".$value["CreatedFor"]."</b> by <b>".$value["CreatedBy"]."</b>.<br>
																	<a class='delete' href='view_missions.php?submit=false&deleteID=".$value["MissionID"]."'>Delete the mission.</a>
																</div>
															</div>";
														}
													}
													echo "
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
							<div role='tabpanel' class='tab-pane' id='complete_missions'>
								<div class='row black_text'>
									<div class='col-sm-12'>
										<div class='panel-group'>
											<div class='panel panel-default'>
												<div class='panel-body'>";
													foreach ($get_mission_details as $value1) {
														if ($value1["MissionStatus"] == "Complete") {
															echo "
															<div class='panel panel-success'>
																<div class='panel-heading'>
																	Mission Title: <a href='view_missions.php?submit=false&missionID=".$value["MissionID"]."'><b>".$value1["MissionTitle"]."</b><br></a>
																	Mission Deadline: <b>".date("D M j Y", strtotime($value1["MissionDeadline"]))."</b><br>
																	Mission Status: <b>".$value1["MissionStatus"]."</b>.<br>
																	Created for <b>".$value1["CreatedFor"]."</b> by <b>".$value1["CreatedBy"]."</b>.
																</div>
															</div>";
														}
													}
													echo "
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(function() {
							$('.delete').click(function() {
								return window.confirm('Are you sure you want to delete this mission?');
							});
						});
					</script>";

				} else {
					echo "
					<div class='panel panel-info'>
						<div class='panel-heading'>
							There are no active missions.
						</div>
					</div>";
				}
			}
		} else {
			if ($submit == "true") {
				$createdFor = $_POST["created_for"];
				$createdBy = $_POST["created_by"];
				$missionTitle = $_POST["mission_title"];
				$missionStatus = $_POST["mission_status"];
				$missionDescription = $_POST["mission_description"];
				$missionDeadline = $_POST["mission_deadline"];				
				$missionDeadline = $_POST['mission_deadline'];
				$missionDeadline_day = substr($missionDeadline,8,2);
				$missionDeadline_month = substr($missionDeadline,4,3);
				$missionDeadline_month = date("m", strtotime($missionDeadline_month));
				$missionDeadline_year = substr($missionDeadline,11,4);
				$missionDeadline = date("Y-m-d", mktime(0,0,0,$missionDeadline_month,$missionDeadline_day,$missionDeadline_year));
				$add_mission = mysqli_query($connect, "INSERT INTO mission_log (CreatedFor, CreatedBy, MissionTitle, MissionStatus, 	MissionDescription, MissionDeadline, Operator) VALUES ('$createdFor', '$createdBy', '$missionTitle', '$missionStatus', '$missionDescription', '$missionDeadline', '".$_SESSION["operator"]."')");
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
			} else {
				if ($submit == "update") {
					$missionID = $_POST["missionID"];
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

					$add_mission = mysqli_query($connect, "UPDATE mission_log SET CreatedFor = '$createdFor', MissionTitle = '$missionTitle', MissionStatus = '$missionStatus', MissionDescription = '$missionDescription', MissionDeadline = '$missionDeadline' WHERE MissionID = '".$missionID."' AND Operator = '".$_SESSION["operator"]."'");
					echo "
					<div class='well'>
						<h4>Mission successfully updated for $createdFor.</h4>
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
					$updater = ucfirst($_SESSION["username"]);
					$mail->Subject  = "Mission update for ".$missionTitle." by ".$updater.".";
					$mail->Body     = "Mission details: $missionDescription.";
					$mail->WordWrap = 50;
					if(!$mail->Send()) {
						echo ' Message was not sent.';
						echo 'Mailer error: ' . $mail->ErrorInfo;
					}
				} else if ($submit == "add_comment") {
					$missionID = $_POST["missionID"];
					$mission_title = $_POST["mission_title"];
					$mission_comment = mysqli_real_escape_string($connect, $_POST["mission_comment"]);
					$comment_owner = $_POST["comment_owner"];

					$add_comment = mysqli_query($connect, "INSERT INTO mission_comments (MissionID, MissionComment, CommentOwner, CommentTimestamp, Operator) VALUES ('$missionID', '$mission_comment', '$comment_owner', '".date("Y-m-d H:i:s")."', '".$_SESSION["operator"]."')");
					echo "
					<div class='well'>
						<h4>Comment successfully added by $comment_owner.</h4>
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
					$mail->Subject  = "New comment logged for mission $mission_title by $created_by.";
					$mail->Body     = "$mission_comment.";
					$mail->WordWrap = 50;
					if(!$mail->Send()) {
						echo ' Message was not sent.';
						echo 'Mailer error: ' . $mail->ErrorInfo;
					}
				} else {
					echo "you shouldn't be here.";	
				}
			}
		}
	} else {
		echo "not logged in</div>";	
	}
	?>
</body>
</html>