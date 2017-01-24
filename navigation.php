<?php
include 'functions/connect.php';
include 'functions/select_config.php';
select_config($_SESSION["operator"]);
$navigation_day = date('j');
$navigation_month = date('n');
$navigation_year = date('Y');
?>
<nav class='navbar navbar-default'>
	<div class='container-fluid'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>                        
			</button>
			<a class='navbar-brand' href='#'><?php echo $config["brand"] ?></a>
		</div>
		<div class='navbar-collapse collapse' id='myNavbar'>
			<ul class='nav navbar-nav'>
				<?php
				if ($config["guides_schedule"] > 0) {
					echo "
					<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Guides <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='guides_schedule.php?day=$navigation_day&month=$navigation_month&year=$navigation_year'>Guide's Schedule</a></li>";
							if ($_SESSION["priviledge"] == "admin") {
								echo "
								<li><a href='add_guide.php?submit=false'>Add New Guide</a></li>";
							}
							echo "
							<li><a href='view_guide.php?submit=false'>View Guide Details</a></li>
						</ul>
					</li>";
				}
				if ($config["daily_agenda"] > 0) {
					echo "
					<li><a href='daily_agenda.php?day=$navigation_day&month=$navigation_month&year=$navigation_year'>Daily Agenda</a></li>";
				}
				if ($config["inventory"] > 0) {
					echo "
					<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Inventory <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='add_equipment.php?submit=false'>Add New Equipment</a></li>
							<li><a href='assign_equipment.php?submit=false'>Assign Equipment to Staff</a></li>
							<li><a href='inspect_equipment.php?submit=1'>Inspect Equipment</a></li>
						</ul>
					</li>";
				}
				if ($config["stats"] > 0) {
					echo "
					<li><a href='stats.php?day=$navigation_day&month=$navigation_month&year=$navigation_year'>Stats</a></li>";
				}
				if ($config["documentation"] > 0) {
					echo "
					<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Documentation <b class='caret'></b></a>
						<ul class='dropdown-menu' id='menu1'>
							<li class='dropdown-submenu'>
								<a href='#'>Deviation Reports</a>
								<ul class='dropdown-menu'>
									<li><a href='add_deviation.php?submit=false'>Issue Deviation</a></li>
									<li><a href='view_deviation_notices.php?deviationID=0'>View Deviation Reports</a></li>
								</ul>
							</li>
							<li class='dropdown-submenu'>
								<a href='#'>Incident Reports</a>
								<ul class='dropdown-menu'>
									<li><a href='add_incident_report.php?step=1&submit=false'>New Incident Report</a></li>
									<li><a href='search_incident_report.php?step=1&submit=false'>Edit/Print Incident Report</a></li>
								</ul>
							</li>
							<li class='dropdown-submenu'>
								<a href='#'>Training Material</a>
								<ul class='dropdown-menu'>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_GuideManual.pdf' target='_blank'>Guide Manual</a></li>
									<li class='dropdown-submenu'>
										<a href='#'>BGS</a>
										<ul class='dropdown-menu'>
											<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_BGS_Mission.pdf' target='_blank'>BGS Mission</a></li>
											<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_BGSFacts.pdf' target='_blank'>BGS Facts</a></li>
											<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_BGS_RetreatHistoryOfFalljokull.pdf' target='_blank'>Retreat History of Falljokull</a></li>
											<li><a href='video/GlacierGuides_BGS_FalljokullIcefallTimeLapse2011-2016.avi'>Falljokull Icefall Timelapse 2011-16</a></li>
											<li><a href='video/GlacierGuides_BGS_FalljokullTimeLapse2011-2016.avi'>Falljokull Timelapse 2011-16</a></li>
										</ul>
									</li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_StoryTimeWithSam.pdf' target='_blank'>Story Time with Sam</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RorysInterp.pdf' target='_blank'>Rory's Interp</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_InterglacialsIceAges.pdf' target='_blank'>Interglacials by Ryan</a></li>
								</ul>
							</li>
							<li class='dropdown-submenu'>
								<a href='#'>Safety Management</a>
								<ul class='dropdown-menu'>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_SMP.pdf' target='_blank'>Glacier Guides SMP</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_AdvancedRopesChecklist.pdf' target='_blank'>Advanced Rescue Equipment Checklist</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_SimpleRescueChecklist.pdf' target='_blank'>Simple Rescue Equipment Checklist</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskAssessment_131115.pdf' target='_blank'>Risk Assessment</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskManagementStrategies_Wonders131115.pdf' target='_blank'>RMS: Wonders</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskManagementStrategies_Explorer131115.pdf' target='_blank'>RMS: Explorer</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskManagementStrategies_Xtreme131115.pdf' target='_blank'>RMS: Xtreme</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskManagementStrategies_IntotheGlacier131115.pdf' target='_blank'>RMS: Into the Glacier</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_RiskManagementStrategies_CrystalIceCave050216.pdf' target='_blank'>RMS: Crystal Ice Cave</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_EmergencyResponsePlan_Guides030316.pdf' target='_blank'>ERP: Guides</a></li>
									<li><a href='pdf_viewer/web/viewer.html?file=http://gg-portal.com/pdfs/GlacierGuides_EmergencyResponsePlan_OfficeTeam030316.pdf' target='_blank'>ERP: Office Team</a></li>
								</ul>
							</li>
						</ul>
					</li>";
				}
				if ($config["hazard_maps"] > 0) {
					echo "
					<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Hazard Maps <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='hazardboard.php?map=gw'>Glacier Wonders</a></li>
						</ul>
					</li>";
				}
				if ($config["webcams"] > 0) {
					echo "
					<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Webcams <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='webcams.php?webcam=daily_agenda'>Daily Agenda</a></li>
						</ul>
					</li>";
				}
				if ($config["alerts"] > 0) {
					$query_date = date("Y-m-d");
					$alerts_query_assessments_overdue = mysqli_query($connect, "SELECT * FROM assessment_log WHERE NextDue < '".date("Y-m-d")."' AND GuideName NOT IN (SELECT GuideName FROM guides WHERE end_date < '$query_date') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_missing_basic_knots = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Basic Knots' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_missing_gw = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Glacier Wonders Assessment' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_missing_ge = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Glacier Explorer Assessment' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_missing_simple_rescue = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM assessment_log WHERE AssessmentName = 'Simple Rescue' AND Verdict = 'Pass') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_missing_SMP = mysqli_query($connect, "SELECT GuideName FROM Guides WHERE Role IN ('guide', 'senior_guide', 'guide_manager') AND end_date > '$query_date' AND start_date < '$query_date' AND GuideName NOT IN (SELECT GuideName FROM training_log WHERE TrainingName = 'Have read and understood the Glacier Guides SMP') AND Operator = '".$_SESSION["operator"]."'");
					$alerts_first_aid_inspection_missing = mysqli_query($connect, "SELECT FirstAidKitID, Size FROM first_aid_kits WHERE FirstAidKitID NOT IN (SELECT FirstAidKitID FROM first_aid_inspection_log) AND Operator = '".$_SESSION["operator"]."'");
					$alerts_query_first_aid_kits_overdue = mysqli_query($connect, "SELECT * FROM first_aid_inspection_log WHERE NextDue < '".date("Y-m-d")."' AND Operator = '".$_SESSION["operator"]."'");

					/*$alerts_query_inspection = mysqli_query($connect, "SELECT * FROM inspection_log WHERE NextDue < '".date("Y-m-d")."' AND Operator = '".$_SESSION["operator"]."'");*/
					$alerts_results_assessments_overdue = mysqli_num_rows($alerts_query_assessments_overdue);
					$overdue_assessments = 0;
					if ($alerts_results_assessments_overdue > 0) {
						foreach ($alerts_query_assessments_overdue as $value) {
							switch ($value["RoleRequired"]) {
								case '0':
								$role_required = "0";
								break;
								case '1':
								$role_required = "1";
								break;
								case '2':
								$role_required = "2";
								break;
								case '3':
								$role_required = "3";
								break;
								default:
								$role_required = "0";
								break;
							}
							$check_guide_role = mysqli_query($connect, "SELECT Role FROM guides WHERE GuideName = '".$value["GuideName"]."' AND Operator = '".$_SESSION["operator"]."'");
							foreach ($check_guide_role as $value_a) {
								$guide_role = $value_a["Role"];
							}
							switch ($guide_role) {
								case "guide":
								$guide_role_value = "1";
								break;
								case "senior_guide":
								$guide_role_value = "2";
								break;
								case "guide_manager":
								$guide_role_value = "3";
								break;
								default:
								$guide_role_value = "0";
								break;
							}
							if ($guide_role_value >= $role_required) {
								$overdue_assessments ++;
							}
						}
					}
					$alerts_results_missing_basic_knots = mysqli_num_rows($alerts_query_missing_basic_knots);
					$alerts_results_missing_simple_rescue = mysqli_num_rows($alerts_query_missing_simple_rescue);
					$alerts_results_missing_SMP = mysqli_num_rows($alerts_query_missing_SMP);
					$alerts_results_missing_gw = mysqli_num_rows($alerts_query_missing_gw);
					$alerts_results_missing_ge = mysqli_num_rows($alerts_query_missing_ge);
					$GetMissingFirstAidInspection_NumRows = mysqli_num_rows($alerts_first_aid_inspection_missing);

					/*$alerts_results_inspection = mysqli_num_rows($alerts_query_inspection);*/
					$total_alerts = ($overdue_assessments + $alerts_results_missing_basic_knots + $alerts_results_missing_simple_rescue + $alerts_results_missing_SMP + $alerts_results_missing_ge + $alerts_results_missing_gw /*+ $alerts_results_inspection */);
					if ($total_alerts > 0) {
						echo "
						<li><a href='alerts.php'>Alerts <b>($total_alerts)</b></a></li>";
					} else {
						echo "
						<li><a href='#'>Alerts (0)</a></li>";
					}
				}
				if ($config["missions"] > 0) {
					echo "
					<li class='dropdown'>";
						$StaffName = ucfirst($_SESSION["username"]);
						$get_staff_priviledges = mysqli_query($connect, "SELECT GuideName, Role FROM guides WHERE GuideName = '".$StaffName."' AND Operator = '".$_SESSION["operator"]."'");
						foreach ($get_staff_priviledges as $value) {
							$staff_role = $value["Role"];
						}

						if ($staff_role == "ops" OR $staff_role == "guide_manager") {
							$get_mission_details = mysqli_query($connect, "SELECT * FROM mission_log WHERE MissionStatus != 'Complete' AND Operator = '".$_SESSION["operator"]."'");
						} else {
							$get_mission_details = mysqli_query($connect, "SELECT * FROM mission_log WHERE CreatedFor = '".$StaffName."' AND MissionStatus != 'Complete' AND Operator = '".$_SESSION["operator"]."'");
						}
						$get_mission_details_num_rows = mysqli_num_rows($get_mission_details);
						echo "
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Missions <b> (".$get_mission_details_num_rows.")<b class='caret'></b></b></a>
						<ul class='dropdown-menu'>
							<li><a href='create_mission.php?submit=false'>Create Mission</a></li>
							<li><a href='view_missions.php?submit=false'>View Missions</a></li>		
						</ul>
					</li>";
				}
				if ($config["comms"] > 0) {
					$get_user_role = mysqli_query($connect, "SELECT Role FROM guides WHERE GuideName = '".$_SESSION["username"]."' AND Operator = '".$_SESSION["operator"]."'");
					foreach ($get_user_role as $val) {
						$user_role = $val["Role"];
					}
					if ($user_role == "sales" OR $user_role == "ops" OR $user_role == "guide_manager") {
						echo "
						<li class='dropdown'>
							<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Comms <b class='caret'></b></b></a>
							<ul class='dropdown-menu'>";	
								if ($user_role == "ops" OR $user_role == "guide_manager") {
									echo "
									<li><a href='comms.php?event=daily_summary&submit=false'>Daily Summary</a></li>";
								}
								echo "
								<li><a href='comms.php?event=cancellation_notice&submit=false'>Cancellation Notice</a></li>
								<li><a href='/dashboard/index.php'>Cancellation Dashboard</a></li>		
							</ul>
						</li>";
					}
				}
				echo "
			</ul>
			<ul class='nav navbar-nav navbar-right'>
				<li><a href='#'><span class='glyphicon glyphicon-user'></span> Logged in as: ".$_SESSION["username"]."</a></li>
				<li><a href='index.php'><span class='glyphicon glyphicon-log-in'></span> Log out</a></li>
			</ul>
			<div class='collapse navbar-collapse' id='myNavbar'>
			</div>
		</div>
	</div>
</nav>";
?>