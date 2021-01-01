<?php
session_start();
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
$session = session_id();
include ('../include/adodb/adodb.inc.php');
$id = $_GET['id'];
if ($id){
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$voted = $conn->Execute("SELECT * FROM votes WHERE `cookie` = '$session'"); 
	if ($voted->RecordCount() >= 5){
		$voted->Close();
		$conn->Close();
		exit();
	}
	$result = $conn->Execute("SELECT votes FROM ideas WHERE `ID` = $id"); 
	$count = $result->fields[0];
	$count++;
	$result = $conn->Execute("update ideas SET `votes` = $count WHERE `ID` = $id");
	$update = $conn->Execute("INSERT INTO votes (`cookie`, `idea`) VALUES ('$session','$id')");
	$result->Close();
	$conn->Close();
}
?>