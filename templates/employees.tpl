<div id="main_element">
<h2>Employees</h2>
<hr>
{$msg}

<button class="btn btn-success" onclick="document.location.href='employer.php?section=new_employee'; return false;">
               <span class="glyphicon glyphicon-plus"></span> New Employee</button>
&nbsp;&nbsp;
<button class="btn btn-info" onclick="document.location.href='employer.php?section=upload_csv'; return false;">
               <span class="glyphicon glyphicon-paperclip"></span> Upload CSV</button>

<br><br>
<table class="table">
<tr>
	<th><b>Employee</b></th>
	<th><b>SSN</b></th>
	<th><b>Location</b></th>
	<th>&nbsp;</th>
</tr>
{$html}
</table>




</div>
