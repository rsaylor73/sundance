<?php

include PATH."/class/employees.class.php";

class users extends employees {

	// this is the menu/dashboard for the employer user
        public function dashboard() {
		print "<h2>Welcome $_SESSION[fname] $_SESSION[lname]</h2>";

        }

}
?>
