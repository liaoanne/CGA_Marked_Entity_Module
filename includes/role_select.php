<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if role_id is empty
    if(empty(trim($_POST["role_id"]))){
        echo "Could not find role_id.";
    } else{
        $_SESSION['role_id'] = trim($_POST["role_id"]);
		// Redirect user to welcome page
        header("location: ../course_list.php");
    }
}
?>