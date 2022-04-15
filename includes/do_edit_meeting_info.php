<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if new_agenda is empty
    if(!empty($link->real_escape_string(trim($_POST["new_agenda"])))){
        $new_agenda = $link->real_escape_string(trim($_POST["new_agenda"]));
        // Update agenda into meetings sql table
        $sql = "UPDATE meetings SET agenda='$new_agenda' WHERE meeting_id=" . $_SESSION['meeting_id'];
        $link->query($sql);
    }
    elseif(!empty($link->real_escape_string(trim($_POST["new_minutes"])))){
        $new_minutes = $link->real_escape_string(trim($_POST["new_minutes"]));
        // Update minutes into meetings sql table
        $sql = "UPDATE meetings SET minutes='$new_minutes' WHERE meeting_id=" . $_SESSION['meeting_id'];
        $link->query($sql);
    }
}
else{
    header("location: ../meetings.php");
    exit;
}
?>
