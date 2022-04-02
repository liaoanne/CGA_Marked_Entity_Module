<?php
session_start();
include "./includes/config.php";

// Check if the user is not logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login_page.php");
    exit;
}
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
	<div class='course'>
	<style type="text/css">
	.course{margin-top: -28px;}
	</style>
	<table border=1>
	<?php
	// Show courses that they are a TA in
	if ($_SESSION['role_id'] == 3){
		$data = $link->query("SELECT * FROM courses c JOIN sections s ON c.course_id = s.course_id JOIN ta_sections ts ON s.section_id = ts.section_id WHERE ts.ta_id = " . $_SESSION['id'] . " ORDER BY 2,3,4,5,12");
	}
	// Show courses based on other users (admin, instructor, and student roles)
	else{
		$data = $link->query("SELECT * FROM courses c JOIN sections s ON c.course_id = s.course_id JOIN users_sections us ON s.section_id = us.section_id WHERE us.user_id = " . $_SESSION['id'] . " ORDER BY 2,3,4,5,12");
	}
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
			// Display the courses available for the logged in user
			$course_id = $row[0];
			$code = $row[1];
			$course_name = $row[2];
			$term = $row[3];
			$year = $row[4];
			$section_id = $row[8];
			$section_name = $row[11];

			echo "<tr><td><center><form name=course_select method=post action=includes/course_select.php>";
			echo "<input type=Submit value='" . $code . " " . $term . " " . $year . " Section " . $section_name . "'>";
			echo "<input name=course_id type=hidden value='" . $course_id . "'>";
			echo "<input name=code type=hidden value='" . $code . "'>";
			echo "<input name=course_name type=hidden value='" . $course_name . "'>";
			echo "<input name=term type=hidden value='" . $term . "'>";
			echo "<input name=year type=hidden value='" . $year . "'>";
			echo "<input name=section_id type=hidden value='" . $section_id . "'>";
			echo "<input name=section_name type=hidden value='" . $section_name . "'></form></td></tr>";
			echo "<br>";
		}
	}
	?>
	</table>
	</div>
	<br>
	<hr>
	<br>
	<a href = "includes/logout.php">Log out</a></font>
</body>

</html>
