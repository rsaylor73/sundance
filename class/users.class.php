<?php

include PATH."/class/employees.class.php";

class users extends employees {

        public function profilea() {
                $this->is_access('Admin');
                foreach ($_SESSION as $key=>$value) {
                        $data[$key] = $value;
                }
                $template = "profilea.tpl";
                $this->load_smarty($data,$template);
        }

        public function save_profilea() {
                $this->is_access('Admin');
                $sql = "SELECT * FROM `admin_users` WHERE `uuname` != '$_SESSION[uuname]' AND `email` = '$_POST[email]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        print "<br><br><font color=red>Sorry, <b>$_POST[email]</b> is already registered.</font><br><br>";
                        die;
                }

                $md5_pw = md5($_POST['uupass']);

                $sql = "UPDATE `admin_users` SET  `uupass` = '$md5_pw' WHERE `uuname` = '$_SESSION[uuname]'";
                $result = $this->new_mysql($sql);
                print "<br><br>Your profile has been updated.<br><br>";
        }


	public function admins() {
                $this->is_access('Admin');
		$template = "admins.tpl";
		$data['html'] = $this->list_admin_users();
		$this->load_smarty($data,$template);
	}

	public function new_admin() {
                $this->is_access('Admin');
                $template = "new_admin.tpl";
                $this->load_smarty($null,$template);
	}

	public function edit_admin() {
                $this->is_access('Admin');
		$sql = "SELECT * FROM `admin_users` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "edit_admin.tpl";
		$this->load_smarty($data,$template);
	}

	public function update_admin() {
                $this->is_access('Admin');
		if ($_POST['uupass'] != "") {
			$uupass = md5($_POST['uupass']);
			$uupass_sql = ",`uupass` = '$uupass'";
		}
		$sql = "UPDATE `admin_users` SET `fname` = '$_POST[fname]', `lname` = '$_POST[lname]', `email` = '$_POST[email]', `active` = '$_POST[active]' $uupass_sql WHERE `id` = '$_POST[id]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        print "<br><font color=green>The admin user was updated.</font><br>";
                } else {
                        print "<br><font color=red>There was an error saving the user.</font><br>";
                }
	}

	public function delete_admin() {
                $this->is_access('Admin');
		if ($_SESSION['id'] != $_GET['id']) {
			$sql = "DELETE FROM `admin_users` WHERE `id` = '$_GET[id]'";
        	        $result = $this->new_mysql($sql);
                	if ($result == "TRUE") {
	                        print "<br><font color=green>The admin user was deleted.</font><br>";
        	        } else {
                	        print "<br><font color=red>There was an error saving the user.</font><br>";
	                }
		}
	}

	public function save_new_admin() {
                $this->is_access('Admin');
		$uupass = md5($_POST['uupass']);
		$sql = "INSERT INTO `admin_users` (`fname`,`lname`,`email`,`uuname`,`uupass`,`active`,`userType`) VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[uuname]','$uupass','$_POST[active]','Admin')";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        print "<br><font color=green>The admin user was created.</font><br>";
                } else {
                        print "<br><font color=red>There was an error saving the user.</font><br>";
                }
	}

	public function list_admin_users() {
		$sql = "SELECT `id`,`fname`,`lname`,`email`,`active` FROM `admin_users` ORDER BY `lname` ASC, `fname` ASC, `active` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$html .= "<tr><td>$row[fname] $row[lname]</td><td>$row[active]</td><td>
                        <input type=\"button\" value=\"Edit\" class=\"btn btn-primary\" onclick=\"document.location.href='admin.php?section=edit_admin&id=$row[id]'\">
                        &nbsp;&nbsp;
			";
			if ($_SESSION['id'] != $row['id']) {
				$html .= "
	                        <input type=\"button\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"if(confirm('You are about to delete $row[fname] $row[lname]. Click OK to continue.')) { 
                                document.location.href='admin.php?section=delete_admin&id=$row[id]';}\">
				";
			}
        	        $html .= "</td></tr>";
                }
                return($html);

	}

	public function users() {
                $this->is_access('Admin');
		$template = "users.tpl";
		$html = $this->list_users();
		$data['html'] = $html;

		$this->load_smarty($data,$template);
	}


	public function new_employer() {
                $this->is_access('Admin');
		$states = $this->get_states($null);
		$data['states'] = $states;
		$template = "new_employer.tpl";
		$this->load_smarty($data,$template);
	}

	public function list_users() {
                $this->is_access('Admin');

                $sql = "SELECT * FROM `users` ORDER BY `company` ASC";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $ssn = substr($row['ssn'],-4);
                        $html .= "<tr><td>$row[company]</td><td>$row[city], $row[state]</td><td>
                                <input type=\"button\" value=\"Edit\" class=\"btn btn-primary\" onclick=\"document.location.href='admin.php?section=edit_employer&id=$row[id]'\">
                                &nbsp;&nbsp;
                                <input type=\"button\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"if(confirm('You are about to delete $row[company]. THIS WILL ALSO DELETE EVERY EMPLOYEE UNDER $row[company]. Click OK to continue.')) { 
                                document.location.href='admin.php?section=delete_employer&id=$row[id]';}\">
                        </td></tr>";
                        $found = "1";
                }
                if ($found != "1") {
                        $html = "<tr><td colspan=\"4\"><font color=blue>You do not have any employers. Please add one.</font></td></tr>";
                }
                return($html);

	}

	public function edit_employer() {
                $this->is_access('Admin');
                $states = $this->get_states('1');
                $data['states'] = $states;
		$sql = "SELECT * FROM `users` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "edit_employer.tpl";
		$this->load_smarty($data,$template);
	}

	public function save_new_user() {
                $this->is_access('Admin');

                foreach ($_POST as $key=>$value) {
                        $p[$key] = $this->linkID->real_escape_string($value);
                }

		$sql = "SELECT `email` FROM `users` WHERE `email` = '$p[email]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			print "<br><font color=red>Sorry, the email <b>$p[email]</b> is already in use. Please click back and try again.</font><br>";
			die;
		}

		$sql = "SELECT `uuname` FROM `users` WHERE `uuname` = '$p[uuname]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			print "<br><font color=red>Sorry, the username <b>$p[uuname]</b> is already in use. Please click back and try again.</font><br>";
			die;
		}

		// logo
                $fileName = $_FILES['logo']['name'];
                $tmpName  = $_FILES['logo']['tmp_name'];
                $fileSize = $_FILES['logo']['size'];
                $fileType = $_FILES['logo']['type'];

                move_uploaded_file("$tmpName", "images/logo/companies/$fileName");
                chmod("images/logo/companies/$fileName", 0644);

		$p['uupass'] = md5($p['uupass']);
		$today = date("Ymd");

		$file = "images/logo/companies/" . $fileName;

		$sql = "INSERT INTO `users` (`uuname`,`uupass`,`userType`,`email`,`date_added`,`date_updated`,`active`,
		`address`,`city`,`state`,`zip`,`m_address`,`m_city`,`m_state`,`m_zip`,`main_phone`,
		`fax`,`contact_name`,`title`,`contact_phone`,`contact_name2`,`title2`,`contact_phone2`,`mobile`,
		`company`,`company_type`,`website`,`num_employees`,`time_zone`,`fiscal_year_month`,`sic`,
		`ein`,`duns`,`broker`,`logo`)
		VALUES
		('$p[uuname]','$p[uupass]','Employer','$p[email]','$today','$today','Yes',
                '$p[address]','$p[city]','$p[state]','$p[zip]','$p[m_address]','$p[m_city]','$p[m_state]','$p[m_zip]','$p[main_phone]',
                '$p[fax]','$p[contact_name]','$p[title]','$p[contact_phone]','$p[contact_name2]','$p[title2]','$p[contact_phone2]','$p[mobile]',
                '$p[company]','$p[company_type]','$p[website]','$p[num_employees]','$p[time_zone]','$p[fiscal_year_month]','$p[sic]',
                '$p[ein]','$p[duns]','$p[broker]','$file')
		";

		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<br><font color=green>The employer user was created.</font><br>";
		} else {
			print "<br><font color=red>There was an error saving the user.</font><br>";
		}
	}

	public function update_new_user() {
                $this->is_access('Admin');

                foreach ($_POST as $key=>$value) {
                        $p[$key] = $this->linkID->real_escape_string($value);
                }

                $fileName = $_FILES['logo']['name'];
       	        $tmpName  = $_FILES['logo']['tmp_name'];
               	$fileSize = $_FILES['logo']['size'];
                $fileType = $_FILES['logo']['type'];

		if ($fileName != "") {
        	        move_uploaded_file("$tmpName", "images/logo/companies/$fileName");
                	chmod("images/logo/companies/$fileName", 0644);
	                $file = "images/logo/companies/" . $fileName;

			$logo_sql = ",`logo` = '$file'";
		}

		if ($_POST['uupass'] != "") {
			$uupass = md5($_POST['uupass']);
			$uupass_sql = ",`uupass` = '$uupass'";
		}

		$today = date("Ymd");
		$sql = "UPDATE `users` SET `email` = '$p[email]', `date_updated` = '$today', `active` = '$p[active]', `address` = '$p[address]', `city` = '$p[city]', `state` = '$p[state]',
		`zip` = '$p[zip]', `m_address` = '$p[m_address]', `m_city` = '$p[m_city]', `m_state` = '$p[m_state]', `m_zip` = '$p[m_zip]', `main_phone` = '$p[main_phone]', `fax` = '$p[fax]',
		`contact_name` = '$p[contact_name]', `title` = '$p[title]', `contact_phone` = '$p[contact_phone]', `contact_name2` = '$p[contact_name2]', `title2` = '$p[title2]',
		`contact_phone2` = '$p[contact_phone2]', `mobile` = '$p[mobile]', `company` = '$p[company]', `company_type` = '$p[company_type]', `website` = '$p[website]', `num_employees` = 
		'$p[num_employees]', `time_zone` = '$p[time_zone]', `fiscal_year_month` = '$p[fiscal_year_month]', `sic` = '$p[sic]', `ein` = '$p[ein]', `duns` = '$p[duns]', `broker` = '$p[broker]'
		$logo_sql $uupass_sql WHERE `id` = '$_POST[id]'
		";

                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        print "<br><font color=green>The employer user was updated.</font><br>";
                } else {
                        print "<br><font color=red>There was an error saving the user.</font><br>";
                }
	}

	public function delete_employer() {
                $this->is_access('Admin');

		$sql = "DELETE FROM `users` WHERE `id` = '$_GET[id]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
			// delete employees
			$sql2 = "DELETE FROM `employee` WHERE `employer_id` = '$_GET[id]'";
			$result2 = $this->new_mysql($sql2);
                        print "<br><font color=green>The employer user was deleted.</font><br>";
                } else {
                        print "<br><font color=red>There was an error deleting the user.</font><br>";
                }
	}
}
?>
