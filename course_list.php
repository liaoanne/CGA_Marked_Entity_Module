<?php
session_start();
include "./includes/config.php";
?>

<html>
<head>
<style>
input {border:none; background-color:rgba(0,0,0,0); color:blue; text-decoration:underline;}
</style>
<Title>CGA - The CrsMgr Group-work Assistant</title>
</head>

<body bgcolor=#faf0e6>
<br><br><br>
<center><img src="pics/crsmgr.jpg" border=0>
<br><br>
<h2><center>Your Courses in CGA -- The CrsMgr Group-work Assistant</h2>
<hr>
	<center><h3>Choose one of the courses to proceed</h3>
	<font size=4>
	<div>
	<?php
	$data = $link->query("SELECT * FROM courses c JOIN enrolled e ON c.course_id = e.course_id WHERE e.user_id = " . $_SESSION['id']);
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM))
		{
			$course_id = $row[0];
			$dept = $row[1];
			$code = $row[2];
			$term = $row[3];
			$year = $row[4];
			echo "<form name=course_select method=post action=includes/course_select.php>";
			echo "<input type=Submit value='" . $dept . " " . $code . " " . $term . " " . $year . "'>";
			echo "<input name=course_id type=hidden value='" . $course_id . "'>";
			echo "<input name=dept type=hidden value='" . $dept . "'>";
			echo "<input name=code type=hidden value='" . $code . "'>";
			echo "<input name=term type=hidden value='" . $term . "'>";
			echo "<input name=year type=hidden value='" . $year . "'></form>";
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
