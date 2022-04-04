<html>
<head>
</head>

<body bgcolor=#33cccc>

<style type="text/css">
a:link {color: #333366}
a:visited {color: #333366}
a:hover {background: #CCFFCC}
a {text-decoration: none}
</style>

<table border = "0" width = "100%">
<tr width = "100%">
<td width = "5%"align=left><img src="pics/crsmgr_s.jpg" border=0></td>
<td align=center><font size = 5><b>CrsMgr Group-work Assistant Menu</b></font></td>
</tr>
</table>

<table border = "0" width = "100%">
<tr width = "100%">
<td align = "left"><font color=blue>Welcome! <font color=black><?php echo $_SESSION['fname'] . " ". $_SESSION['lname'];?></font>
. Today is <span id="display_time"></span>.</font></td>

<script>
const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var now=new Date();
var current_date = monthNames[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear();
document.getElementById("display_time").innerHTML=current_date;
</script>

<td align = "right">
<i><b><a href = "index.php" target ="contents"><font color=black>Home</b></i></a> |</font>
<i><b><a href = "role_list.php" target ="_top"><font color=black>Switch Access Role</b></i></a> |</font>
<i><b><a href = "course_list.php" target ="_top"><font color=black>Switch Course</b></i></a> |</font>
<i><b><a href = "includes/logout.php" target ="_top"><font color=black>Logout</b></i></a></font><br>
</td>
</tr>
</table>

</body>
</html>