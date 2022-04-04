<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $topic_id = $link->real_escape_string(trim($_POST["delete_topic"]));

    // Delete reply into forum_topics sql table
    $sql = "DELETE FROM forum_topics WHERE topic_id=$topic_id";

    // Check whether delete statement work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Topic has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../discussion_board.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../discussion_board.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>