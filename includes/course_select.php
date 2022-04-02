<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if section_id is empty
    if(empty($link->real_escape_string(trim($_POST["section_id"])))){
        echo "Could not find section_id.";
    } else{
        // Initialize session information for course
        $_SESSION['course_id'] = $link->real_escape_string(trim($_POST["course_id"]));
		$_SESSION['code'] = $link->real_escape_string(trim($_POST["code"]));
        $_SESSION['course_name'] = $link->real_escape_string(trim($_POST["course_name"]));
		$_SESSION['term'] = $link->real_escape_string(trim($_POST["term"]));
		$_SESSION['year'] = $link->real_escape_string(trim($_POST["year"]));
        $_SESSION['section_id'] = $link->real_escape_string(trim($_POST["section_id"]));
        $_SESSION['section_name'] = $link->real_escape_string(trim($_POST["section_name"]));

		// Redirect user to welcome page
        header("location: ../index.php");
        exit;
    }
}
else{
    header("location: ../index.php");
    exit;
}
?>

