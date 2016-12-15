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
	print '
		<style>
			.top-buffer { margin-top:10px; margin-left:10px; margin-right:10px; }
		</style>


		<div class="row top-buffer">
			<div class="col-sm-12">
				Welcome to My Mobile Health Plan. To get started please click to login as an Employer or an Employee.
			</div>
		</div>

	';
	break;


}

$smarty->display('footer.tpl');
?>
