<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cat_id = $link->real_escape_string(trim($_POST["delete_cat"]));

    // Delete category from forum_categories sql table
    $sql = "DELETE FROM forum_categories WHERE category_id=$cat_id";

    // Check whether delete statement work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Category has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../discussion_board.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../discussion_board.php");
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