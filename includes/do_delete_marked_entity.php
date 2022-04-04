<?php
session_start();
include "./config.php";

// Check if user accessed this page by URL

// Delete reply into forum_replies sql table
$sql = "DELETE FROM marked_entitiess WHERE marked_entity_id=" . $_SESSION['entity_id'];

// Check whether delete statements work
try{
    $link->query($sql);
    $_SESSION['message'] = "Entity has been successfully deleted.";
    // Redirect user back to previous page
    header("location: ../marked_entities.php");
    exit;
}
catch(Exception $e){
    $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
    // Redirect user back to previous page
    header("location: ../entity_summary.php");
    exit;
}

?>