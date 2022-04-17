<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if mail_id is empty
    if(empty($link->real_escape_string(trim($_POST["mail_id"])))){
        echo "Could not find mail_id.";
    } else{
        // Initialize session information for mail
        $_SESSION['mail_id'] = $link->real_escape_string(trim($_POST["mail_id"]));
		// Redirect user to particular mail
        header("location: ../mail.php");
    }
}
else{
    header("location: ../inbox.php");
}
?>
