<div id="main_element">
<div style="text-align:center;">
<h2>Forgot Password</h2>
{$msg}
<form name="myform">
<table class="table" width=500 align="center">
        <tr>
                <td><b>Email Address:</b><br><input type="text" name="email" placeholder="Email" size="30" required></td>
        </tr>
        <tr>
                <td><center>
                <input type="button" name="login" value="Reset Password" class="btn btn-primary" onclick="resetpw(this.form)"></center></td>
        </tr>
</table>
</form>
</div>
</div>

<script>
function resetpw(myform) {
        $.get('ajax/resetpw.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#main_element").html(php_msg);
        });
}
</script>
