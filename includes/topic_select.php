<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if section_id is empty
    if(empty(trim($_POST["topic_id"]))){
        echo "Could not find topic_id.";
    } else{
        // Initialize session information for course
        $_SESSION['topic_id'] = trim($_POST["topic_id"]);
		// Redirect user to welcome page
        header("location: ../discussion.php");
    }
}
else{
    header("location: ../discussion_board.php");
}
?>
