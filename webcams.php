<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Webcams</title>
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
echo "<div class='container-fluid'>";
include 'navigation.php';
if (!empty($_SESSION["username"])) {
	$camera = $_GET["webcam"];
	if ($camera == "hazard_board") {
		$newest_mtime = 0;
	    $base_url = 'webcams/hazard_board/C2_00626E646D78/snap/';        
	    $show_file = 'images/folio/no-image.jpg';
	    if ($handle = opendir($base_url)) {
	        while (false !== ($latestFile = readdir($handle))) {
	            if (($latestFile != '.') && ($latestFile != '..') && ($latestFile != '.htaccess')) {
	             $mtime = filemtime("$base_url/$latestFile");
	                if ($mtime > $newest_mtime) {
	                    $newest_mtime = $mtime;
	                    $show_file = "$base_url/$latestFile";
	                }
	            }
	        }
   		}
		$image = $show_file;
	} else {
		$newest_mtime = 0;
	    $base_url = 'webcams/daily_agenda/C2_00626E643C86/snap/';        
	    $show_file = 'images/folio/no-image.jpg';
	    if ($handle = opendir($base_url)) {
	        while (false !== ($latestFile = readdir($handle))) {
	            if (($latestFile != '.') && ($latestFile != '..') && ($latestFile != '.htaccess')) {
	             $mtime = filemtime("$base_url/$latestFile");
	                if ($mtime > $newest_mtime) {
	                    $newest_mtime = $mtime;
	                    $show_file = "$base_url/$latestFile";
	                }
	            }
	        }
   		}
		$image = $show_file;
	}
	echo "<img src='$image'>";
} else {
echo "not logged in</div>";	
}
?>
</body>
</html>