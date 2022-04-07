<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply_id = $link->real_escape_string(trim($_POST["edit"]));
    $text = $link->real_escape_string(trim($_POST["text"]));

    // Update reply into forum_replies sql table
    $sql = "UPDATE forum_replies SET text='$text' WHERE reply_id=$reply_id";

    // Check whether update statement worked
    try{
        $link->query($sql);
        $_SESSION['message'] = "Reply has been successfully edited.";
        // Redirect user back to previous page
        header("location: ../discussion.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../edit_reply.php");
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