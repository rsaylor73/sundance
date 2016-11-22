<div id="main_element">
<h2>Register</h2>
<hr>
{$msg}

<form action="index.php" method="post">
<input type="hidden" name="section" value="search">
<table class="table">
<tr><td><b>First Name:</b></td><td><input type="text" name="employee" size="30" required></td></tr>
<tr><td><b>Last Name:</b></td><td><input type="text" name="last" size="30" required></td></tr>
<tr><td><b>Company Name:</b></td><td><input type="text" name="company" size="30" required></td></tr>
<tr><td><b>Last 4 of your SSN:</b></td><td><input type="password" name="ssn" size="4" placeholder="****" required></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td><b>Password:</b></td><td><input type="text" name="uupass" size="30" placeholder="Please create your password" required></td></tr>
<tr><td colspan="2"><input type="submit" value="Register" class="btn btn-success"></td></tr>
</table>
</form>
