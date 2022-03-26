<?php
session_start();
include "./includes/config.php";
?>

<html>
<head>
<style>
input {border:none;background-color:rgba(0,0,0,0);color:blue;text-decoration:underline;}
</style>
<Title>CGA - The CrsMgr Group-work Assistant</title>
</head>

<body bgcolor=#faf0e6>
<br><br><br>
<center><img src="pics/crsmgr.jpg" border=0>
<br><br>
<h2><center>Your Access Roles in CGA -- The CrsMgr Group-work Assistant</h2>
<hr>
	<center><h3>Choose one of the roles to proceed</h3>
	<font size=4>
	<div>
	<?php
	$data = $link->query("SELECT r.role_id, role_name FROM roles r JOIN user_roles ur ON r.role_id = ur.role_id WHERE user_id = " . $_SESSION['id']);
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM))
		{
			$role_id = $row[0];
			$role_name = $row[1];
			echo "<form name=role_select method=post action=includes/role_select.php><input type=Submit value='" . ucwords($role_name) . "'>
			<input name=role_id type=hidden value='" . $role_id . "'></form>";
			echo "<br>";
		}
	}
	?>
	</div>
	<br>
	<hr>
	<br>
	<a href = "includes/logout.php">Log out</a></font>
</body>

</html>
