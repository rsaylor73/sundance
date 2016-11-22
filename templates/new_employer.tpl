<div id="main_element">
<h2>New Employers</h2>
<hr>
{$msg}

<form action="admin.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="section" value="save_new_user">
<table class="table">

<tr><td><b>Company:</b></td><td><input type="text" name="company" size="30" required></td><td><b>Company Type:</b></td><td><select name="company_type"><option>LLC</option><option>S-Corp</option><option>C-Corp</option>
        <option>Sole Proprietorship</option></select></td></tr>


<tr><td><b>Email:</b></td><td><input type="text" name="email" size="30" required></td>
<td><b>Website:</b></td><td><input type="text" name="website" size="30" required></td></tr>
<tr><td><b>Username:</b></td><td><input type="text" name="uuname" size="30" required></td><td><b>Password:</b></td><td><input type="text" name="uupass" size="30" required></td></tr>

<tr><td><b>Address:</b></td><td><input type="text" name="address" size="30" required></td><td><b>City:</b></td><td><input type="text" name="city" size="30" required></td></tr>
<tr><td><b>State:</b></td><td><select name="state">{$states}</select></td><td><b>Zip:</b></td><td><input type="text" name="zip" size="30" required></td></tr>

<tr><td><b>Mailing Address:</b></td><td><input type="text" name="m_address" size="30" required></td><td><b>Mailing City:</b></td><td><input type="text" name="m_city" size="30" required></td></tr>
<tr><td><b>Mailing State:</b></td><td><select name="m_state">{$states}</select></td><td><b>Mailing Zip:</b></td><td><input type="text" name="m_zip" size="30" required></td></tr>

<tr><td><b>Main Phone:</b></td><td><input type="text" name="main_phone" size="30" required></td><td><b>Fax:</b></td><td><input type="text" name="fax" size="30"></td></tr>

<tr><td><b>Contact Name:</b></td><td><input type="text" name="contact_name" size="30" required></td><td><b>Title:</b></td><td><input type="text" name="title" size="30" required></td></tr>
<tr><td><b>Contact Phone:</b></td><td><input type="text" name="contact_phone" size="30" required></td></tr>

<tr><td><b>Second Contact Name:</b></td><td><input type="text" name="contact_name2" size="30" required></td><td><b>Title:</b></td><td><input type="text" name="title2" size="30" required></td></tr>
<tr><td><b>Contact Phone:</b></td><td><input type="text" name="contact_phone2" size="30" required></td></tr>



<tr><td><b>Number of Employees:</b></td><td><input type="text" name="num_employees" size="30" required></td><td><b>Time Zone:</b></td><td><select name="time_zone">
	<option>Samoa Standard Time</option>
	<option>Hawaii-Aleutian Standard Time</option>
	<option>Alaska Standard Time</option>
	<option>Pacific Standard Time</option>
	<option>Mountain Standard Time</option>
	<option>Central Standard Time</option>
	<option>Eastern Standard Time</option>
	<option>Atlantic Standard Time</option>
	<option>Chamorro Standard Time</option>
	</select></td></tr>

<tr><td><b>Fiscal Year Begins:</b></td><td><select name="fiscal_year_month">
	<option>Jan</option>
	<option>Feb</option>
	<option>Mar</option>
	<option>Arp</option>
	<option>May</option>
	<option>Jun</option>
	<option>Jul</option>
	<option>Aug</option>
	<option>Sep</option>
	<option>Oct</option>
	<option>Nov</option>
	<option>Dec</option>
	</select></td><td><b>S.I.C:</b></td><td><input type="text" name="sic" size="30" required></td></tr>
<tr><td><b>E.I.N:</b></td><td><input type="text" name="ein" size="30" required></td><td><b>D.U.N.S:</b></td><td><input type="text" name="duns" size="30" required></td></tr>
<tr><td><b>Upload Logo: (150x50 px)</b></td><td><input type="file" name="logo" required></td><td><b>Broker:</b></td><td><input type="text" name="broker" size="30"></td></tr>

<tr><td colspan="4"><input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='admin.php'"></td></tr>
</table>
</form>



</div>
