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

$p = $_POST['p'];
$np = $_POST['np'];
$u = $_POST['u'];
$nu = $_POST['nu'];

if($p != "" && $np != ""){

if(strlen($np) <= 7){
echo "Password is too short";
exit();
}

$p = md5($p);
$np = md5($np);

$conn = &ADONewConnection('mysqli');
$conn->PConnect('localhost','root','anototexeg37','site1');
$result = $conn->Execute("select * FROM adminPassword WHERE `username` = '$u' AND `password` = '$p' AND `current` = 1");
if ($result->RecordCount() == 0){
 echo "invalid credentials";
 exit();
} else {
$result = $conn->Execute("select * FROM adminPassword WHERE `password` = '$np'");
if ($result->RecordCount() != 0){
 echo "You have used this password before";
 exit();
}
$result = $conn->Execute("UPDATE adminPassword set `current` = 0 WHERE `current` = 1");
$result = $conn->Execute("INSERT INTO `site1`.`adminPassword` (`username`, `password`, `current`) VALUES ('$nu', '$np', '1');");
echo "Updated";
}
$result->Close();
$conn->Close();
} else {
?>
<form method="POST" action="password.php">
<p>All fields must be filled out, otherwise the account might be locked out</p>
Current username: <input type="text" name="u"><br>
New username: <input type="text" name="nu"><br>
Current Password: <input type="password" name="p"><br>
New Password: <input type="password" name="np"><br>
<input type="submit" name="submit">
</form>
<?php
}
?>
