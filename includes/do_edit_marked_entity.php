<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $link->real_escape_string(trim($_POST["marked_entity_name"]));
    $desc = $link->real_escape_string(trim($_POST["desc"]));
    $due_date = $link->real_escape_string(trim($_POST["due_date"]));
    $type = $link->real_escape_string(trim($_POST["type"]));
    $file_id = "";
    if(empty($_POST["view"]))
    {
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../edit_marked_entity.php");
        exit;
    }

    // Create view string based on the selected views
    if($_POST["view"][0] == ",all,"){
        if(count($_POST["view"]) == 1){
            $view_string = ",all,";
            $work_type = "individual work";
        }
        else{
            $_SESSION['error'] = "Please assign marked entity for Individual or Groups, not both.";
            // Redirect user back to previous page
            header("location: ../edit_marked_entity.php");
            exit;
        }
    }
    else{
        $view_string = ",";
        foreach($_POST["view"] as $value){
            $view_string = $view_string . $value . ",";
        }
        $work_type = "group work";
    }

    $link->autocommit(false);
    $link->query("SET FOREIGN_KEY_CHECKS=0");
    // Update reply into forum_replies sql table
    $sql = "UPDATE marked_entities SET name='$name', due_date=date('$due_date'), type='$type', work_type='$work_type', viewable_to='$view_string', description='$desc' 
        WHERE marked_entity_id=" . $_SESSION['entity_id'];

    // Add categories if additional groups have been added to the view
    // Get current viewable_to for this marked_entity
    $data  = $link->query("SELECT viewable_to FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id']);
    if ($data->num_rows>0){
        $entity_data = $data->fetch_assoc();
        $viewable_to = $entity_data['viewable_to'];
    }
    $success=true;
    foreach($_POST["view"] as $value){
        if(!$value=='all'){
            if(!str_contains($viewable_to, ",$value,")){
                $data = $link->query("SELECT name FROM rtc55314.groups WHERE group_id=$value");
                if($data->num_rows > 0){
                    $group_data = $data->fetch_assoc();
                    $group_name = $group_data['name'];
                }
                $name_groups = "Private Discussion - " . $group_name;
                $sql_groups = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
                    VALUES (" . $_SESSION['entity_id'] . ", '$name_groups', ',$value,');";
                try{
                    $link->query($sql_groups);
                }
                catch(Exception $e){
                    $link->query("SET FOREIGN_KEY_CHECKS=1");
                    $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
                    $link->rollback();
                    // Redirect user back to previous page
                    header("location: ../edit_marked_entity.php");
                    $success = false;
                    break;
                }
            }
        }
    }

    if($success){
        // Check whether update statement worked
        try{
            $link->query($sql);
            $link->commit();
            $link->query("SET FOREIGN_KEY_CHECKS=1");
            $_SESSION['message'] = "Marked entity has been successfully edited.";
            $_SESSION['entity_name'] = $name;
            // Redirect user back to previous page
            header("location: ../entity_summary.php");
            exit;
        }
        catch(Exception $e){
            $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
            $link->rollback();
            $link->query("SET FOREIGN_KEY_CHECKS=1");
            // Redirect user back to previous page
            header("location: ../edit_marked_entity.php");
            exit;
        }
        
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?>