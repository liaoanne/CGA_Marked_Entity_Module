<?php
session_start();
include "./includes/config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
?>


<html>
<head>
<Title>CGA - The CrsMgr Group-work Assistant!!!</title>
</head>

<body bgcolor=#faf0e6>
<br><br><br>
<table border=0 width=100%>
<tr><td align=center><img src="pics/crsmgr.jpg" border=0></td></tr>
<tr><td><br></td></tr>
<tr bgcolor=#3399ff>
<td align=center><b><font size=5>
Welcome to <font color=Red>C</font><font color=yellow>r</font><font color=#00ff00>s</font><font color=#663300>M</font><font color=blue>g</font><font color=#ff3399>r</font> -- The CrsMgr Group-work Assistant!</font></b></td>
</tr>
</table>
<br><br>

<form name=login method=post action="includes/login.php">
<table border=0 align=center>

<tr>
    <td><b>User Name:</b></td><td><input type=text name=username maxlength=20  size=20></td>
</tr>

<tr>
    <td><b>Password:</b></td><td><input type=password name=password maxlength=20 size=21></td>
</tr>

<tr>
   <td colspan=2 align=center>
      <input type=Submit value="Login">
      <input type=Reset value ="Clear">
   </td>
</tr>

<tr>
    <td  colspan=2><br></td>
</tr>

<tr>
   <td align=center colspan=2><a href=reset_password.php>Forgot Password?</a></td>
</tr>
</table>
<br>
</form>

</body>
</html>

<!-- set focus on  username -->
<script language = "javascript">
  document.login.username.focus()
</script>

