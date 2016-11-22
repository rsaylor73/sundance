<div id="main_element">
<h2>Edit Employee</h2>
<hr>
{$msg}

<form action="employer.php" name="myform" method="post">
<input type="hidden" name="section" value="update_employee">
<input type="hidden" name="id" value="{$id}">
<table class="table">
<tr>
	<td>Employee First Name:</td><td><input type="text" name="employee" size="30" required value="{$FirstName}"></td>
	<td>Middle Name:</td><td><input type="text" name="middle" size="30" value="{$MiddleName}"></td>
</tr>
<tr>
	<td>Last Name:</td><td><input type="text" name="last" size="30" value="{$LastName}"></td>
	<td>S.S.N:</td><td>xxx-xx-{$ssn}</td>
</tr>
<tr>
	<td>Gender:</td><td><select name="gender" required><option selected>{$Gender}</option><option>Male</option><option>Female</option></select></td>
	<td>Pay Frequency:</td><td><select name="pay_frequency" required><option selected>{$pay_frequency}</option><option>Weekly</option></select></td>
</tr>
<tr>
	<td>Annual Salary:</td><td>$<input type="text" name="annual_salary" size="30" value="{$annual_salary}" required placeholder="Numbers only" onkeypress="return isNumber(event)"></td>
	<td>Hourly Rate:</td><td>$<input type="text" name="hourly_rate" size="30" value="{$hourly_rate}" required placeholder="example 24.50"</td>
</tr>
<tr>
	<td>W-4 Marital Status:</td><td><input type="text" name="w4_marital" size="30" value="{$w4_marital}" required></td>
	<td>W-4 Dependents:</td><td><input type="text" name="w4_dependents" size="30" value="{$w4_dependents}" required></td>
</tr>
<tr>
	<td>Total Health Monthly Premium:</td><td><input type="text" name="health_monthly_premium" value="{$health_monthly_premium}" size="30"></td>
	<td>Employer Monthly Contribution:</td><td><input type="text" name="employer_monthly_contribution" value="{$employer_monthly_contribution}" size="30"></td>
</tr>
<tr>
	<td>PreTax Premium Monthly Total:</td><td><input type="text" name="pretax_premium_monthly" value="{$pretax_premium_monthly}" size="30"></td>
	<td>H.S.A.:</td><td><input type="text" name="hsa" value="{$hsa}" size="30"></td>
</tr>
<tr>
	<td>Personal Email:</td><td><input type="text" name="email" value="{$EmailAddress}" size="30" required></td>
	<td>Phone Number:</td><td><input type="text" name="mobile" value="{$PhoneNumber}" size="30"></td>
</tr>
<tr>
	<td>Street:</td><td><input type="text" name="address" size="30" value="{$Street}" required></td>
	<td>City:</td><td><input type="text" name="city" size="30" value="{$City}" required></td>
</tr>
<tr>
	<td>State:</td><td><select name="state" id="state" required>{$states}</td>
	<td>Postal Code:</td><td><input type="text" name="zip" value="{$PostalCode}" size="30" required></td>
</tr>
<tr>
	<td>Full Time:</td><td><select name="full_time"><option>{$full_time}</option><option>Yes</option><option>No</option></select></td>
	<td>Active:</td><td><select name="active"><option>{$EmployeeStatus}</option><option>Yes</option><option>No</option></select></td>
</tr>
<tr>
	<td>Misc. 301K, (etc) Monthly Amount:</td><td>$<input type="text" value="{$misc}"  name="misc" size="30"></td>
	<td>Date of Hire:</td><td><input type="text" name="date_of_hire" value="{$date_of_hire}" id="date1"></td>
</tr>
<tr>
	<td>Termination Date:</td><td><input type="text" name="TerminationDate" value="{$TerminationDate}" size="30"></td>
	<td>Date Of Birth:</td><td><input type="text" name="DOB" value="{$DOB}" size="30"></td>
