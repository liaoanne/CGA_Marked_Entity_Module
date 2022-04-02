<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply_id = $link->real_escape_string(trim($_POST["delete"]));

    // Insert reply into forum_replies sql table
    $sql = "DELETE FROM forum_replies WHERE reply_id=$reply_id";

    // Check whether insert statements work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Reply has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../discussion.php");
        exit();
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
        // Redirect user back to previous page
        header("location: ../discussion.php");
        exit();
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit();
}

?>