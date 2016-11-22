<div id="main_element">
<div style="text-align:center;">
<h2>Employee Login</h2>
{$msg}
<form name="myform">
<table class="table" width=500 align="center">
        <tr>
                <td><b>Email:</b><br><input type="text" name="email" placeholder="Email Address" size=20 required></td>
        </tr>
        <tr>
                <td><b>Password:</b><br><input type="password" name="uupass" placeholder="Password" size=20 required onkeypress="if(event.keyCode==13) { loginfrm(this.form); return false;}"></td>
        </tr>
        <tr>
                <td><center>
		<input type="button" value="Register" class="btn btn-primary" onclick="document.location.href='index.php?section=register'">&nbsp;&nbsp;
                <input type="button" name="login" value="Login" class="btn btn-success" onclick="loginfrm(this.form)"></center></td>
        </tr>
</table>
</form>
</div>
</div>

<script>
function loginfrm(myform) {
        $.get('ajax/employee_login.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#main_element").html(php_msg);
        });
}
</script>
