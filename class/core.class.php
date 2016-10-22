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
		      window.location.replace('admin.php')
	   	}
		,2000);

	   	</script>
		<?php
	}

	// Login form
	public function login($msg) {
		$data = array();
		if ($msg != "") {
			$data['msg'] = "$msg";	
		} else {
			$data['msg'] = "0";
		}
		$template = "login.tpl";
		$this->load_smarty($data,$template);
	}

	/* This function will check if the logged in user is an admin. If not this function will end the process. */
	public function is_admin() {

		if ($_SESSION['userType'] != "Admin") {
			print "<br><font color=red>The section you attempted to access requires to be an admin.<br></font>";
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

}
?>
