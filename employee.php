<?php
session_start();
include "include/settings.php";
include "include/templates.php";

// header

if ($_GET['section'] != "") {
        $section = $_GET['section'];
}
if ($_POST['section'] != "") {
        $section = $_POST['section'];
}


if ($_SESSION['logged'] == "TRUE") {
        $smarty->assign('userType',$_SESSION['userType']);
        $smarty->assign('logged','yes');
        $smarty->assign('logo',$_SESSION['logo']);
}
$smarty->display('header.tpl');

$check = $core->check_employee_login();

if ($check == "FALSE") {
        $smarty->display('employee_login.tpl');
} else {
        if ($section == "") {
                $core->load_module('dashboard');
        }

        if ($section != "") {
                $core->load_module($section);
        }
}

$smarty->display('footer.tpl');
?>
