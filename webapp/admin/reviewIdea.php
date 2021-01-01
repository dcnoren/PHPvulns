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
	if(!$result) {
		print $conn->ErrorMsg();
	}
	else
	while (!$result->EOF){
		print 'Idea #'.$result->fields[0].'<BR>'.$result->fields[2].'<BR><form style="display: inline;" action="approveIdea.php" method="post"><input type="submit" value="Approve"><input type="hidden" name="id" value="'.$result->fields[0].'"></form>'.'<form style="display: inline;" action="deleteIdea.php" method="post"><input type="submit" value="Delete"><input type="hidden" name="id" value="'.$result->fields[0].'"></form>';
		$result->MoveNext();
	}
	$result->Close();
	$conn->Close();
} else {
	echo "<h1>Unapproved Submissions</h1><br>";
	$conn = &ADONewConnection('mysqli');
	$conn->PConnect('localhost','root','anototexeg37','site1');
	$result = $conn->Execute('select * FROM ideas WHERE approved = 0');
	if(!$result) {
		print $conn->ErrorMsg();
	}
	else
	while (!$result->EOF){
		print '<a href="reviewIdea.php?id='.$result->fields[0].'">Idea ID '.$result->fields[0].'</a><BR>';
		$result->MoveNext();
	}
	if ($result->RecordCount() == 0) { echo "No unapproved submissions at this time"; }
	$result->Close();
	$conn->Close();
}
?>
