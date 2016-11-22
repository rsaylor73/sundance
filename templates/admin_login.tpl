<div id="main_element">
<div style="text-align:center;">
<h2>Admin Login</h2>
{$msg}
<form name="myform">
<table class="table" width=500 align="center">
        <tr>
                <td><b>Username:</b><br><input type="text" name="uuname" placeholder="User Name" size=20 required></td>
        </tr>
        <tr>
                <td><b>Password:</b><br><input type="password" name="uupass" placeholder="Password" size=20 required onkeypress="if(event.keyCode==13) { loginfrm(this.form); return false;}"></td>
        </tr>
        <tr>
                <td><center>
                <input type="button" value="Forgot Password" class="btn btn-warning" onclick="document.location.href='index.php?section=forgot_pwa'">&nbsp;&nbsp;
                <input type="button" name="login" value="Login" class="btn btn-primary" onclick="loginfrm(this.form)"></center></td>
        </tr>
</table>
</form>
</div>
</div>

<script>
function loginfrm(myform) {
        $.get('ajax/admin_login.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#main_element").html(php_msg);
        });
}
</script>
