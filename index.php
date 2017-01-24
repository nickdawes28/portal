<?php
session_start();
session_destroy();
$connect = mysqli_connect("127.0.0.1","root","", "portal") or die(mysql_error());
function login($success) {
	echo "
	<!DOCTYPE html>
	<html lang='en'>
	<head>
		<title>Glacier Guides Management Portal</title>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
		<link rel='stylesheet' href='css/login_style.css'>
		<link rel='stylesheet' href='css/style.css'>
		<link rel='stylesheet' href='css/bootstrap.css'>
	</head>
	<body>
		<div class='container'>
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div class='col-sm-6'>
					<img class='img-responsive login_logo' src='images/logo.png' height='200px' width='200px'>
				</div>
				<div class='col-sm-3'>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div class='col-sm-6 text_centered bottom_margin15px black_text'>
					<h3>Management Portal</h3>
					$success
				</div>
				<div class='col-sm-3'>
				</div>
			</div>
			<form class='form-horizontal' role='form' action='index.php' method='post'>
				<div class='row'>
					<div class='col-sm-3'>
					</div>
					<div class='col-sm-6'>        
						<div class='form-group'>
						<label class='col-sm-4 control-label black_text' for='select_operator'>Select Operator</label>
							<div class='col-sm-8'>
								<select id='select_operator' name='operator' class='form-control'>
									<option value='glacier_guides'>Glacier Guides</option>
									<option value='snowmobile'>Snowmobile</option>
									<option value='arctic_adventures'>Arctic Adventures</option>
								</select>
							</div>
						</div>
					</div>
					<div class='col-sm-3'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-3'>
					</div>
					<div class='col-sm-6'>        
						<div class='form-group'>
							<label class='control-label col-sm-4 black_text' for='username'>Username:</label>
							<div class='col-sm-8'>
								<input type='text' class='form-control' id='username' placeholder='Enter username' name='username' autofocus>
							</div>
						</div>
					</div>
					<div class='col-sm-3'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-3'>
					</div>        
					<div class='col-sm-6'>
						<div class='form-group'>
							<label class='control-label col-sm-4 black_text' for='pwd'>Password:</label>
							<div class='col-sm-8'>          
								<input type='password' class='form-control' id='pwd' placeholder='Enter password' name='password'>
							</div>
						</div>
					</div>
					<div class='col-sm-3'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-3'>
					</div>        
					<div class='col-sm-6'>
						<div class='form-group'>        
							<div class='col-sm-12 text-center'>
								<button type='submit' class='btn btn-success'>Submit</button>
							</div>
						</div>
					</div>
					<div class='col-sm-3'>
					</div>        
				</div>
			</form>
		</div>
	</body>
	</html>";
}
if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["operator"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$operator = $_POST["operator"];
	$check_user_query = mysqli_query($connect, "SELECT * FROM users WHERE Username = '$username' AND Password = '$password' AND Operator = '$operator'");
	$check_user_result = mysqli_num_rows($check_user_query);
	if ($check_user_result > 0) {
		while($row = mysqli_fetch_assoc($check_user_query)) {
			$check_user_priviledge = $row['Priviledge'];
		}
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["operator"] = $operator;
		$_SESSION["priviledge"] = $check_user_priviledge;
		$day = date("d",strtotime("now"));
		$month = date("m",strtotime("now"));
		$year = date("Y",strtotime("now"));
		switch ($operator) {
			case "glacier_guides":
				$landing_page = "guides_schedule";
				break;
			case "snowmobile":
				$landing_page = "guides_schedule";
				break;
			case "arctic_adventures":
				$landing_page = "daily_agenda";
				break;
		}
		header("Location: $landing_page.php?day=$day&month=$month&year=$year");
		die();
	} else {
		login("<div class='login_alert alert-danger well-sm'><strong>Login failed.</strong> Check username and password.</div>");
	}
} else {
	login("<div class='login_alert alert-info well-sm'>Please enter your username and password.</div>");
}