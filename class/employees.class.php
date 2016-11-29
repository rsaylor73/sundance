<?php

include PATH."/class/api.class.php";

class employees extends api {

        public function profile() {
                $this->is_access('Employer');
                foreach ($_SESSION as $key=>$value) {
                        $data[$key] = $value;
                }
                $template = "profile.tpl";
                $this->load_smarty($data,$template);
        }

        public function save_profile() {
                $this->is_access('Employer');
                $sql = "SELECT * FROM `users` WHERE `uuname` != '$_SESSION[uuname]' AND `email` = '$_POST[email]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        print "<br><br><font color=red>Sorry, <b>$_POST[email]</b> is already registered.</font><br><br>";
                        die;
                }

                $md5_pw = md5($_POST['uupass']);

                $sql = "UPDATE `users` SET  `uupass` = '$md5_pw' WHERE `uuname` = '$_SESSION[uuname]'";
                $result = $this->new_mysql($sql);
                print "<br><br>Your profile has been updated.<br><br>";
        }


	public function employees() {
		$this->is_access('Employer');
		$template = "employees.tpl";
		$html = $this->list_employee();
		$data['html'] = $html;

		$this->load_smarty($data,$template);
	}

	public function edit_spouse() {
                $this->is_access('Employer');
                $states = $this->get_states($null);
                $template = "edit_spouse.tpl";

		// get spouse data if any
		$sql = "
		SELECT
			`s`.*

		FROM
			`spouse` s, `employee` e

		WHERE
			`s`.`employeeID` = '$_GET[id]'
			AND `s`.`employeeID` = `e`.`id`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			$found = "1";
			$data['type'] = "update";
                        $states = $this->get_states($row['State']);
                        $data['states'] = $states;
			$data['ssn2'] = substr($row['SSN'], -4);
		}
		if ($found != "1") {
			$data['type'] = "new";
			$data['employeeID'] = $_GET['id'];
                        $states = $this->get_states($null);
                        $data['states'] = $states;
		}
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

	/* This will update the spouse record */
	public function update_spouce() {
                $this->is_access('Employer');

                foreach ($_POST as $key=>$value) {
                        $p[$key] = $this->linkID->real_escape_string($value);
                }

		$sql = "SELECT `employeeID` FROM `spouse` WHERE `employeeID` = '$p[employeeID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$found = "1";
		}

		if ($found == "1") {
			// update
			if ($p['SSN'] != "") {
				$ssn = ",`SSN` = '$p[SSN]'";
			}

			$sql = "UPDATE `spouse` SET `FirstName` = '$p[FirstName]', `MiddleName` = '$p[MiddleName]', `LastName` = '$p[LastName]',
			`Gender` = '$p[Gender]', `DOB` = '$p[DOB]', `EmailAddress` = '$p[EmailAddress]', `PhoneNumber` = '$p[PhoneNumber]',
			`Street` = '$p[Street]', `City` = '$p[City]', `State` = '$p[State]', `PostalCode` = '$p[PostalCode]' $ssn
			WHERE `employeeID` = '$p[employeeID]'
			";

		} else {
			// insert
			$sql = "INSERT INTO `spouse` (`employeeID`,`FirstName`,`MiddleName`,`LastName`,`SSN`,`Gender`,`DOB`,`EmailAddress`,`PhoneNumber`,
			`Street`,`City`,`State`,`PostalCode`) VALUES ('$p[employeeID]','$p[FirstName]','$p[MiddleName]','$p[LastName]','$p[SSN]','$p[Gender]',
			'$p[DOB]','$p[EmailAddress]','$p[PhoneNumber]','$p[Street]','$p[City]','$p[State]','$p[PostalCode]')";
		}
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<br><font color=green>The record was saved. Loading...</font><br>";
		} else {
			print "<br><font color=red>The record failed to update. Loading...</font><br>";
		}

                ?>
                <script>
                setTimeout(function() {
                        document.location.href='employer.php?section=employees';
                }
                ,2000);
                </script>
                <?php
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
		`sundance_id`,`EmployeeNumber`,`FirstName`,`MiddleName`,`LastName`,`SSN`,`Gender`,`pay_frequency`,`annual_salary`,
		`hourly_rate`,`w4_marital`,`w4_dependents`,
		`health_monthly_premium`,`employer_monthly_contribution`,`pretax_premium_monthly`,`hsa`,`EmailAddress`,`PhoneNumber`,
		`Street`,`City`,`State`,`PostalCode`,`full_time`,`EmployeeStatus`,`misc`,`date_of_hire`,
                `TerminationDate`,`DOB`,`CountryCode`,`WorkStreet`,`WorkPOBox`,`WorkSuite`,`WorkCity`,`WorkState`,
                `WorkZip`,`WorkCountryCode`,`ServiceLevelCode`,`WorkLocationCode`,`WorkLocationDescription`,
                `CompanyAccountCode`,`CompanyAccountDescription`,`Department`,`DepartmentDescription`,
                `CompanyCode`,`OnHealthPlan`,`HealthProvider`,`HealthPlanType`,`HealthPlanID`,
                `Last4SSN`,`BenefitStatusCode`,`Relationship`

		) VALUES (
		'$sundance_id','$_SESSION[id]','$p[employee]','$p[middle]','$p[last]','$p[ssn]','$p[gender]','$p[pay_frequency]','$p[annual_salary]','$p[hourly_rate]','$p[w4_marital]','$p[w4_dependents]',
		'$p[health_monthly_premium]','$p[employer_monthly_contribution]','$p[pretax_premium_monthly]','$p[hsa]','$p[email]','$p[mobile]',
		'$p[address]','$p[city]','$p[state]','$p[zip]','$p[full_time]','$p[active]','$p[misc]','$p[date_of_hire]',

                '$p[TerminationDate]','$p[DOB]','$p[CountryCode]','$p[WorkStreet]','$p[WorkPOBox]','$p[WorkSuite]','$p[WorkCity]','$p[WorkState]',
                '$p[WorkZip]','$p[WorkCountryCode]','$p[ServiceLevelCode]','$p[WorkLocationCode]','$p[WorkLocationDescription]',
                '$p[CompanyAccountCode]','$p[CompanyAccountDescription]','$p[Department]','$p[DepartmentDescription]',
                '$p[CompanyCode]','$p[OnHealthPlan]','$p[HealthProvider]','$p[HealthPlanType]','$p[HealthPlanID]',
                '$p[Last4SSN]','$p[BenefitStatusCode]','$p[Relationship]'

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
		$sql = "SELECT * FROM `employee` WHERE `EmployeeNumber` = '$_SESSION[id]' ORDER BY `LastName` ASC, `FirstName` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$ssn = substr($row['SSN'],-4);
			$html .= "<tr><td>$row[FirstName] $row[LastName]</td><td>XXX-XX-$ssn</td><td>$row[City], $row[State]</td><td>
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

                $sql = "SELECT * FROM `employee` WHERE `id` = '$_GET[id]' AND `EmployeeNumber` = '$_SESSION[id]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key=>$value) {
                                $data[$key] = $value;
                        }
                        $ssn = substr($row['SSN'],-4);
	                $states = $this->get_states($row['State']);
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
			`FirstName` = '$p[employee]',
			`MiddleName` = '$p[middle]',
			`LastName` = '$p[last]',
			`Gender` = '$p[gender]',
			`pay_frequency` = '$p[pay_frequency]',
			`annual_salary` = '$p[annual_salary]',
			`hourly_rate` = '$p[hourly_rate]',
			`w4_marital` = '$p[w4_marital]',
			`w4_dependents` = '$p[w4_dependents]',
			`health_monthly_premium` = '$p[health_monthly_premium]',
			`employer_monthly_contribution` = '$p[employer_monthly_contribution]',
			`pretax_premium_monthly` = '$p[pretax_premium_monthly]',
			`hsa` = '$p[hsa]',
			`EmailAddress` = '$p[email]',
			`PhoneNumber` = '$p[mobile]',
			`Street` = '$p[address]',
			`City` = '$p[city]',
			`State` = '$p[state]',
			`PostalCode` = '$p[zip]',
			`full_time` = '$p[full_time]',
			`EmployeeStatus` = '$p[active]',
			`misc` = '$p[misc]',
			`date_of_hire` = '$p[date_of_hire]',
			`TerminationDate` = '$p[TerminationDate]',
			`DOB` = '$p[DOB]',
			`CountryCode` = '$p[CountryCode]',
			`WorkStreet` = '$p[WorkStreet]',
			`WorkPOBox` = '$p[WorkPOBox]',
			`WorkSuite` = '$p[WorkSuite]',
			`WorkCity` = '$p[WorkCity]',
			`WorkState` = '$p[WorkState]',
			`WorkZip` = '$p[WorkZip]',
			`WorkCountryCode` = '$p[WorkCountryCode]',
			`ServiceLevelCode` = '$p[ServiceLevelCode]',
			`WorkLocationCode` = '$p[WorkLocationCode]',
			`WorkLocationDescription` = '$p[WorkLocationDescription]',
			`CompanyAccountCode` = '$p[CompanyAccountCode]',
			`CompanyAccountDescription` = '$p[CompanyAccountDescription]',
			`Department` = '$p[Department]',
			`DepartmentDescription` = '$p[DepartmentDescription]',
			`CompanyCode` = '$p[CompanyCode]',
			`OnHealthPlan` = '$p[OnHealthPlan]',
			`HealthProvider` = '$p[HealthProvider]',
			`HealthPlanType` = '$p[HealthPlanType]',
			`HealthPlanID` = '$p[HealthPlanID]',
			`Last4SSN` = '$p[Last4SSN]',
			`BenefitStatusCode` = '$p[BenefitStatusCode]',
			`Relationship` = '$p[Relationship]'

		WHERE `id` = '$p[id]' AND `EmployeeNumber` = '$_SESSION[id]'
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
		$sql = "DELETE FROM `employee` WHERE `id` = '$_GET[id]' AND `EmployeeNumber` = '$_SESSION[id]'";
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
				if ($data[0] == "First") {
					// skip
					$c = $num;
				} else { 
					$employee 			= $data[0];
					$middle				= $data[1];
					$last				= $data[2];
					$ssn				= $data[3];
					$gender				= $data[4];
					$pay_frequency			= $data[5];
					$annual_salary			= $data[6];
					$hourly_rate			= $data[7];
					$w4_marital			= $data[8];
					$w4_dependents			= $data[9];
					$health_monthly_premium		= $data[10];
					$employer_monthly_contribution	= $data[11];
					$pretax_premium_monthly		= $data[12];
					$hsa				= $data[13];
					$email				= $data[14];
					$mobile				= $data[15];
					$address			= $data[16];
					$city				= $data[17];
					$state				= $data[18];
					$zip				= $data[19];
					$full_time			= $data[20];
					$active				= $data[21];
					$misc				= $data[22];
					$date_of_hire			= $data[23];
					$TerminationDate		= $data[24];
					$DOB				= $data[25];
					$CountryCode			= $data[26];
					$WorkStreet			= $data[27];
					$WorkPOBox			= $data[28];
					$WorkSuite			= $data[29];
					$WorkCity			= $data[30];
					$WorkState			= $data[31];
					$WorkZip			= $data[32];
					$WorkCountryCode		= $data[33];
					$ServiceLevelCode		= $data[34];
					$WorkLocationCode		= $data[35];
					$WorkLocationDescription	= $data[36];
					$CompanyAccountCode		= $data[37];
					$CompanyAccountDescription	= $data[38];
					$Department			= $data[39];
					$DepartmentDescription		= $data[40];
					$CompanyCode			= $data[41];
					$OnHealthPlan			= $data[42];
					$HealthProvider			= $data[43];
					$HealthPlanType			= $data[44];
					$HealthPlanID			= $data[45];
					$Last4SSN			= $data[46];
					$BenefitStatusCode		= $data[47];
					$Relationship			= $data[48];

					$date_of_hire = date("Y-m-d", strtotime($date_of_hire));
					$full_time = strtolower($full_time);
					$full_time = ucfirst($full_time);
					$active = strtolower($active);
					$active = ucfirst($active);

					$sql2 = "SELECT `EmailAddress` FROM `employee` WHERE `EmailAddress` = '$email'";
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

					$sql_array[] = "INSERT INTO `employee` (
					`sundance_id`,`EmployeeNumber`,`FirstName`,`MiddleName`,`LastName`,`SSN`,`Gender`,`pay_frequency`,
					`annual_salary`,`hourly_rate`,
					`w4_marital`,`w4_dependents`,`health_monthly_premium`,`employer_monthly_contribution`,
					`pretax_premium_monthly`,`hsa`,`EmailAddress`,
					`PhoneNumber`,`Street`,`City`,`State`,`PostalCode`,`full_time`,`EmployeeStatus`,`misc`,`date_of_hire`,

					`TerminationDate`,`DOB`,`CountryCode`,`WorkStreet`,`WorkPOBox`,`WorkSuite`,`WorkCity`,`WorkState`,
					`WorkZip`,`WorkCountryCode`,`ServiceLevelCode`,`WorkLocationCode`,`WorkLocationDescription`,
					`CompanyAccountCode`,`CompanyAccountDescription`,`Department`,`DepartmentDescription`,
					`CompanyCode`,`OnHealthPlan`,`HealthProvider`,`HealthPlanType`,`HealthPlanID`,
					`Last4SSN`,`BenefitStatusCode`,`Relationship`

					) 
					VALUES
					('$sundance_id','$_SESSION[id]','$employee','$middle','$last','$ssn','$gender','$pay_frequency',
					'$annual_salary','$hourly_rate',
					'$w4_marital','$w4_dependents','$health_monthly_premium','$employer_monthly_contribution',
					'$pretax_premium_monthly','$hsa','$email',
					'$mobile','$address','$city','$state','$zip','$full_time','$active','$misc','$date_of_hire,

                                        '$TerminationDate','$DOB','$CountryCode','$WorkStreet','$WorkPOBox','$WorkSuite','$WorkCity','$WorkState',
                                        '$WorkZip','$WorkCountryCode','$ServiceLevelCode','$WorkLocationCode','$WorkLocationDescription',
                                        '$CompanyAccountCode','$CompanyAccountDescription','$Department','$DepartmentDescription',
                                        '$CompanyCode','$OnHealthPlan','$HealthProvider','$HealthPlanType','$HealthPlanID',
                                        '$Last4SSN','$BenefitStatusCode','$Relationship'
					')";

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
