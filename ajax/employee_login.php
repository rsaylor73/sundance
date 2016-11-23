<?php
session_start();

$sesID = session_id();
// init
include_once "../include/settings.php";
include_once "../include/templates.php";

$_GET['uupass'] = md5($_GET['uupass']);

//$sql = "SELECT * FROM `employee` WHERE `email` = '$_GET[email]' AND `uupass` = '$_GET[uupass]'";
$sql = "
                SELECT `employee`.*, `users`.`logo`

                FROM 
                        `employee`,`users`

                WHERE 
                        `employee`.`EmailAddress` = '$_GET[email]' 
                        AND `employee`.`uupass` = '$_GET[uupass]'
                        AND `employee`.`EmployeeNumber` = `users`.`id`
";

$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {
        foreach ($row as $key=>$value) {
                $_SESSION[$key] = $value;
        }
        $_SESSION['logged'] = "TRUE";
	$_SESSION['userType'] = "Employee";
        $ok = "1";
        if ($row['EmployeeStatus'] == "Yes") {
           print "<div class=\"modal-body\"><br><br><font color=green>Login sucessfull. Loading please wait...</font><br><bR></div>";
        } else {
                print "<div class=\"modal-body\"><br><br><font color=orange>Sorry, but your account is no longer active. Loading please wait...</font><br><bR></div>";
		session_destroy();
        }

        ?>
        <script>
        setTimeout(function() {
                document.location.href='employee.php?section=dashboard';
                //window.location.replace('employer.php?section=dashboard')
        }
        ,2000);
        </script>
        <?php
}


if ($ok != "1") {
	print "<font color=red><br>Login failed.</font>";
}

?>
