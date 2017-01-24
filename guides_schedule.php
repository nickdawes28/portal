<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Guide's Schedule</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="libraries/jQuery.js"></script>
	<script src="libraries/bootstrap.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic,800,300italic,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php
	session_start();
	if (!empty($_SESSION["username"])) {
		echo "<div class='container-fluid'>";
		include 'navigation.php';
		include 'functions/connect.php';
		$date = date("Y-m-d", strtotime($_GET["year"]."-".$_GET["month"]."-".$_GET["day"]));
		$day = $_GET["day"];
		$month = $_GET["month"];
		$year = $_GET["year"];
		include 'functions/guides_schedule/guides_schedule_submit.php';
		include 'functions/custom_hmac.php';
		include 'functions/access_key.php';
		echo "
		<form action='guides_schedule.php?day=$day&month=$month&year=$year' method='post'>
			<div class='row'>
				<div class='col-sm-12'>
					<div class='well'>
						<h4>Guide's Schedule</h4>
					</div>
				</div>
			</div>
			<div class='row text-center'>
				<div class='col-sm-4'>
					<div class='well'>
						<a href='guides_schedule.php?day=1&month=".date('n', mktime(0, 0, 0, $month -1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month -1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month -1, 1, $year))."</a>
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='well'>
						<strong>".date('F Y', mktime(0, 0, 0, $month, 1, $year))."</strong>
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='well'>
						<a href='guides_schedule.php?day=1&month=".date('n', mktime(0, 0, 0, $month +1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month +1, 1, $year))."' class='standard_link'>".date('F Y', mktime(0, 0, 0, $month +1, 1, $year))."</a>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
					<div class='table-responsive'>
						<div class='table_fix'>
							<table class='table'>
								<tr>";
									include 'functions/guides_schedule/guide_schedule_days.php';
									GuideScheduleDays("Guides", $month, $year);
									echo "
								</tr>";
								$days_in_month_total = cal_days_in_month(CAL_GREGORIAN,$month,$year);
								include 'functions/guides_schedule/guide_schedule_get_staff.php';
								GetStaff("ops");
								GetStaff("guide_manager");
								GetStaff("senior_guide");
								GetStaff("guide");
								GetStaff("trainee_guide");
								echo "
								<tr>
									<td class='guides_schedule_cell_available_guides'>Total Guides</td>";
									$TotalGuideCountContainer = $days_in_month_total;
									$TotalGuideCountContainerLoop = 0;
									$TotalGuideCount = 0;
									while ($TotalGuideCountContainer > 0) {
										$TotalGuideCountContainerLoop ++;
										$QueryDay = sprintf("%02d", $TotalGuideCountContainerLoop);
										$QueryMonth = sprintf("%02d", $month);
										$TotalGuideCountQuery = mysqli_query($connect, "SELECT * FROM guides_schedule WHERE WorkDate = '".$year."-".$QueryMonth."-".$QueryDay."' AND Activity IN ('Working from Skaftafell', 'Working from KTown', 'Glacier', 'Golden', 'Gulfoss', 'K5', 'Fri', 'Private', 'Express 08:30', 'Express 10:30') AND GuideName IN (SELECT GuideName FROM guides WHERE Role = 'guide' OR Role = 'senior_guide' OR Role = 'guide_manager') AND Operator = '".$_SESSION["operator"]."'");
										$TotalGuideCount = mysqli_num_rows($TotalGuideCountQuery);
										if ($TotalGuideCount > 5) {
											echo "
											<td class='guides_schedule_cell_total_guide_count_sufficient'>
												$TotalGuideCount
											</td>";
											$TotalGuideCountContainer--;
										} else {
											echo "
											<td class='guides_schedule_cell_total_guide_count_insufficient'>
												$TotalGuideCount
											</td>";
											$TotalGuideCountContainer--;
										}
									}
									echo "
								</tr>";
								if ($config["vendor"] == "Glacier Guides") {
									echo "
									<tr>
										<td class='guides_schedule_cell_available_guides'>Total Staff in Skaftafell</td>";
										$TotalGuideCountContainer = $days_in_month_total;
										$TotalGuideCountContainerLoop = 0;
										$TotalGuideCount = 0;
										while ($TotalGuideCountContainer > 0) {
											$TotalGuideCountContainerLoop ++;
											$QueryDay = sprintf("%02d", $TotalGuideCountContainerLoop);
											$QueryMonth = sprintf("%02d", $month);
											$TotalGuideCountQuery = mysqli_query($connect, "SELECT * FROM guides_schedule WHERE WorkDate = '".$year."-".$QueryMonth."-".$QueryDay."' AND Activity = 'Working from Skaftafell' AND GuideName NOT IN ('Nick', 'Bex') AND Operator = '".$_SESSION["operator"]."'");
											$TotalGuideCount = mysqli_num_rows($TotalGuideCountQuery);
											if ($TotalGuideCount < 15) {
												echo "
												<td class='guides_schedule_cell_total_guide_count_sufficient'>
													$TotalGuideCount
												</td>";
												$TotalGuideCountContainer--;
											} else {
												echo "
												<td class='guides_schedule_cell_total_guide_count_insufficient'>
													$TotalGuideCount
												</td>";
												$TotalGuideCountContainer--;
											}
										}
										echo "
									</tr>
									<tr>
										<td class='guides_schedule_cell_available_guides'>Total Staff in Kirkjubæjarklaustur</td>";
										$TotalGuideCountContainer = $days_in_month_total;
										$TotalGuideCountContainerLoop = 0;
										$TotalGuideCount = 0;
										while ($TotalGuideCountContainer > 0) {
											$TotalGuideCountContainerLoop ++;
											$QueryDay = sprintf("%02d", $TotalGuideCountContainerLoop);
											$QueryMonth = sprintf("%02d", $month);
											$TotalGuideCountQuery = mysqli_query($connect, "SELECT * FROM guides_schedule WHERE WorkDate = '".$year."-".$QueryMonth."-".$QueryDay."' AND Activity = 'Working from KTown' AND Operator = '".$_SESSION["operator"]."'");
											$TotalGuideCount = mysqli_num_rows($TotalGuideCountQuery);
											if ($TotalGuideCount < 15) {
												echo "
												<td class='guides_schedule_cell_total_guide_count_sufficient'>
													$TotalGuideCount
												</td>";
												$TotalGuideCountContainer--;
											} else {
												echo "
												<td class='guides_schedule_cell_total_guide_count_insufficient'>
													$TotalGuideCount
												</td>";
												$TotalGuideCountContainer--;
											}
										}
										echo "
									</tr>
									<tr class='staff_divider'><td colspan='".($days_in_month_total+1)."'>Drivers</td></tr>";
									GetStaff("driver");
									echo "
									<tr class='staff_divider'><td colspan='".($days_in_month_total+1)."'>Sales Team</td></tr>";
									GetStaff("sales");
								}
								echo "
								<tr>";
									GuideScheduleDays("", $month, $year);
									echo "
								</tr>
							</table>
						</div>
					</div> 
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12 text-center'>";
					if ($config["task_guide_manager"] > 0) {
						echo "
						<div class='btn guides_schedule_select_guide_manager'>";
							if ($_SESSION["priviledge"] == "admin") {echo "<input type='radio' name='activity' value='guide_manager'>";}
							echo "
							Guide Manager
						</div>";
					}
					if ($config["task_sick_day"] > 0) {
						echo "
						<div class='btn guides_schedule_select_sick'>";
							if ($_SESSION["priviledge"] == "admin") {echo "<input type='radio' name='activity' value='sick'>";}
							echo "
							Sick Day
						</div>";
					}
					if ($config["task_training_day"] > 0) {
						echo "
						<div class='btn guides_schedule_select_training'>";
							if ($_SESSION["priviledge"] == "admin") {echo "<input type='radio' name='activity' value='training'>";}
							echo "
							Training Day
						</div>";
					}
					if ($config["task_holiday_approved"] > 0) {
						echo "
						<div class='btn guides_schedule_select_holiday'>";
							if ($_SESSION["priviledge"] == "admin") {echo "<input type='radio' name='activity' value='holiday'>";}
							echo "
							Holiday Approved
						</div>";
					}
					/*
					if ($config["task_travel"] > 0) {
						echo "
						<div class='btn guides_schedule_select_travel'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "
								<input type='radio' name='activity' value='travel'>";
							} else {
								echo "
								<input type='radio' name='activity' value='travel' checked='checked'>";
							}
							echo "
							Reykjavik Travel
						</div>";
					}
					*/
					if ($config["task_glacier"] > 0) {
						echo "
						<div class='btn guides_schedule_select_glacier'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='glacier'>";
							} else {
								echo "<input type='radio' name='activity' value='glacier'>";
							}
							echo "
							Glacier
						</div>";
					}
					if ($config["task_golden"] > 0) {
						echo "
						<div class='btn guides_schedule_select_golden'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='golden'>";
							} else {
								echo "<input type='radio' name='activity' value='golden'>";
							}
							echo "
							Golden
						</div>";
					}
					if ($config["task_gulfoss"] > 0) {
						echo "
						<div class='btn guides_schedule_select_gulfoss'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='gulfoss'>";
							} else {
								echo "<input type='radio' name='activity' value='gulfoss'>";
							}
							echo "
							Gulfoss
						</div>";
					}
					if ($config["task_express0830"] > 0) {
						echo "
						<div class='btn guides_schedule_select_express0830'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='express0830'>";
							} else {
								echo "<input type='radio' name='activity' value='express0830'>";
							}
							echo "
							Express 08:30
						</div>";
					}
					if ($config["task_express1030"] > 0) {
						echo "
						<div class='btn guides_schedule_select_express1030'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='express1030'>";
							} else {
								echo "<input type='radio' name='activity' value='express1030'>";
							}
							echo "
							Express 10:30
						</div>";
					}
					if ($config["task_k5"] > 0) {
						echo "
						<div class='btn guides_schedule_select_k5'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='K5'>";
							} else {
								echo "<input type='radio' name='activity' value='K5'>";
							}
							echo "
							K5
						</div>";
					}
					if ($config["task_fri"] > 0) {
						echo "
						<div class='btn guides_schedule_select_fri'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='fri'>";
							} else {
								echo "<input type='radio' name='activity' value='fri'>";
							}
							echo "
							Fri
						</div>";
					}
					if ($config["task_private"] > 0) {
						echo "
						<div class='btn guides_schedule_select_private'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='private'>";
							} else {
								echo "<input type='radio' name='activity' value='private'>";
							}
							echo "
							Private
						</div>";
					}
					if ($config["task_holiday_request"] > 0) {
						echo "
						<div class='btn guides_schedule_select_request_holiday'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='request_holiday'>";
							} else {
								echo "<input type='radio' name='activity' value='request_holiday'>";
							}
							echo "
							Request Holiday
						</div>";
					}
					if ($config["task_staying_off_shift"] > 0) {
						echo "
						<div class='btn guides_schedule_select_in_skaftafell'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='in_skaftafell'>";
							}
							echo "
							Staying Off Shift
						</div>";
					}
					if ($config["task_skaftafell"] > 0) {
						echo "
						<div class='btn guides_schedule_select_skaftafell'>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "<input type='radio' name='activity' value='working_from_skaftafell' checked='checked'>";
							}
							echo "
							Skaftafell
						</div>";
					}
					if ($config["task_kirkjubaerjarklaustur"] > 0) {
						echo "
						<div class='btn guides_schedule_select_ktown'>";
							if ($_SESSION["priviledge"] == "admin") {echo "<input type='radio' name='activity' value='working_from_ktown'>";}
							echo "
							Kirkjubæjarklaustur
						</div>";
					}
					if ($_SESSION["priviledge"] == "admin") {
						echo "<input type='submit' class='btn btn-primary' value='Save Schedule'></input>";
					} else {
						echo "<input type='submit' class='btn btn-primary' value='Submit Request'></input>";						
					}
					echo "
				</div>
			</div>
		</form>
	</div>";
} else {
	header('Location: index.php');
}
?>