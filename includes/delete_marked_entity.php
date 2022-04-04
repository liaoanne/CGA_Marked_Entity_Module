<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cat_id = $link->real_escape_string(trim($_POST["delete_cat"]));

    // Delete reply into forum_categories sql table
    $sql = "DELETE FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id'];

    // Check whether delete statement work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Marked entity has been successfully deleted.";
        // Redirect user back to previous page
        header("location: ../marked_entities.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<br><br>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../entity_summary.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>