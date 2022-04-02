<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = trim($_POST["title"]);
    $category_id = trim($_POST["category"]);
    $text = trim($_POST["text"]);

    // Get the topic_id for the new post
    $data = $link->query("SELECT COUNT(*) c FROM forum_topics");
    $temp = $data->fetch_assoc();
	$topic_id = $temp['c']+1;

    // Insert data into forum_topics and forum_replies sql table
    $link->autocommit(false);
    $sql1 = "INSERT INTO forum_topics (topic_id, title, category_id, date, topic_by) VALUES ($topic_id, '$title', $category_id, SYSDATE(), " . $_SESSION['id'] . ");";
    $sql2 = "INSERT INTO forum_replies (topic_id, text, date, reply_by) VALUES ($topic_id, '$text', SYSDATE(), " . $_SESSION['id'] . ");";

    // Check whether both insert statements work
    try{
        if($link->query($sql1) && $link->query($sql2)){
            $link->commit();
            $_SESSION['message'] = "Topic has been successfully posted.";
            header("location: ../discussion_board.php");
        }
        else{
             $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
             // Redirect user back to previous page
             header("location: ../add_topic.php");
        }
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
        // Redirect user back to previous page
        header("location: ../add_topic.php");
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
}

?>

