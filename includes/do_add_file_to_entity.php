<?php
session_start();
include "./config.php";
$target_dir = "../uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Upload file to entity
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
            header("location: ../add_file_to_entity.php");
            exit;
        }

        // Allow certain file formats
        if (!strcasecmp($fileType, "pdf") &&  !strcasecmp($fileType, "zip")) {
            $_SESSION['error'] = "Sorry, only pdf or zip files are allowed.";
            // Redirect user back to previous page
            header("location: ../add_marked_entity.php");
            exit;
        }

        // Start autocommit
        $link->autocommit(false);

        // Insert file into table
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO marked_entity_files (file_name, file_location, marked_entity_id, uploaded_by) VALUES (" . "'" . mysqli_real_escape_string($link,basename( $_FILES['fileToUpload']['name'])) . "', '$target_file', " . $_SESSION['entity_id'] ."," .$_SESSION['id'] . ")";

            if ($link->query($sql) === TRUE) {
                $file_id = $link->insert_id;
                $link->commit();
                $link->autocommit(true);
                $_SESSION['message'] = "File has been successfully uploaded.";
                // Redirect user back to previous page
                header("location: ../discussion_board.php");
                
                // Log
                $f_sql = addslashes($sql);
                $link->query("INSERT INTO marked_entities_log (marked_entity_id, user_id, fname, lname, query, log_time) VALUES (" . $_SESSION['entity_id'] . ", " . $_SESSION['id'] . ", '" . $_SESSION['fname'] . "', '" . $_SESSION['lname'] . "', '$f_sql', SYSDATE())");
                exit();
            } else {
                $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $sql . "<br>" . $link->error;
                $link->rollback();
                $link->autocommit(true);
                // Redirect user back to previous page
                header("location: ../add_file_to_entity.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            $link->rollback();
            $link->autocommit(true);
            // Redirect user back to previous page
            header("location: ../add_file_to_entity.php");
            exit;
        }
    }

} else {
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?> 