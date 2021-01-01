<?php

//extract($_POST);

session_start();

extract($_POST);

if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
include ('include/adodb/adodb.inc.php');
include_once("include/clean.php");

//extract($_POST);

$fname 		= $_POST['fname'];
$fname = lx_externalinput_clean::basic($fname);

$lname 		= $_POST['lname'];
$lname = lx_externalinput_clean::basic($lname);

$email 		= $_POST['email'];
$lname = lx_externalinput_clean::basic($lname);

$city 		= $_POST['city'];
$city = lx_externalinput_clean::basic($city);

$state 		= $_POST['state'];
$state = lx_externalinput_clean::basic($state);

$month 		= $_POST['month'];
$month = lx_externalinput_clean::basic($month);

$day 		= $_POST['day'];
$day = lx_externalinput_clean::basic($day);
if($day >= 2){
$day = $day - 2;
}

$year 		= $_POST['year'];
$year = lx_externalinput_clean::basic($year);


$birthdate = $month . "/" . $day . "/" . $year;
$date = new DateTime($birthdate);
$now = new DateTime();
$interval = $now->diff($date);
$age = $interval->y;

$idea 		= $_POST['idea'];
$idea = lx_externalinput_clean::basic($idea);

$captcha 	= $_POST['captcha'];


IF(STRTOLOWER($captcha) == STRTOLOWER($_SESSION['captcha']) && $age >= 13){
$conn = &ADONewConnection('mysqli');
$conn->PConnect('localhost','root','anototexeg37','site1');
$sql = "INSERT INTO `site1`.`users` (`email`, `fname`, `lname`, `activated`, `priv`, `city`, `state`) VALUES ('$email', '$fname', '$lname', '1', '1', '$city', '$state');";
$result = $conn->Execute($sql);
$userID = $conn->Insert_ID();
$sql = "INSERT INTO `site1`.`ideas` (`userID`, `idea`) VALUES ('$userID', '$idea');";
$result = $conn->Execute($sql);
$message = "Success! Your idea will appear on the main page once approved. <a href=\"index.php\">Click here to go home.</a>";
} else {
$message = 'Cannot register at this time';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>BrightIdeas</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="include/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="include/js/jquery.transit.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

});
</script>
</head>
<body>

<div id="header">
<h2>Idea Submission</h2>
<div style="text-align: left;">
<p><?php echo $message; ?></p>
</div>
</div>

<div style="clear:both;"></div>

</body>
</html>
