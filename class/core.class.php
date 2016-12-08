<?php

/* This is the last class in the chain */

class core {

	public function new_mysql($sql) {
		$result = $this->linkID->query($sql) or die($this->linkID->error.__LINE__);
		return $result;
	}

	public function error() {
		// Generic error message
	      	$template = "error.tpl";
	      	$data = array();
      		$this->load_smarty($data,$template);
		die;
	}

        // this is the menu/dashboard for the employer user
        public function dashboard() {
                
		switch($_SESSION['userType']) {
			case "Admin":
				$this->users();
			break;

			case "Employer":
				$this->employees();
			break;

			case "Employee":
				$this->employee_dash();
			break;
		}
        }

	public function employee_dash() {
		print "<h2>Welcome $_SESSION[FirstName] $_SESSION[LastName]</h2>";

		print "<br><br>";
		print '<a href="'.LINK1.'" target="blank">'.TITLE1.'</a><br>';
                print '<a href="'.LINK2.'" target="blank">'.TITLE2.'</a><br>';
                print '<a href="'.LINK3.'" target="blank">'.TITLE3.'</a><br>';


	}

	public function register() {
		$template = "register.tpl";
		$this->load_smarty($null,$template);
	}

	public function search() {
		$sql = "
		SELECT
			`e`.`id`,
			`e`.`EmailAddress`
		FROM
			`employee` e,
			`users` u

		WHERE
			`e`.`EmployeeNumber` = `u`.`id`
			AND `u`.`company` = '$_POST[company]'
			AND `e`.`FirstName` = '$_POST[employee]'
			AND `e`.`LastName` = '$_POST[last]'
			AND SUBSTRING(`e`.`SSN`, -4) = '$_POST[ssn]'

		LIMIT 1
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$uupass = md5($_POST['uupass']);
			$sql2 = "UPDATE `employee` SET `uupass` = '$uupass' WHERE `id` = '$row[id]'";
			$result2 = $this->new_mysql($sql2);
			print "<br><br><font color=green>Your account has been registered. Click on Employee above then login using your email 
			<b>$row[email]</b> and the password you just created. If you forget your password you will need to re-register.</font><br><br>";
			$found = "1";
		}
		if ($found != "1") {
			// check for spouse
	                $sql = "
        	        SELECT
                	        `s`.`id`,
	                        `s`.`EmailAddress`
        	        FROM
                	        `employee` e,
                        	`users` u,
				`spouse` s

	                WHERE
				`s`.`employeeID` = `e`.`id`
        	                AND `e`.`EmployeeNumber` = `u`.`id`
                	        AND `u`.`company` = '$_POST[company]'
	                        AND `s`.`FirstName` = '$_POST[employee]'
        	                AND `s`.`LastName` = '$_POST[last]'
                	        AND SUBSTRING(`s`.`SSN`, -4) = '$_POST[ssn]'

	                LIMIT 1
        	        ";
	                $result = $this->new_mysql($sql);
			while ($row = $result->fetch_assoc()) {
				$uupass = md5($_POST['uupass']);
				$sql2 = "UPDATE `spouse` SET `uupass` = '$uupass' WHERE `id` = '$row[id]'";
	                        $result2 = $this->new_mysql($sql2);
	                        print "<br><br><font color=green>Your account has been registered. Click on Employee above then login using your email 
	                        <b>$row[email]</b> and the password you just created. If you forget your password you will need to re-register.</font><br><br>";
        	                $found = "1";
				if ($found != "1") {
					print "<br><br><font color=red>Sorry, but the information you entered does not match our records.</font><br><br>";
				}
			}
		}
		
	}

	public function forgot_pw() {
		$template = "forgot_pw.tpl";
		$this->load_smarty($null,$template);
	}

	public function forgot_pwa() {
                $template = "forgot_pwa.tpl";
                $this->load_smarty($null,$template);
        }
        // admin login check
        public function acheck_login() {
                $sql = "SELECT * FROM `admin_users` WHERE `uuname` = '$_SESSION[uuname]' AND `uupass` = '$_SESSION[uupass]' AND `active` = 'Yes'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $found = "1";
                        // update session data
                        foreach ($row as $key=>$value) {
                                $_SESSION[$key] = $value;
                        }
                }
                if ($found == "1") {
                        return "TRUE";
                } else {
                        $remote_addr = $_SERVER['REMOTE_ADDR'];
                        if ($remote_addr == SERVER_IP) { // Server IP of the virtual host
				$_SESSION['userType'] = "Admin";
                                return "TRUE";
                        } else {
                                return "FALSE";
                        }
                }
        }

	// employer login check
	public function check_login() {
		$sql = "SELECT * FROM `users` WHERE `uuname` = '$_SESSION[uuname]' AND `uupass` = '$_SESSION[uupass]' AND `active` = 'Yes'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
		      	$found = "1";
			// update session data
			foreach ($row as $key=>$value) {
				$_SESSION[$key] = $value;
			}
		}
	      	if ($found == "1") {
      			return "TRUE";
		} else {
			$remote_addr = $_SERVER['REMOTE_ADDR'];
			if ($remote_addr == SERVER_IP) { // Server IP of the virtual host
				return "TRUE";
			} else {
				return "FALSE";
			}
		}
	}

	// employee login check
	public function check_employee_login() {

		$sql = "
		SELECT `employee`.*, `users`.`logo`

		FROM 
			`employee`,`users`

		WHERE 
			`employee`.`EmailAddress` = '$_SESSION[EmailAddress]' 
			AND `employee`.`uupass` = '$_SESSION[uupass]'
			AND `employee`.`EmployeeNumber` = `users`.`id`

		";

                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $found = "1";
                        // update session data
                        foreach ($row as $key=>$value) {
				if ($key != "EmployeeNumber") {
	                                $_SESSION[$key] = $value;
				}
                        }
                }
                if ($found == "1") {
                        return "TRUE";
                } else {

		        // spouse
		        $sql = "
		        SELECT 
		                `employee`.`EmployeeStatus`,
		                `spouse`.*,
		                `users`.`logo`

		        FROM 
		               `employee`,`spouse`,`users`

		        WHERE 
		               `spouse`.`EmailAddress` = '$_SESSION[EmailAddress]' 
		                AND `spouse`.`uupass` = '$_SESSION[uupass]'
		                AND `spouse`.`employeeID` = `employee`.`id`
		                AND `employee`.`EmployeeNumber` = `users`.`id`
		        ";
	                $result = $this->new_mysql($sql);
	                while ($row = $result->fetch_assoc()) {
	        	        $found = "1";
        	                // update session data
	                        foreach ($row as $key=>$value) {
	                                $_SESSION[$key] = $value;
        	                }
                	}
			if ($found == "1") {
				return "TRUE";
			} else {
	                        $remote_addr = $_SERVER['REMOTE_ADDR'];
        	                if ($remote_addr == SERVER_IP) { // Server IP of the virtual host
	                                return "TRUE";
        	                } else {
                	                return "FALSE";
	                        }
			}
                }
	}

	public function load_smarty($vars,$template) {
		// loads the PHP Smarty class
		require_once(PATH.'/libs/Smarty.class.php');
		$smarty=new Smarty();
		$smarty->setTemplateDir(PATH.'/templates/');
		$smarty->setCompileDir(PATH.'/templates_c/');
		$smarty->setConfigDir(PATH.'/configs/');
		$smarty->setCacheDir(PATH.'/cache/');
		if (is_array($vars)) {
			foreach ($vars as $key=>$value) {
				$smarty->assign($key,$value);
			}
		}
		$smarty->display($template);
	}

	public function logout() {
		$data['msg'] = "<font color=green>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have been logged out. Loading...</font>";
		$this->load_smarty($data,'message.tpl');

		session_destroy();
		?>
	   	<script>
	  	setTimeout(function() {
		      window.location.replace('index.php')
	   	}
		,2000);

	   	</script>
		<?php
	}

	/* This function will check if the logged in user is an admin. If not this function will end the process. */
	// pass $type as Employer, Admin, User, etc
	public function is_access($type) {

		if ($_SESSION['userType'] != "$type") {
			print "<br><font color=red>Access Denied.<br></font>";
			die;
		}
	}


        /* This function returns the device type 
                returns 0 for desktop
                returns 1 for mobile
        */
	public function device_type() {
	        //print "TEST: $_SERVER[HTTP_USER_AGENT]<br>";
        	//die;
	        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|iphone|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	public function get_states($state) {
		if ($state == "") {
			$options .= "<option selected value=\"\">--Select--</option>";
		}
		$sql = "SELECT * FROM `state` ORDER BY `state` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($row['state_abbr'] == $state) {
				$options .= "<option selected value=\"$row[state_abbr]\">$row[state]</option>";
			} else {
                                $options .= "<option value=\"$row[state_abbr]\">$row[state]</option>";
			}
		}
		return($options);
	}

}
?>
