<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply = $link->real_escape_string(trim($_POST["reply"]));

    // Insert reply into forum_replies sql table
    $sql = "INSERT INTO forum_replies (topic_id, text, date, reply_by) VALUES (" . $_SESSION['topic_id'] . ", '$reply', SYSDATE(), " . $_SESSION['id'] . ");";

    // Check whether insert statements work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Reply has been successfully posted.";
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

