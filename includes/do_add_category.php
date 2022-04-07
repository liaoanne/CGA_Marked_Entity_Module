<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $link->real_escape_string(trim($_POST["category_name"]));
    
    if(empty($_POST["view"]))
    {
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../add_category.php");
        exit;
    }

    // Check the viewables that the user selected and place them in a string
    $view_string = ",";
    foreach($_POST["view"] as $value){
        $view_string = $view_string . $value . ",";
    }

    // Insert data into forum_categories
    $sql = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) VALUES (" . $_SESSION['entity_id'] . ", '$name', '$view_string')";

    // Check whether insert statement worked
    try{
        $link->query($sql);
        $_SESSION['message'] = "Category has been successfully added.";
        header("location: ../discussion_board.php");
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../add_category.php");
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

