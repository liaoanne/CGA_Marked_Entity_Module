<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Delete marked entity from marked_entities sql table
    $sql = "DELETE FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id'];

    // Check whether delete statement work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Marked entity has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../marked_entities.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../entity_summary.php");
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