<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if topic_id is empty
    if(empty($link->real_escape_string(trim($_POST["topic_id"])))){
        echo "Could not find topic_id.";
    } elseif($_SESSION['role_id'] == 4){
        // Initialize session information for topic
        $_SESSION['group_id'] = $link->real_escape_string(trim(substr($_POST["topic_id"], 0, strpos($_POST["topic_id"], ','))));
        $_SESSION['topic_id'] = $link->real_escape_string(trim(substr($_POST["topic_id"], strpos($_POST["topic_id"], ',')+1)));
		// Redirect user to topic discussion page
        header("location: ../discussion.php");
        exit;
    }
    else{
        $_SESSION['group_id'] = '0';
        $_SESSION['topic_id'] = $link->real_escape_string(trim($_POST["topic_id"]));
        // Redirect user to topic discussion page
        header("location: ../discussion.php");
        exit;
    }
}
else{
    header("location: ../discussion_board.php");
    exit;
}
?>
