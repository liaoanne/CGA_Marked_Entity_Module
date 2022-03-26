<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if course_id is empty
    if(empty(trim($_POST["course_id"]))){
        echo "Could not find course_id.";
    } else{
        $_SESSION['course_id'] = trim($_POST["course_id"]);
		$_SESSION['dept'] = trim($_POST["dept"]);
		$_SESSION['code'] = trim($_POST["code"]);
		$_SESSION['term'] = trim($_POST["term"]);
		$_SESSION['year'] = trim($_POST["year"]);
		
		// Redirect user to welcome page
        header("location: ../welcome.php");
    }
}
?>

