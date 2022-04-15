<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $meeting_id = $link->real_escape_string(trim($_POST["delete"]));

    // Delete meeting in meetings sql table
    $sql = "DELETE FROM meetings WHERE meeting_id=$meeting_id";

    // Check whether delete statement works
    try{
        $link->query($sql);
        $_SESSION['message'] = "Meeting has been successfully cancelled.";
        // Redirect user back to previous page
        header("location: ../meetings.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
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