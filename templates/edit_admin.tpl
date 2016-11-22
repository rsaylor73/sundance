<div id="main_element">
<h2>Edit Admin</h2>
<hr>
{$msg}

<form action="admin.php" method="post">
<input type="hidden" name="section" value="update_admin">
<input type="hidden" name="id" value="{$id}">
<table class="table">
<tr><td><b>First Name:</b></td><td><input type="text" name="fname" value="{$fname}" size="30" required></td><td><b>Last Name:</b></td><td><input type="text" name="lname" size="30" value="{$lname}" required></td></tr>
<tr><td><b>Username:</b></td><td>{$uuname}</td><td><b>Password:</b></td><td><input type="text" name="uupass" size="30" placeholder="************"></td></tr>
<tr><td><b>Email:</b></td><td><input type="text" name="email" value="{$email}" size="30" required></td><td><b>Active:</b></td><td><select name="active"><option selected>{$active}</option><option>Yes</option><option>No</option></select></td></tr>
<tr><td colspan="4"><input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;<input type="button" class="btn btn-warning" value="Cancel" onclick="document.location.href='admin.php'"></td></tr>
</table>
</form>
</div>
