<?php
session_start();
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
if (!$_SESSION['admin']){
	echo "Cannot execute";
	exit();
}
include ('../include/adodb/adodb.inc.php');
$ID = $_GET['id'];
if ($ID){
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$result = $conn->Execute("select * FROM ideas WHERE ID = $ID");
	while (!$result->EOF){
		$sql = "select * FROM users WHERE `id` = '" . $result->fields[1] . "'";
		$user = $conn->Execute($sql);
		$lname = $user->fields[4];
		$name = $user->fields[3] . " " . $lname;
		echo "Submission ID: " . $result->fields[0] . "<br>";
		echo "Submitted by ";
		echo $name . " (User ID: " . $user->fields[0] . "; Email: " . $user->fields[1] . ")<br>";
		echo $result->fields[2];
		echo PHP_EOL;
		$result->MoveNext();
	}
	$result->Close();
	$conn->Close();
} else {
	echo "<h1>Top 1000 Submissions</h1>";
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$result = $conn->Execute('select * FROM ideas WHERE `approved` = 1 ORDER BY votes DESC LIMIT 1000');
	if(!$result) {
		print $conn->ErrorMsg();
	}
	else
	while (!$result->EOF){
		print '<a href="status.php?id='.$result->fields[0].'">'.substr($result->fields[2], 0, 80).'</a> - Votes: ' . $result->fields[5] . '<BR>';
		$result->MoveNext();
	}
	if ($result->RecordCount() == 0) { echo "No approved submissions at this time"; }
	$result->Close();
	$conn->Close();
}
?>
