<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if section_id is empty
    if(empty(trim($_POST["entity_id"]))){
        echo "Could not find entity_id.";
    } else{
        // Initialize session information for course
        $_SESSION['entity_id'] = trim($_POST["entity_id"]);
		
        // Get marked entity name from entity id from POST
        $title = $link->query("SELECT name FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id']);
        if($title -> num_rows>0){
            while($t = mysqli_fetch_array($title,MYSQLI_NUM)){
                $_SESSION['entity_name'] = $t[0];
            }
        }

		// Redirect user to welcome page
        header("location: ../discussion_board.php");
    }
}
else{
    header("location: ../marked_entity.php");
}
?>
