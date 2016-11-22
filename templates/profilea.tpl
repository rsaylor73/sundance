<div style="text-align:center;">
<h2>Profile</h2>
{$msg}
<form name="myform" action="admin.php" method="post">
<input type="hidden" name="section" value="save_profilea">
<table class="table" width=500 align="center">
	<tr>
		<td><b>Username:</b><br>{$uuname}</td>
	</tr>
	<tr>
		<td><b>Password:</b><br><input type="password" name="uupass" placeholder="************" required></td>
	</tr>

        <tr>
                <td><center>
                <input type="submit" name="login" value="Change Passowrd" class="btn btn-primary"></center></td>
        </tr>
</table>
</form>
</div>
