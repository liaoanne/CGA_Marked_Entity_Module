<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = trim($_POST["title"]);
    $text = trim($_POST["text"]);

    // Insert data into notices table
    $sql = "INSERT INTO notices (section_id, title, text, date) VALUES (" . $_SESSION['section_id'] . ", '$title', '$text', SYSDATE())";

    // Check whether insert statement works
    try{
        $link->query($sql);
        $_SESSION['message'] = "Notice has been successfully posted.";
        // Redirect user back to previous page
        header("location: ../index.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../post_notices.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}