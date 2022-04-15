<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $notice_id = $link->real_escape_string(trim($_POST["delete"]));

    // Delete reply in forum_replies sql table
    $sql = "DELETE FROM notices WHERE notice_id=$notice_id";

    // Check whether delete statement works
    try{
        $link->query($sql);
        $_SESSION['message'] = "Notice has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../index.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../edit_notice.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>