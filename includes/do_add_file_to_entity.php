<?php
session_start();
include "./config.php";
$target_dir = "../uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_FILES) && $_FILES['fileToUpload']['size'] > 0) {
        $UUID = vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4) );
        $target_file = $target_dir . $UUID . basename($_FILES["fileToUpload"]["name"]);
        $success = true;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            //echo "Sorry, your file is too large.";
            $success = false;
      }

        // Allow certain file formats
        if (
            !strcasecmp($fileType, "pdf") &&  !strcasecmp($fileType, "zip")
        ) {
           //echo "Sorry, only pdf or zip files are allowed.";
           $success = false;
        }

        // Check if $success is set to false by an error
        if ($success === true) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              $link->autocommit(false);
              $sql = "INSERT INTO marked_entity_files (file_name, file_location, marked_entity_id, uploaded_by) VALUES (" . "'" . mysqli_real_escape_string($link,basename( $_FILES['fileToUpload']['name'])) . "', '$target_file', " . $_SESSION['entity_id'] ."," .$_SESSION['id'] . ");";
              //echo "The file " . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

              if ($link->query($sql) === TRUE) {
                  //echo "New record created successfully";
                    $file_id = $link->insert_id;

                    $_SESSION['message'] = "File has been successfully uploaded.";
                    $link->commit();
                    // Redirect user back to previous page
                    header("location: ../discussion_board.php");
                    exit;
                } else {
                    $success =  false;
                 // echo "Error: " . $sql . "<br>" . $link->error;
                }
            } else {
                $success = false;
             // echo "Sorry, there was an error uploading your file.";
            }



        }
    }

} else {
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}

?> 