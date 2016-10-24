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

	public function delete_employee() {
                $this->is_access('Employer');
	}
}
?>
