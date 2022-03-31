<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST["marked_entity_name"]);
    $desc = trim($_POST["desc"]);
    $due_date = trim($_POST["due_date"]);
    $type = trim($_POST["type"]);
    $file = "";
    if(empty($_POST["view"]))
    {
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../add_category.php");
    }
    if($_POST["view"][0] == "all"){
        $view_string = "all";
        $work_type = "individual";
    }
    else{
        $view_string = ",";
        foreach($_POST["view"] as $value){
            $view_string = $view_string . $value . ",";
        }
        $work_type = "group";
    }


    // TODO: CHECK FOR FILE POST (NOT MANDATORY)
    
    // Get the marked_entity_id for the new marked entity
    $data = $link->query("SELECT COUNT(*) c FROM marked_entities");
    $temp = $data->fetch_assoc();
	$marked_entity_id = $temp['c']+1;

    $link->autocommit(false);
    // Insert data into marked entities table
    $sql1 = "INSERT INTO marked_entities (marked_entity_id, section_id, name, post_date, due_date, type, work_type, viewable_to, file, description) 
        VALUES ($marked_entity_id, " . $_SESSION['section_id'] . ", '$name', NOW(), date('$due_date'), '$type', '$work_type' , '$view_string', '$file', '$desc');";
    $sql2 = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
        VALUES ($marked_entity_id, 'Public', 'all');";
    try{
        $link->query($sql2);
        $success = true;
    }
    catch(Exception $e){
        $_SESSION['error'] = $e;
        // Redirect user back to previous page
        header("location: ../add_marked_entity.php");
    }
    if($view_string != 'all'){
        if($success){
            foreach($_POST["view"] as $value){
                $name_groups = 'Private Chat - Group ' . $value;
                $sql_groups = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
                    VALUES ($marked_entity_id, '$name_groups', ',$value,');";
                try{
                    $link->query($sql_groups);
                }
                catch(Exception $e){
                    $_SESSION['error'] = $e;
                    // Redirect user back to previous page
                    header("location: ../add_marked_entity.php");
                    $success = false;
                    break;
                }
            }
        }
    }

    if($success){
        // Check whether both insert statements work
        try{
            $link->query($sql1);
            $link->commit();
            header("location: ../marked_entities.php");
        }
        catch(Exception $e){
            $_SESSION['error'] = $e;
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
        }
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
}

?>

