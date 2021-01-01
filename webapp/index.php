<?php
session_start();
if(!isset($_SESSION['admin'])){
	$_SESSION['admin'] = false;
}
include ('include/adodb/adodb.inc.php');
$conn = &ADONewConnection('mysqli');
$conn->PConnect('localhost','root','anototexeg37','site1');
$sql = "select * FROM ideas WHERE `approved` = 1 ORDER BY votes DESC LIMIT 100";
$result = $conn->Execute($sql);
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
	$(".panelParent").mouseenter(function(){
		$(this).children(".panel").transition({y:'20px'});
	});

	$(".panelParent").mouseleave(function(){
		$(this).children(".panel").transition({y:'0px'});
	});

	$(".vote").on("click", function(){
		var id = $(this).attr('id');
		$(this).text("Voted");
		$.get('ajax/vote.php',{id: id});
		$(this).off();
	});
});
</script>
</head>
<body>

<div id="header">
<h2>Well hello!</h2>
<p>Thanks for stopping by! What would you do to change the world with $10,000 USD? Vote for an idea below, or <a href="submit.php">submit</a> your own! You can vote one time for up to 5 unique ideas.</p>
</div>

<div style="clear:both;"></div>

<div id="canvas">
<?php
while (!$result->EOF){
	$sql = "select * FROM users WHERE `id` = '" . $result->fields[1] . "'";
	$user = $conn->Execute($sql);
	$lname = $user->fields[4];
	$name = $user->fields[3] . " " . substr($lname, 0, 1) . ".";
	echo "<div class=\"panelParent\"><span id=\"" . $result->fields[0] . "\" class=\"vote\">Vote for this idea</span>";
	echo "<div class=\"panel\">";
	echo "<span class=\"name\">" . $name . "</span><span class=\"location\">from " . $user->fields[8] . ", " . $user->fields[9] . ":</span>";
	echo "<div class=\"text\">\"" . $result->fields[2] . "\"</div>";
	echo "</div>";
	echo "</div>";
	echo PHP_EOL;
	$result->MoveNext();
}
$result->Close();
$conn->Close();
?>

<div style="clear:both;"></div>

</div>

</body>
</html>
