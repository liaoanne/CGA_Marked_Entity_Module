<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $meeting_id = $_SESSION['meeting_id'];
    $date = $link->real_escape_string(trim($_POST["meeting_date"]));
    $time = $link->real_escape_string(trim($_POST["meeting_time"]));
    $end_time = $link->real_escape_string(trim($_POST["meeting_end_time"]));
    $datetime = $date . " " . $time;
    echo $datetime;

    // Update meeting into meetings sql table
    $sql = "UPDATE meetings SET date='$datetime', end_time='$end_time' WHERE meeting_id=$meeting_id";

    // Check whether update statement worked
    try{
        $link->query($sql);
        $_SESSION['message'] = "Meeting time has been successfully changed.";
        // Redirect user back to previous page
        header("location: ../meeting_info.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../meeting_info.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>