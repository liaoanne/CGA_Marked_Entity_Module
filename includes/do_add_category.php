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
    $sql = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) VALUES (" . $_SESSION['entity_id'] . ", '$name', '$view_string');";

    // Check whether insert statement worked
    try{
        $link->query($sql);
        $_SESSION['message'] = "Category has been successfully added.";
        header("location: ../discussion_board.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
        // Redirect user back to previous page
        header("location: ../add_category.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit();
}

?>

