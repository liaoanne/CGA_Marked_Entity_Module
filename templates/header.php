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
<?php
// Return the number of unread mail this user has
$data = $link->query("SELECT COUNT(*) c FROM mail_receivers WHERE receiver_id=" . $_SESSION['id'] . " AND is_read=0");
if($data -> num_rows>0){
    $mail_data = $data->fetch_assoc();
    $unread = $mail_data['c'];
}

// Display header for the inbox
if(strpos($_SERVER['REQUEST_URI'],'inbox.php') != false || strpos($_SERVER['REQUEST_URI'],'compose_mail.php') != false || strpos($_SERVER['REQUEST_URI'],'sent_box.php') != false || strpos($_SERVER['REQUEST_URI'],'mail.php') != false){ ?>
<i><b><a href = "role_list.php" target ="_top"><font color=black>Back to Courses</b></i></a> |</font>
<i><b><a href = "inbox.php" target ="_top"><font color=black>Inbox (<?php echo $unread; ?>)</b></i></a> |</font>
<i><b><a href = "includes/logout.php" target ="_top"><font color=black>Logout</b></i></a></font><br>
<?php }
else { 
// Display header for the course pages?>
<i><b><a href = "index.php" target ="_top"><font color=black>Home</b></i></a> |</font>
<i><b><a href = "inbox.php" target ="_top"><font color=black>Inbox (<?php echo $unread; ?>)</b></i></a> |</font>
<i><b><a href = "role_list.php" target ="_top"><font color=black>Switch Access Role</b></i></a> |</font>
<i><b><a href = "course_list.php" target ="_top"><font color=black>Switch Course</b></i></a> |</font>
<i><b><a href = "includes/logout.php" target ="_top"><font color=black>Logout</b></i></a></font><br>
<?php } ?>
</td>
</tr>
</table>

</body>
</html>