<div id="main_element">
<h2>Admin Users</h2>
<hr>
{$msg}

<button class="btn btn-success" onclick="document.location.href='admin.php?section=new_admin'; return false;">
               <span class="glyphicon glyphicon-plus"></span> New Admin</button>
&nbsp;&nbsp;

<br><br>
<table class="table">
<tr>
        <th><b>Name</b></th>
	<th><b>Active</b></th>
        <th>&nbsp;</th>
</tr>
{$html}
</table>




</div>

