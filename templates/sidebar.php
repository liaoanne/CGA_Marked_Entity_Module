<html>

<style type="text/css">
a:link {color: #333366}
a:visited {color: #333366}
a:hover {background: #CCFFCC}
a {text-decoration: none}
</style>

<head></head>

<body bgcolor=#33cccc>
<b><font size=4><i><?php echo $_SESSION['code'] . " / " . $_SESSION['term'] . " " . $_SESSION['year'] . "<br>Section " . $_SESSION['section_name'];?></i></font></b><hr>
<b><font size=4>

<ul>

<!--menu for Sidebar -->	
<?php
// Display sidebar for Admin
if($_SESSION['role_id'] == 1){
	echo "You are an admin.<p>";
	echo "<li><a href='manage_users.php'><b><font color=black>Manage Users</b></a></li>";
	echo "<li><a href='manage_courses.php'><b><font color=black>Manage Courses</b></a></li>";
	echo "<li><a href='post_notices.php'><b><font color=black>Post Notices</b></a></li>";
}

// Display sidebar for Instructor
elseif($_SESSION['role_id'] == 2){
	echo "You are an instructor.<p>";
	echo "<li><a href='manage_students.php'><b><font color=black>Manage Students</b></a></li>";
	echo "<li><a href='manage_ta.php'><b><font color=black>Manage Teaching Assistants</b></a></li>";
	echo "<li><a href='manage_groups.php'><b><font color=black>Manage Groups</b></a></li>";
	echo "<li><a href='marked_entities.php'><b><font color=black>Marked Entities</b></a></li>";
}

// Display sidebar for Teaching Assistant
elseif($_SESSION['role_id'] == 3){
	echo "You are a TA.<p>";
	echo "<li><a href='marked_entities.php'><b><font color=black>Marked Entities</b></a></li>";
}

// Display sidebar for Student
elseif($_SESSION['role_id'] == 4){
	echo "You are a student.<p>";
	echo "<li><a href='marked_entities.php'><b><font color=black>Marked Entities</b></a></li>";
}
?>

</ul>
</body>
</html>