<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if meeting_id is empty
    if(empty($link->real_escape_string(trim($_POST["meeting_id"])))){
        echo "Could not find meeting_id.";
    }
    else{
        $_SESSION['meeting_id'] = $link->real_escape_string(trim($_POST["meeting_id"]));
        // Redirect user to meeting_info page
        header("location: ../meeting_info.php");
        exit;
    }
}
else{
    header("location: ../meetings.php");
    exit;
}
?>
