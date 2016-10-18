<?php
session_start();
include "include/settings.php";
include "include/templates.php";

// header
$smarty->display('header.tpl');

$check = $core->check_login();
if ($check == "FALSE") {
        if ($section == "forgot_pw") {
                $smarty->display('forgot_pw.tpl');
        } else {
                $smarty->display('login.tpl');
        }
} else {
        if ($section == "") {
                $core->load_module('dashboard');
        }

        if ($section != "") {
                $core->load_module($section);
        }
}
?>
