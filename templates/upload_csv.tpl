<div id="main_element">
<h2>Upload CSV</h2>
<hr>
{$msg}

<form name="myform" method="post" enctype="multipart/form-data">
<input type="hidden" name="section" value="process_csv">
<table class="table">
<tr><td>Select CSV File:</td><td><input type="file" name="csv"></td></tr>
<tr><td colspan="2"><br><i>Please select a CSV file that has been saved as a Microsoft CSV formatted document in Excel.</i></td></tr>
<tr><td colspan="2"><input type="submit" value="Upload File" class="btn btn-success"></td></tr>
</table>
</form>


</div>
