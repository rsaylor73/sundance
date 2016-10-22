<?php
session_start();
include "include/settings.php";
include "include/templates.php";

// header
$smarty->display('header.tpl');

print "Welcome employee stuff goes here including login.<br>";

$smarty->display('footer.tpl');
?>
