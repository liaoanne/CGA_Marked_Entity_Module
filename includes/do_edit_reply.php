<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply_id = $link->real_escape_string(trim($_POST["edit"]));
    $text = $link->real_escape_string(trim($_POST["text"]));

    // Insert reply into forum_replies sql table
    $sql = "UPDATE forum_replies SET text='$text' WHERE reply_id=$reply_id";

    // Check whether insert statements work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Reply has been successfully edited.";
        // Redirect user back to previous page
        header("location: ../discussion.php");
        exit();
    }
    catch(Exception $e){
        $_SESSION['error'] = $e . "Sorry, we have run into a database error. Please try again." . $reply_id;
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