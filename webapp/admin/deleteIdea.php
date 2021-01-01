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
$ID = $_POST['id'];
if ($ID){
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$result = $conn->Execute("DELETE FROM ideas WHERE `ID` = $ID");
	$result->Close();
	$conn->Close();
	echo "Idea ID " . $ID . " deleted";
	echo "<br>";
	echo "<a href=\"reviewIdea.php\">Go back</a>";
} else {
	echo "Error line 3 deleteIdea.php";
}
?>
