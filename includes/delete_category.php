<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cat_id = $link->real_escape_string(trim($_POST["delete_cat"]));

    // Delete reply into forum_categories sql table
    $sql = "DELETE FROM forum_categories WHERE category_id=$cat_id";

    // Check whether delete statement work
    try{
        $link->query($sql);
        $_SESSION['message'] = "Category has been successfully deleted.";
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