<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if topic_id is empty
    if(empty($link->real_escape_string(trim($_POST["topic_id"])))){
        echo "Could not find topic_id.";
    } else{
        // Initialize session information for topic
        $_SESSION['group_id'] = trim(substr($_POST["topic_id"], 0, strpos($_POST["topic_id"], ',')));
        $_SESSION['topic_id'] = trim(substr($_POST["topic_id"], strpos($_POST["topic_id"], ',')+1));
		// Redirect user to topic discussion page
        header("location: ../discussion.php");
    }
}
else{
    header("location: ../discussion_board.php");
}
?>
