<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = trim($_POST["title"]);
    $category_id = trim($_POST["category"]);
    $text = trim($_POST["text"]);

    // Insert data into forum_topics and forum_replies sql table
    $link->autocommit(false);
    $sql1 = "INSERT INTO forum_topics (title, category_id, date, topic_by) VALUES ('$title', $category_id, SYSDATE(), " . $_SESSION['id'] . ")";
    try{
        $link->query($sql1);
        $topic_id = $link->insert_id;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        $link->rollback();
        $link->autocommit(true);
        header("location: ../add_topic.php");
        exit;
    }

    $sql2 = "INSERT INTO forum_replies (topic_id, text, date, reply_by) VALUES ($topic_id, '$text', SYSDATE(), " . $_SESSION['id'] . ")";

    // Check whether both insert statements work
    try{
        $link->query($sql2);
        $link->commit();
        $link->autocommit(true);
        $_SESSION['message'] = "Topic has been successfully posted.";
        header("location: ../discussion_board.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        $link->rollback();
        $link->autocommit(true);
        // Redirect user back to previous page
        header("location: ../add_topic.php");
        exit;
    }
    // Log
    $f_sql = addslashes($sql1);
    $link->query("INSERT INTO marked_entities_log (marked_entity_id, user_id, fname, lname, query, log_time) VALUES (" . $_SESSION['entity_id'] . ", " . $_SESSION['id'] . ", '" . $_SESSION['fname'] . "', '" . $_SESSION['lname'] . "', '$f_sql', SYSDATE())");
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>

