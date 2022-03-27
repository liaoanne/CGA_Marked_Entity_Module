<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if section_id is empty
    if(empty(trim($_POST["section_id"]))){
        echo "Could not find section_id.";
    } else{
        // Initialize session information for course
        $_SESSION['course_id'] = trim($_POST["course_id"]);
		$_SESSION['code'] = trim($_POST["code"]);
        $_SESSION['course_name'] = trim($_POST["course_name"]);
		$_SESSION['term'] = trim($_POST["term"]);
		$_SESSION['year'] = trim($_POST["year"]);
        $_SESSION['section_id'] = trim($_POST["section_id"]);
        $_SESSION['section_name'] = trim($_POST["section_name"]);

		// Redirect user to welcome page
        header("location: ../welcome.php");
    }
}
?>

