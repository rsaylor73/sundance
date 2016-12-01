<?php

include PATH."/class/core.class.php";

class api extends core {

	public function export_csv() {
 	       $this->is_access('Admin');

		// employee
		$sql = "SHOW COLUMNS FROM `employee` WHERE `Field` NOT IN ('exported','UserName','uupass')";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$header .= "$row[Field],";
			$fields .= "`$row[Field]`,";
		}

		$header = trim($header,",");
		$header .= "\n";

		$fields = trim($fields,",");

		$sql = "SELECT `id`,`sundance_id`,`EmployeeNumber`,`FirstName`,`MiddleName`,`LastName`,`SSN`,`Gender`,`pay_frequency`,`annual_salary`,`hourly_rate`,`w4_marital`,`w4_dependents`,`health_monthly_premium`,`employer_monthly_contribution`,`pretax_premium_monthly`,`hsa`,`EmailAddress`,`PhoneNumber`,`Street`,`City`,`State`,`PostalCode`,`full_time`,`EmployeeStatus`,`misc`,`date_of_hire`,`TerminationDate`,`DOB`,`CountryCode`,`WorkStreet`,`WorkPOBox`,`WorkSuite`,`WorkCity`,`WorkState`,`WorkZip`,`WorkCountryCode`,`ServiceLevelCode`,`WorkLocationCode`,`WorkLocationDescription`,`CompanyAccountCode`,`CompanyAccountDescription`,`Department`,`DepartmentDescription`,`CompanyCode`,`OnHealthPlan`,`HealthProvider`,`HealthPlanType`,`HealthPlanID`,`Last4SSN`,`BenefitStatusCode`,`Relationship`,`exported`,`id` FROM `employee` WHERE `exported` != 'Yes'";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data .= "$row[id],$row[sundance_id],$row[EmployeeNumber],$row[FirstName],$row[MiddleName],$row[LastName],$row[SSN],$row[Gender],$row[pay_frequency],$row[annual_salary],$row[hourly_rate],$row[w4_marital],$row[w4_dependents],$row[health_monthly_premium],$row[employer_monthly_contribution],$row[pretax_premium_monthly],$row[hsa],$row[EmailAddress],$row[PhoneNumber],$row[Street],$row[City],$row[State],$row[PostalCode],$row[full_time],$row[EmployeeStatus],$row[misc],$row[date_of_hire],$row[TerminationDate],$row[DOB],$row[CountryCode],$row[WorkStreet],$row[WorkPOBox],$row[WorkSuite],$row[WorkCity],$row[WorkState],$row[WorkZip],$row[WorkCountryCode],$row[ServiceLevelCode],$row[WorkLocationCode],$row[WorkLocationDescription],$row[CompanyAccountCode],$row[CompanyAccountDescription],$row[Department],$row[DepartmentDescription],$row[CompanyCode],$row[OnHealthPlan],$row[HealthProvider],$row[HealthPlanType],$row[HealthPlanID],$row[Last4SSN],$row[BenefitStatusCode],$row[Relationship]\n";
			$sql2 = "UPDATE `employee` SET `exported` = 'Yes' WHERE `id` = '$row[id]'";
			$result2 = $this->new_mysql($sql2);
		}

		$today = date("Y_m_d");
		$filename = "employee_".$today.".csv";
		$file_e2 = $filename;
		$path = "/home/sundance/csv_export/";

		$file = $path . $filename;
		$file_e = $file;
		$f = fopen($file,"w");
		fwrite($f,$header);
		fwrite($f,$data);
		fclose($f);

		// spouse
                $sql = "SHOW COLUMNS FROM `spouse` WHERE `Field` NOT IN ('exported','id','uupass')";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $header2 .= "$row[Field],";
                        $fields2 .= "`$row[Field]`,";
                }       
                
                $header2 = trim($header2,",");
                $header2 .= "\n";
                
                $fields2 = trim($fields2,",");

		$sql = "SELECT `id`,`employeeID`,`FirstName`,`MiddleName`,`LastName`,`SSN`,`Gender`,`DOB`,`EmailAddress`,`PhoneNumber`,`Street`,`City`,`State`,`PostalCode` FROM `spouse` WHERE `exported` != 'Yes'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$data2 .= "$row[employeeID],$row[FirstName],$row[MiddleName],$row[LastName],$row[SSN],$row[Gender],$row[DOB],$row[EmailAddress],$row[PhoneNumber],$row[Street],$row[City],$row[State],$row[PostalCode]\n";
			$sql2 = "UPDATE `spouse` SET `exported` = 'Yes' WHERE `id` = '$row[id]'";
			$result2 = $this->new_mysql($sql2);
		}


                $filename = "spouse_".$today.".csv";
		$file_s2 = $filename;
                $path = "/home/sundance/csv_export/";

                $file = $path . $filename;
		$file_s = $file;
                $f = fopen($file,"w");
                fwrite($f,$header2);
                fwrite($f,$data2);
                fclose($f);


		$connection = ssh2_connect(SFTP_IP, SFTP_PORT);
		ssh2_auth_password($connection, SFTP_US, SFTP_PW);

		ssh2_scp_send($connection, $file_e, '/home/sftpc/csv/'.$file_e2, 0644);
                ssh2_scp_send($connection, $file_s, '/home/sftpc/csv/'.$file_s2, 0644);


		print "Done!<br>";

	}

}
?>
