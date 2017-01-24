
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
<title>Hazard Map</title>
</head>
<body>
<div class='container-fluid'>
<?php
session_start();
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	$map = $_GET["map"];
	echo "<div id='hazard_map_container' class='".$map."'>";
	include 'functions/connect.php';
	if ($_POST) {
		$user = ucfirst($_SESSION["username"]);
		$hazard_location_ID = $_POST["hazard_location_ID"];
		$location = $_POST["location"];
		$detailed_description = $_POST["detailed_description"];
		$type = $_POST["type"];
		if ($_POST["action"] == "save") {
			$target_dir = "./functions/hazard_map/uploads/";
			$target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$image_exists = 0;
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image_upload"]["tmp_name"]);
			    if($check !== false) {
		    	    $uploadOk = 1;
			    } else {
    			    $uploadOk = 0;
    			}
			}
			if (file_exists($target_file)) {
			    $image_exists = 1;
			}
			if ($_FILES["image_upload"]["size"] > 50000000) {
			    $uploadOk = 0;
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			    $uploadOk = 0;
			}
			if ($uploadOk != 0) {
				if ($image_exists != 1) {
					move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file);
				}
				$img_url = $target_file;
    		} else {
    			$check_existing_image = mysqli_query($connect, "SELECT * FROM hazard_log WHERE HazardLocationID = '".$hazard_location_ID."' AND Operator = '".$_SESSION["operator"]."'");
    			$check_existing_image_num_rows = mysqli_num_rows($check_existing_image);
    			if ($check_existing_image_num_rows > 0) {
    				foreach ($check_existing_image as $value) {
						$img_url = $value["ImgURL"];
    				}
    			} else {
			    	$img_url = "None";    			
    			}
    		}
			$save_hazard = mysqli_query($connect, "INSERT INTO hazard_log (HazardLocationID, Location, ImgURL, LastUpdated, LastUpdatedBy, DetailedDescription, Type, Operator) VALUES ('$hazard_location_ID', '$location', '$img_url', '".date("Y-m-d H:i:s")."', '".$user."', '$detailed_description', '$type', '".$_SESSION["operator"]."') ON DUPLICATE KEY UPDATE HazardLocationID = '$hazard_location_ID', Location = '$location', ImgURL = '$img_url', LastUpdated = '".date("Y-m-d H:i:s")."', DetailedDescription = '$detailed_description', Type = '$type', Operator = '".$_SESSION["operator"]."'");
		} else {
			$delete_hazard = mysqli_query($connect, "DELETE FROM hazard_log WHERE HazardLocationID = '$hazard_location_ID' AND Operator = '".$_SESSION["operator"]."'");
		}
	}
	$get_all_hazards = mysqli_query($connect, "SELECT * FROM hazard_log WHERE Operator = '".$_SESSION["operator"]."'");
	$get_all_hazards_num_rows = mysqli_num_rows($get_all_hazards);
	$rows = 43;
	while ($rows > 0) {
		$columns = 52;
		while ($columns > 0) {
			$hazard_location_ID = $map."R".$rows."C".$columns;
			if ($get_all_hazards_num_rows > 0) {
				$match = false;
				foreach ($get_all_hazards as $value) {
					if ($value["HazardLocationID"] == $hazard_location_ID) {
						$match = true;
						$hazard_location_ID = $value["HazardLocationID"];
						$location = $value["Location"];
						$detailed_description = $value["DetailedDescription"];
						$img_url = $value["ImgURL"];
						$last_updated = $value["LastUpdated"];
						$last_updated_by = $value["LastUpdatedBy"];
						$type = $value["Type"];
					}
				}
				if ($match) {
					include 'functions/hazard_map/existing_hazard.php';						
				} else {
					include 'functions/hazard_map/new_hazard.php';		
				}
			} else {
				include 'functions/hazard_map/new_hazard.php';	
			}
			$columns --;
		}
		$rows --;
	}
} else {
	header("Location: index.php");
	die();
}
?>
</div>
</div>
</body>
</html>