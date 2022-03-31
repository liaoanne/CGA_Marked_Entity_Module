<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST["category_name"]);
    $desc = trim($_POST["category_desc"]);
    if(empty($_POST["view"]))
    {
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../add_category.php");
    }
    if($_POST["view"][0] == "all"){
        $view_string = "all";
    }
    else{
        $view_string = ",";
        foreach($_POST["view"] as $value){
            $view_string = $view_string . $value . ",";
        }
    }

    // Insert data into forum_categories
    $sql = "INSERT INTO forum_categories (section_id, name, description, viewable_to) VALUES (" . $_SESSION['section_id'] . "'$name', '$desc', '$view_string');";

    // Check whether both insert statements work
    try{
        if($link->query($sql)){
            echo "good";
            //header("location: ../discussion_board.php");
        }
        else{
                //$_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
                echo "fail";
                // Redirect user back to previous page
                //header("location: ../add_topic.php");
        }
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.";
        // Redirect user back to previous page
        header("location: ../add_category.php");
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
}

?>

