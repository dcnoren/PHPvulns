<?php
session_start();
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
if (!$_SESSION['admin']){
	?>
	<form method="POST" action="login.php">
	Username: <input type="text" name="username"><br>
	Password: <input type="password" name="password"><br>
	<input type="submit" name="submit">
	</form>
	<?php
} else {
	include ('../include/adodb/adodb.inc.php');
	?>
	Hey there :) - <a href="logout.php">logout</a>
	<p>Some links:</p>
	<ul>
	<li><a href="reviewIdea.php">Moderate Submissions</a></li>
	<li><a href="status.php">Submission Stats</a></li>
	<li><a href="password.php">Change Password</a></li>
	</ul>
<?php
}
?>
