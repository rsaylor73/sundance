<div id="main_element">
<h2>New Admin</h2>
<hr>
{$msg}

<form action="admin.php" method="post">
<input type="hidden" name="section" value="save_new_admin">
<table class="table">
<tr><td><b>First Name:</b></td><td><input type="text" name="fname" size="30" required></td><td><b>Last Name:</b></td><td><input type="text" name="lname" size="30" required></td></tr>
<tr><td><b>Username:</b></td><td><input type="text" name="uuname" size="30" required></td><td><b>Password:</b></td><td><input type="text" name="uupass" size="30" required></td></tr>
<tr><td><b>Email:</b></td><td><input type="text" name="email" size="30" required></td><td><b>Active:</b></td><td><select name="active"><option>Yes</option><option>No</option></select></td></tr>
<tr><td colspan="4"><input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;<input type="button" class="btn btn-warning" value="Cancel" onclick="document.location.href='admin.php'"></td></tr>
</table>
</form>
</div>
