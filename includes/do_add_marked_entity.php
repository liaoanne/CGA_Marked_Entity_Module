<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get POST variables
    $name = $link->real_escape_string(trim($_POST["marked_entity_name"]));
    $desc = $link->real_escape_string(trim($_POST["desc"]));
    $due_date = $link->real_escape_string(trim($_POST["due_date"]));
    $type = $link->real_escape_string(trim($_POST["type"]));
    
    if(empty($_POST["view"])){
        $_SESSION['error'] = "Please select viewables.";
        // Redirect user back to previous page
        header("location: ../add_marked_entity.php");
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
            header("location: ../add_marked_entity.php");
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
    
    // Start autocommit
    $link->autocommit(false);

    // Upload file module
    $target_dir = "../uploads/";
    $file_id = 0;
    if (!empty($_FILES) && $_FILES['fileToUpload']['size'] > 0) {
        $UUID = vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4) );
        $target_file = $target_dir . $UUID . basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }

        // Allow certain file formats
        if (!strcasecmp($fileType, "pdf") &&  !strcasecmp($fileType, "zip")) {
            $_SESSION['error'] = "Sorry, only pdf or zip files are allowed.";
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }

        // Check if $success is set to false by an error
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO attachments (file_name, file_location, uploaded_by) VALUES (" . "'" . mysqli_real_escape_string($link,basename( $_FILES['fileToUpload']['name'])) . "', '$target_file', " .$_SESSION['id'] . ")";

            if ($link->query($sql) === TRUE) {
                $file_id = $link->insert_id;
            } else {
                $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $sql . "<br>" . $link->error;
                $link->rollback();
                $link->autocommit(true);
                // Redirect user back to previous page
                header("location: ../add_marked_entity.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            $link->rollback();
            $link->autocommit(true);
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }
    }

    $success = true;
    $marked_entity_id=0;
    $link->query("SET FOREIGN_KEY_CHECKS=0");
    // Insert data into marked entities table and create default categories based on views
    $sql1 = "INSERT INTO marked_entities (section_id, name, post_date, due_date, type, work_type, viewable_to, file_id, description) 
        VALUES (" . $_SESSION['section_id'] . ", '$name', NOW(), date('$due_date'), '$type', '$work_type' , '$view_string', $file_id, '$desc')";

    try{
        $link->query($sql1);
        $marked_entity_id = $link->insert_id;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        header("location: ../add_marked_entity.php");
        $success = false;
    }
    
    // Create discussion boards for private group chats
    if($view_string != ',all,'){
        if($success){
            foreach($_POST["view"] as $value){
                $data = $link->query("SELECT name FROM rtc55314.groups WHERE group_id=$value");
                if($data->num_rows > 0){
                    $group_data = $data->fetch_assoc();
                    $group_name = $group_data['name'];
                }
                $name_groups = "Private Discussion - " . $group_name;
                $sql_groups = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
                    VALUES ($marked_entity_id, '$name_groups', ',$value,')";
                try{
                    $link->query($sql_groups);
                }
                catch(Exception $e){
                    $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
                    // Redirect user back to previous page
                    header("location: ../add_marked_entity.php");
                    $success = false;
                    break;
                }
            }
        }
    }

    // Create public discussion board
    $sql2 = "INSERT INTO forum_categories (marked_entity_id, name, viewable_to) 
    VALUES ($marked_entity_id, 'Public Discussion', ',all,')";

    // Check if all sql data were successfully inserted
    if($success){
        // Check whether both insert statements work
        try{
            $link->query($sql2);
            $link->commit();
            $link->autocommit(true);
            $link->query("SET FOREIGN_KEY_CHECKS=1");
            $_SESSION['message'] = "Marked entity has been successfully added.";
            // Redirect user back to previous page
            header("location: ../marked_entities.php");
        }
        catch(Exception $e){
            $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
            $link->rollback();
            $link->autocommit(true);
            $link->query("SET FOREIGN_KEY_CHECKS=1");
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }
        // Log
        $f_sql = addslashes($sql1);
        $link->query("INSERT INTO marked_entities_log (marked_entity_id, user_id, fname, lname, query, log_time) VALUES ($marked_entity_id, " . $_SESSION['id'] . ", '" . $_SESSION['fname'] . "', '" . $_SESSION['lname'] . "', '$f_sql', SYSDATE())");
    }
    else{
        $link->rollback();
        $link->autocommit(true);
        $link->query("SET FOREIGN_KEY_CHECKS=1");
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}
?>
