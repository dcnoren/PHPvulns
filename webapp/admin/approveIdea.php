<?php
session_start();
include ('../include/adodb/adodb.inc.php');
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
if (!$_SESSION['admin']){
	echo "Cannot execute";
	exit();
}
$ID = $_POST['id'];
if ($ID){
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$result = $conn->Execute("update ideas SET `approved` = '1' WHERE `ID` = $ID");
	$result->Close();
	$conn->Close();
	echo "Idea ID " . $ID . " approved";
	echo "<br>";
	echo "<a href=\"reviewIdea.php\">Go back</a>";
} else {
	echo "Error";
}
?>
