<?php
session_start();

$sesID = session_id();
// init
include_once "../include/settings.php";
include_once "../include/templates.php";

if ($_GET['email'] != "") {
	$new_pw = $core->randomPassword();
	$new_pw_md5 = md5($new_pw);
	$sql = "UPDATE `admin_users` SET `uupass` = '$new_pw_md5' WHERE `email` = '$_GET[email]'";
	$result = $core->new_mysql($sql);

	$sql = "SELECT * FROM `admin_users` WHERE `email` = '$_GET[email]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$email = $row['email'];
		$uuname = $row['uuname'];
		$fname = $row['fname'];
		$lname = $row['lname'];
	}

	$subj = "Your password for ".SITENAME;
	$msg = "$fname $lname,<br>You have requested your admin password to be reset on ".SITENAME.".<br><br>
	Username: $uuname<br>
	New Password: $new_pw<br><br>Please note once you login you will be able to change your password.<br>";

	mail($_GET['email'],$subj,$msg,header_email);
}

print "<br><br><font color=green>Your password has been sent to your email address.</font><br>";
?>
