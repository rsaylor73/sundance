<?php
session_start();

$sesID = session_id();
// init
include_once "../include/settings.php";
include_once "../include/templates.php";

$_GET['uupass'] = md5($_GET['uupass']);

$sql = "SELECT * FROM `users` WHERE `uuname` = '$_GET[uuname]' AND `uupass` = '$_GET[uupass]'";
$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {
	foreach ($row as $key=>$value) {
	   	$_SESSION[$key] = $value;
	}
	$_SESSION['logged'] = "TRUE";
	$ok = "1";
	if ($row['active'] == "Yes") {
	   print "<div class=\"modal-body\"><br><br><font color=green>Login sucessfull. Loading please wait...</font><br><bR></div>";
	} else {
		print "<div class=\"modal-body\"><br><br><font color=orange>Sorry, but your account is no longer active. Loading please wait...</font><br><bR></div>";
	}

	?>
	<script>
	setTimeout(function() {
		document.location.href='employer.php?section=dashboard';
		//window.location.replace('employer.php?section=dashboard')
	}
	,2000);
	</script>
	<?php
}

if ($ok != "1") {
	print "<br><font color=red>Login incorrect. Please try again. Loading...<br></font>";
	?>
                        <script>
                        setTimeout(function() {
                                document.location.href='employer.php';
                        }
                        ,2000);
                        </script>
	<?php

}
?>

