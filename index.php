<?php
session_start();
include "include/settings.php";
include "include/templates.php";

// header
if ($_SESSION['logged'] == "TRUE") {
        $smarty->assign('userType',$_SESSION['userType']);
        $smarty->assign('logged','yes');
        $smarty->assign('logo',$_SESSION['logo']);
}

$smarty->display('header.tpl');

if ($_GET['section'] != "") {
	$section = $_GET['section'];
}
if ($_POST['section'] != "") {
	$section = $_POST['section'];
} 

switch ($section) {
	case "register":
	case "search":
	case "forgot_pw":
	case "forgot_pwa":
	$core->load_module($section);

	break;

	default:
	print "Welcome to Sundance Bennifits. To get started please click to login as an Employer or an Employee.<br>";
	break;

}

$smarty->display('footer.tpl');
?>
