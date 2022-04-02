<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if role_id is empty
    if(empty($link->real_escape_string(trim($_POST["role_id"])))){
        echo "Could not find role_id.";
    } else{
        $_SESSION['role_id'] = $link->real_escape_string(trim($_POST["role_id"]));
		// Redirect user to course list
        header("location: ../course_list.php");
    }
}
else{
    header("location: ../index.php");
}
?>