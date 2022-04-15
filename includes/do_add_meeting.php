<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $link->real_escape_string(trim($_POST["title"]));
    $group_id = $link->real_escape_string(trim($_POST["group"]));
    $meeting_date = $link->real_escape_string(trim($_POST["meeting_date"]));
    $meeting_time = $link->real_escape_string(trim($_POST["meeting_time"]));
    $agenda = $link->real_escape_string(trim($_POST["agenda"]));
    $datetime = $meeting_date . " " . $meeting_time;

    // Insert data into notices table
    $sql = "INSERT INTO meetings (group_id, title, agenda, date) VALUES ($group_id, '$title', '$agenda', STR_TO_DATE('$datetime', '%Y-%m-%d %H:%i'))";

    // Check whether insert statement works
    try{
        $link->query($sql);
        $_SESSION['message'] = "Meeting has been successfully created.";
        // Redirect user back to previous page
        header("location: ../meetings.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../add_meeting.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}