</tr>
<tr>
	<td>Country Code:</td><td><input type="text" name="CountryCode" value="{$CountryCode}" size="30"></td>
	<td>Work Street:</td><td><input type="text" name="WorkStreet" value="{$WorkStreet}" size="30"></td>
</tr>
<tr>
	<td>Work PO Box:</td><td><input type="text" name="WorkPOBox" value="{$WorkPOBox}" size="30"></td>
	<td>Work Suite:</td><td><input type="text" name="WorkSuite" value="{$WorkSuite}" size="30"></td>
</tr>
<tr>
	<td>Work City:</td><td><input type="text" name="WorkCity" value="{$WorkCity}" size="30"></td>
	<td>Work State:</td><td><input type="text" name="WorkState" value="{$WorkState}" size="30"></td>
</tr>
<tr>
	<td>Work Zip:</td><td><input type="text" name="WorkZip" value="{$WorkZip}" size="30"></td>
	<td>Work Country Code:</td><td><input type="text" name="WorkCountryCode" value="{$WorkCountryCode}" size="30"></td>
</tr>
<tr>
	<td>Service Level Code:</td><td><input type="text" name="ServiceLevelCode" value="{$ServiceLevelCode}" size="30"></td>
	<td>Work Location Code:</td><td><input type="text" name="WorkLocationCode" value="{$WorkLocationCode}" size="30"></td>
</tr>
<tr>
	<td>Work Location Description:</td><td><input type="text" name="WorkLocationDescription" value="{$WorkLocationDescription}" size="30"></td>
	<td>Company Account Code:</td><td><input type="text" name="CompanyAccountCode" value="{$CompanyAccountCode}" size="30"></td>
</tr>
<tr>
	<td>Company Account Description:</td><td><input type="text" name="CompanyAccountDescription" value="{$CompanyAccountDescription}" size="30"></td>
	<td>Department:</td><td><input type="text" name="Department" value="{$Department}" size="30"></td>
</tr>
<tr>
	<td>Department Description:</td><td><input type="text" name="DepartmentDescription" value="{$DepartmentDescription}" size="30"></td>
	<td>Company Code:</td><td><input type="text" name="CompanyCode" value="{$CompanyCode}" size="30"></td>
</tr>
<tr>
	<td>On Health Plan:</td><td><input type="text" name="OnHealthPlan" value="{$OnHealthPlan}" size="30"></td>
	<td>Health Provider:</td><td><input type="text" name="HealthProvider" value="{$HealthProvider}" size="30"></td>
</tr>
<tr>
	<td>Health Plan Type:</td><td><input type="text" name="HealthPlanType" value="{$HealthPlanType}" size="30"></td>
	<td>Health Plan ID:</td><td><input type="text" name="HealthPlanID" value="{$HealthPlanID}" size="30"></td>
</tr>
<tr>
	<td>Last 4 SSN:</td><td><input type="text" name="Last4SSN" value="{$Last4SSN}" size="30"></td>
	<td>Benefit Status Code:</td><td><input type="text" name="BenefitStatusCode" value="{$BenefitStatusCode}" size="30"></td>
</tr>
<tr>
	<td>Relationship:</td><td><input type="text" name="Relationship" value="{$Relationship}" size="30"></td>
	<td>&nbsp;</td>
</tr>
<tr id="ok"><td colspan="4"><input type="submit" class="btn btn-primary" value="Update Employee">&nbsp;&nbsp;<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='employer.php'"></td></tr>
<tr id="error" style="display:none"><td colspan="4"><font color=red><b>You have errors above. Please correct then before going forward.</b></font></td></tr>
</table>
</form>


</div>


<script>
function check_ssn() {
	var ssn = document.getElementById('ssn').value;
	var ssn2 = document.getElementById('ssn2').value;

	document.getElementById('ok').style.display='table-row';
        document.getElementById('error').style.display='none';

	if (ssn != ssn2) {
		document.getElementById('ok').style.display='none';
                document.getElementById('error').style.display='table-row';
		alert('The SSN numbers does not match.');
}	}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
