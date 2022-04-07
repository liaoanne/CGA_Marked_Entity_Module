<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply_id = $link->real_escape_string(trim($_POST["delete"]));

    // Delete reply in forum_replies sql table
    $sql = "DELETE FROM forum_replies WHERE reply_id=$reply_id";

    // Check whether delete statement works
    try{
        $link->query($sql);
        $_SESSION['message'] = "Reply has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../discussion.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../discussion.php");
        exit;
    }
    // Log
    $f_sql = addslashes($sql);
    $link->query("INSERT INTO marked_entities_log (marked_entity_id, user_id, fname, lname, query, log_time) VALUES (" . $_SESSION['entity_id'] . ", " . $_SESSION['id'] . ", '" . $_SESSION['fname'] . "', '" . $_SESSION['lname'] . "', '$f_sql', SYSDATE())");
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>