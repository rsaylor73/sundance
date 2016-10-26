<?php

include PATH."/class/api.class.php";

class employees extends api {

	public function employees() {
		$this->is_access('Employer');
		$template = "employees.tpl";
		$html = $this->list_employee();
		$data['html'] = $html;

		$this->load_smarty($data,$template);
	}

	public function new_employee() {
                $this->is_access('Employer');
		$states = $this->get_states($null);
		$template = "new_employee.tpl";
		$data['states'] = $states;
                $this->load_smarty($data,$template);
	}

	public function upload_csv() {
                $this->is_access('Employer');

		$template = "upload_csv.tpl";
                $this->load_smarty($null,$template);
	}

	public function save_employee() {
                $this->is_access('Employer');
		$company = str_replace(" ","",$_SESSION['company']);
		$company = strtoupper($company);
		$company = substr($company,0,4);
		$ssn4 = substr($_POST['ssn'],-4);
		$sundance_id = $company . $ssn4;

		foreach ($_POST as $key=>$value) {
			$p[$key] = $this->linkID->real_escape_string($value);
		}


		$sql = "INSERT INTO `employee` (
		`sundance_id`,`employer_id`,`employee`,`ssn`,`gender`,`pay_frequency`,`annual_salary`,`hourly_rate`,`w4_marital`,`w4_dependents`,
		`health_monthly_premium`,`employer_monthly_contribution`,`pretax_premium_monthly`,`hsa`,`email`,`mobile`,
		`address`,`city`,`state`,`zip`,`full_time`,`active`,`misc`,`date_of_hire`
		) VALUES (
		'$sundance_id','$_SESSION[id]','$p[employee]','$p[ssn]','$p[gender]','$p[pay_frequency]','$p[annual_salary]','$p[hourly_rate]','$p[w4_marital]','$p[w4_dependents]',
		'$p[health_monthly_premium]','$p[employer_monthly_contribution]','$p[pretax_premium_monthly]','$p[hsa]','$p[email]','$p[mobile]',
		'$p[address]','$p[city]','$p[state]','$p[zip]','$p[full_time]','$p[active]','$p[misc]','$p[date_of_hire]'
		)";

		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<br><font color=green>The employee was added. Loading...</font><br>";
			?>
		        <script>
		        setTimeout(function() {
		                document.location.href='employer.php?section=employees';
		        }
		        ,2000);
		        </script>
			<?php
		} else {
			print "<br><font color=red>There was an error saving the employee.</font><br>";
		}
	}

	public function list_employee() {
                $this->is_access('Employer');
		$sql = "SELECT * FROM `employee` WHERE `employer_id` = '$_SESSION[id]' ORDER BY `employee` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$ssn = substr($row['ssn'],-4);
			$html .= "<tr><td>$row[employee]</td><td>XXX-XX-$ssn</td><td>$row[city], $row[state]</td><td>
				<input type=\"button\" value=\"Edit\" class=\"btn btn-primary\" onclick=\"document.location.href='employer.php?section=edit_employee&id=$row[id]'\">
				&nbsp;&nbsp;
				<input type=\"button\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"if(confirm('You are about to delete $row[employee]. Click OK to continue.')) { 
				document.location.href='employer.php?section=delete_employee&id=$row[id]';}\">
			</td></tr>";
			$found = "1";
		}
		if ($found != "1") {
			$html = "<tr><td colspan=\"4\"><font color=blue>You do not have any employee's. Please add one.</font></td></tr>";
		}
		return($html);

	}


	public function edit_employee() {
                $this->is_access('Employer');
                $template = "edit_employee.tpl";

                $sql = "SELECT * FROM `employee` WHERE `id` = '$_GET[id]' AND `employer_id` = '$_SESSION[id]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key=>$value) {
                                $data[$key] = $value;
                        }
                        $ssn = substr($row['ssn'],-4);
	                $states = $this->get_states($row['state']);
	                $data['states'] = $states;
                }
                $data['ssn'] = $ssn;
                $this->load_smarty($data,$template);
	}

	public function update_employee() {
                $this->is_access('Employer');

                foreach ($_POST as $key=>$value) {
                        $p[$key] = $this->linkID->real_escape_string($value);
                }

		$sql = "
		UPDATE `employee` SET 
			`employee` = '$p[employee]',
			`gender` = '$p[gender]',
			`pay_frequency` = '$p[pay_frequency]',
			`annual_salary` = '$p[annual_salary]',
			`hourly_rate` = '$p[hourly_rate]',
			`w4_marital` = '$p[w4_marital]',
			`w4_dependents` = '$p[w4_dependents]',
			`health_monthly_premium` = '$p[health_monthly_premium]',
			`employer_monthly_contribution` = '$p[employer_monthly_contribution]',
			`pretax_premium_monthly` = '$p[pretax_premium_monthly]',
			`hsa` = '$p[hsa]',
			`email` = '$p[email]',
			`mobile` = '$p[mobile]',
			`address` = '$p[address]',
			`city` = '$p[city]',
			`state` = '$p[state]',
			`zip` = '$p[zip]',
			`full_time` = '$p[full_time]',
			`active` = '$p[active]',
			`misc` = '$p[misc]',
			`date_of_hire` = '$p[date_of_hire]'

		WHERE `id` = '$p[id]' AND `employer_id` = '$_SESSION[id]'
		";
		$result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        print "<br><font color=green>The employee was updated. Loading...</font><br>";
                        ?>
                        <script>
                        setTimeout(function() {
                                document.location.href='employer.php?section=employees';
                        }
                        ,2000);
                        </script>
                        <?php
                } else {
                        print "<br><font color=red>There was an error saving the employee.</font><br>";
                }

	}

	public function delete_employee() {
                $this->is_access('Employer');
		$sql = "DELETE FROM `employee` WHERE `id` = '$_GET[id]' AND `employer_id` = '$_SESSION[id]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        print "<br><font color=green>The employee was deleted. Loading...</font><br>";
                        ?>
                        <script>
                        setTimeout(function() {
                                document.location.href='employer.php?section=employees';
                        }
                        ,2000);
                        </script>
                        <?php
                } else {
                        print "<br><font color=red>There was an error saving the employee.</font><br>";
                }

	}

	public function process_csv() {
		$this->is_access('Employer');
                $fileName = $_FILES['csv']['name'];
                $tmpName  = $_FILES['csv']['tmp_name'];
                $fileSize = $_FILES['csv']['size'];
                $fileType = $_FILES['csv']['type'];

		if ($fileType != "text/csv") {
			$msg = "<br><br><font color=red>You did not select a CSV file. Please upload the proper file.</font><br><br>";
			$template = "error.tpl";
			$data['msg'] = $msg;
			$this->load_smarty($data,$template);
			die;
		}

		$new_file = date("U") . ".csv";
		move_uploaded_file($tmpName,"../csv_files/$new_file");	

		if ($handle = fopen("../csv_files/".$new_file,r)) {
    			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if ($data[0] == "Employee") {
					// skip
					$c = $num;
				} else { 
					$employee 			= $data[0];
					$ssn				= $data[1];
					$gender				= $data[2];
					$pay_frequency			= $data[3];
					$annual_salary			= $data[4];
					$hourly_rate			= $data[5];
					$w4_marital			= $data[6];
					$w4_dependents			= $data[7];
					$health_monthly_premium		= $data[8];
					$employer_monthly_contribution	= $data[9];
					$pretax_premium_monthly		= $data[10];
					$hsa				= $data[11];
					$email				= $data[12];
					$mobile				= $data[13];
					$address			= $data[14];
					$city				= $data[15];
					$state				= $data[16];
					$zip				= $data[17];
					$full_time			= $data[18];
					$active				= $data[19];
					$misc				= $data[20];
					$date_of_hire			= $data[21];

					$date_of_hire = date("Y-m-d", strtotime($date_of_hire));
					$full_time = strtolower($full_time);
					$full_time = ucfirst($full_time);
					$active = strtolower($active);
					$active = ucfirst($active);

					$sql2 = "SELECT `email` FROM `employee` WHERE `email` = '$email'";
					$result2 = $this->new_mysql($sql2);
					while ($row2 = $result2->fetch_assoc()) {
						print "<br><font color=red>The email <b>$email</b> is already registered. Please make sure all emails in the CSV file are unique and must have a value.</font><br>";
						die;
					}

					if (($pay_frequency != "Weekly") or ($pay_frequency != "Bi Weekly") or ($pay_frequency != "Monthly")) {
						$pay_frequency = "Weekly"; //default
					}

					if (($gender == "m") or ($gender == "M")) {
						$gender = "Male";
					}

					if (($gender == "f") or ($gender == "F")) {
						$gender = "Female";
					}


			                $company = str_replace(" ","",$_SESSION['company']);
			                $company = strtoupper($company);
			                $company = substr($company,0,4);
			                $ssn4 = substr($ssn,-4);
			                $sundance_id = $company . $ssn4;

					$sql_array[] = "INSERT INTO `employee` (`sundance_id`,`employer_id`,`employee`,`ssn`,`gender`,`pay_frequency`,`annual_salary`,`hourly_rate`,
					`w4_marital`,`w4_dependents`,`health_monthly_premium`,`employer_monthly_contribution`,`pretax_premium_monthly`,`hsa`,`email`,
					`mobile`,`address`,`city`,`state`,`zip`,`full_time`,`active`,`misc`,`date_of_hire`) VALUES
					('$sundance_id','$_SESSION[id]','$employee','$ssn','$gender','$pay_frequency','$annual_salary','$hourly_rate',
					'$w4_marital','$w4_dependents','$health_monthly_premium','$employer_monthly_contribution','$pretax_premium_monthly','$hsa','$email',
					'$mobile','$address','$city','$state','$zip','$full_time','$active','$misc','$date_of_hire')";


					//print "$employee | $ssn | $gender | $pay_frequency | $annual_salary | $hourly_rate | $w4_marital | $w4_dependents | $health_monthly_premium | $employer_monthly_contribution | $pretax_premium_monthly | $hsa | $email | $mobile | $address | $city | $state | $full_time | $active | $misc | $date_of_hire<Br><hr>";

    				}
			}
			foreach ($sql_array as $key=>$sql3) {
				$result3 = $this->new_mysql($sql3);
			}
			print "<br><font color=green>The records have been imported. If there were any errors they would be listed above.</font><br>";
		}
		fclose($handle);
	}





}
?>
