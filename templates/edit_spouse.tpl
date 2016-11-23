<div id="main_element">
<h2>Edit Spouse/Domestic Partner</h2>
<hr>
{$msg}

<form action="employer.php" name="myform" method="post">
<input type="hidden" name="section" value="update_spouce">
<input type="hidden" name="employeeID" value="{$employeeID}">
<input type="hidden" name="type" value="{$type}">
<table class="table">
<tr>
	<td>First Name:</td><td><input type="text" name="FirstName" size="30" required value="{$FirstName}"></td>
	<td>Middle Name:</td><td><input type="text" name="middle" size="30" value="{$MiddleName}"></td>
</tr>
<tr>
	<td>Last Name:</td><td><input type="text" name="last" size="30" value="{$LastName}"></td>
	<td>S.S.N:</td><td><input type="password" name="SSN" placeholder="{$last_4}"</td>
</tr>
<tr>
	<td>Gender:</td><td><select name="gender" required><option selected>{$Gender}</option><option>Male</option><option>Female</option></select></td>
        <td>Date Of Birth:</td><td><input type="text" name="DOB" value="{$DOB}" size="30"></td>
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


<tr id="ok"><td colspan="4"><input type="submit" class="btn btn-primary" value="Update Spouse/Domestic Partner">&nbsp;&nbsp;<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='employer.php'"></td></tr>
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
