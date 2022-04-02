<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $link->real_escape_string(trim($_POST["marked_entity_name"]));
    $desc = $link->real_escape_string(trim($_POST["desc"]));
    $due_date = $link->real_escape_string(trim($_POST["due_date"]));
    $type = $link->real_escape_string(trim($_POST["type"]));
    $file = "";
    if(empty($_POST["view"]))
    {
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../add_marked_entity.php");
        exit;
    }
    // Create view string based on the selected views
    if($_POST["view"][0] == ",all,"){
        if(count($_POST["view"]) == 1){
            $view_string = ",all,";
            $work_type = "individual";
        }
        else{
            $_SESSION['error'] = "Please assign marked entity for Individual or Groups, not both.";
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }
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
    // Insert data into marked entities table and create default categories based on views
    $sql1 = "INSERT INTO marked_entities (marked_entity_id, section_id, name, post_date, due_date, type, work_type, viewable_to, file, description) 
        VALUES ($marked_entity_id, " . $_SESSION['section_id'] . ", '$name', NOW(), date('$due_date'), '$type', '$work_type' , '$view_string', '$file', '$desc');";
    $sql2 = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
        VALUES ($marked_entity_id, 'Public', ',all,');";
    try{
        $link->query($sql2);
        $success = true;
    }
    catch(Exception $e){
        $_SESSION['error'] = $e;
        // Redirect user back to previous page
        header("location: ../add_marked_entity.php");
    }
    // Create discussion boards for private group chats
    if($view_string != ',all,'){
        if($success){
            foreach($_POST["view"] as $value){
                $data = $link->query("SELECT name FROM rtc55314.groups WHERE group_id=$value");
                if($data -> num_rows>0){
                    $group_data = $data->fetch_assoc();
                    $group_name = $group_data['name'];
                }
                $name_groups = "Private Chat - " . $group_name;
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

    // Check if all sql data were successfully inserted
    if($success){
        // Check whether both insert statements work
        try{
            $link->query($sql1);
            $link->commit();
            $_SESSION['message'] = "Marked entity has been successfully added.";
            // Redirect user back to previous page
            header("location: ../marked_entities.php");
            exit;
        }
        catch(Exception $e){
            $_SESSION['error'] = $e;
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
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

