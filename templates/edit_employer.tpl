<div id="main_element">
<h2>Edit Employers</h2>
<hr>
{$msg}

<form action="admin.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="section" value="update_new_user">
<input type="hidden" name="id" value="{$id}">
<table class="table">

<tr><td><b>Company:</b></td><td><input type="text" name="company" value="{$company}" size="30" required></td><td><b>Company Type:</b></td><td><select name="company_type"><option selected>{$company_type}</option><option>LLC</option><option>S-Corp</option><option>C-Corp</option>
        <option>Sole Proprietorship</option></select></td></tr>


<tr><td><b>Email:</b></td><td><input type="text" name="email" value="{$email}" size="30" required></td>
<td><b>Website:</b></td><td><input type="text" name="website" value="{$website}" size="30" required></td></tr>
<tr><td><b>Username:</b></td><td>{$uuname}</td><td><b>Password:</b></td><td><input type="text" name="uupass" placeholder="************" size="30"></td></tr>

<tr><td><b>Address:</b></td><td><input type="text" name="address" value="{$address}" size="30" required></td><td><b>City:</b></td><td><input type="text" name="city" value="{$city}" size="30" required></td></tr>
<tr><td><b>State:</b></td><td><select name="state"><option selected>{$state}</option>{$states}</select></td><td><b>Zip:</b></td><td><input type="text" name="zip" value="{$zip}" size="30" required></td></tr>

<tr><td><b>Mailing Address:</b></td><td><input type="text" name="m_address" size="30" value="{$m_address}" required></td><td><b>Mailing City:</b></td><td><input type="text" name="m_city" size="30" value="{$m_city}" required></td></tr>
<tr><td><b>Mailing State:</b></td><td><select name="m_state"><option selected>{$m_state}</option>{$states}</select></td><td><b>Mailing Zip:</b></td><td><input type="text" name="m_zip" value="{$m_zip}" size="30" required></td></tr>

<tr><td><b>Main Phone:</b></td><td><input type="text" name="main_phone" value="{$main_phone}" size="30" required></td><td><b>Fax:</b></td><td><input type="text" name="fax" value="{$fax}" size="30"></td></tr>

<tr><td><b>Contact Name:</b></td><td><input type="text" name="contact_name" value="{$contact_name}" size="30" required></td><td><b>Title:</b></td><td><input type="text" name="title" value="{$title}" size="30" required></td></tr>
<tr><td><b>Contact Phone:</b></td><td><input type="text" name="contact_phone" value="{$contact_phone}" size="30" required></td></tr>

<tr><td><b>Second Contact Name:</b></td><td><input type="text" name="contact_name2" value="{$contact_name2}" size="30" required></td><td><b>Title:</b></td><td><input type="text" name="title2" value="{$title2}" size="30" required></td></tr>
<tr><td><b>Contact Phone:</b></td><td><input type="text" name="contact_phone2" value="{$contact_phone2}" size="30" required></td></tr>



<tr><td><b>Number of Employees:</b></td><td><input type="text" name="num_employees" value="{$num_employees}" size="30" required></td><td><b>Time Zone:</b></td><td><select name="time_zone">
	<option selected>{$time_zone}</option>
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
	<option selected>{$fiscal_year_month}</option>
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
	</select></td><td><b>S.I.C:</b></td><td><input type="text" name="sic" size="30" value="{$sic}" required></td></tr>
<tr><td><b>E.I.N:</b></td><td><input type="text" name="ein" value="{$ein}" size="30" required></td><td><b>D.U.N.S:</b></td><td><input type="text" name="duns" value="{$duns}" size="30" required></td></tr>
<tr><td><b>Upload Logo: (150x50 px)</b></td><td><input type="file" name="logo"><img src="{$logo}"></td><td><b>Broker:</b></td><td><input type="text" name="broker" value="{$broker}" size="30"></td></tr>

<tr><td><b>Active:</b></td><td><select name="active"><option selected>{$active}</option><option>Yes</option><option>No</option></select></td></tr>

<tr><td colspan="4"><input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='admin.php'"></td></tr>
</table>
</form>



</div>
