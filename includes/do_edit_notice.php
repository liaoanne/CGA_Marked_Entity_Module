<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $notice_id = $link->real_escape_string(trim($_POST["edit"]));
    $title = $link->real_escape_string(trim($_POST["title"]));
    $text = $link->real_escape_string(trim($_POST["text"]));

    // Update notice into notices sql table
    $sql = "UPDATE notices SET title='$title', text='$text' WHERE notice_id=$notice_id";

    // Check whether update statement worked
    try{
        $link->query($sql);
        $_SESSION['message'] = "Notice has been successfully edited.";
        // Redirect user back to previous page
        header("location: ../index.php");
        exit;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../edit_notice.php");
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>