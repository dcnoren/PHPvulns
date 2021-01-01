<?php
session_start();
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
if ($_SESSION['admin']){
	header('Location: admin/admin.php');
	exit();
}
include ('../include/adodb/adodb.inc.php');
$password = md5($_POST['password']);
$username = $_POST['username'];
$conn = &ADONewConnection('mysqli');
$conn->PConnect('localhost','root','anototexeg37','site1');
$result = $conn->Execute("SELECT * FROM adminPassword WHERE `username` = '$username' AND `password` = '$password'");
if ($result->RecordCount() == 1){
	$_SESSION['admin'] = true;
	header('Location: admin.php');
}
?>