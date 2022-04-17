<?php
session_start();
include "./config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $to = $link->real_escape_string(trim($_POST["to"]));
    $subject = $link->real_escape_string(trim($_POST["subject"]));
    $content= $link->real_escape_string(trim($_POST["content"]));

    // Start autocommit
    $link->autocommit(false);
    $success = true;
    $mail_id=0;
    $link->query("SET FOREIGN_KEY_CHECKS=0");
    
    // Insert data into mail table
    $sql = "INSERT INTO mail (sender_id, subject, text, send_date) VALUES (" . $_SESSION['id'] . ", '$subject', '$content', SYSDATE())";
    try{
        $link->query($sql);
        $mail_id = $link->insert_id;
    }
    catch(Exception $e){
        $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
        // Redirect user back to previous page
        if(strpos($_SERVER['HTTP_REFERER'],'reply_mail.php') != false){
            header("location: ../mail.php");
        }
        else{
            header("location: ../compose_mail.php");
        }
        $success = false;
    }

    $to_array = explode(',', $to);
    foreach($to_array as $value){
        $value = trim($value);
        $data = $link->query("SELECT user_id FROM users WHERE username='$value'");
        if($data -> num_rows>0){
            $receiver_data = $data->fetch_assoc();
            $receiver_id = $receiver_data['user_id'];
        }
        else{
            $_SESSION['error'] = $value . " is not a user of CGA.";
            // Redirect user back to previous page
            if(strpos($_SERVER['HTTP_REFERER'],'reply_mail.php') != false){
                header("location: ../mail.php");
            }
            else{
                header("location: ../compose_mail.php");
            }
            $link->rollback();
            $link->autocommit(true);
            $link->query("SET FOREIGN_KEY_CHECKS=1");
            exit;
        }
        $sql2 = "INSERT IGNORE INTO mail_receivers (mail_id, receiver_id, is_read) VALUES ($mail_id, $receiver_id, 0)";
        try{
            $link->query($sql2);
        }
        catch(Exception $e){
            $_SESSION['error'] = "Sorry, we have run into a database error. Please try again.<p></p>Error: " . $e;
            $success = false;
        }
    }

    if($success){
        $link->commit();
        $link->autocommit(true);
        $link->query("SET FOREIGN_KEY_CHECKS=1");
        $_SESSION['message'] = "Mail has been successfully sent.";
        // Redirect user back to previous page
        header("location: ../inbox.php");
        exit;
    }
    else{
        $link->rollback();
        $link->autocommit(true);
        $link->query("SET FOREIGN_KEY_CHECKS=1");
        // Redirect user back to previous page
        if(strpos($_SERVER['HTTP_REFERER'],'reply_mail.php') != false){
            header("location: ../mail.php");
        }
        else{
            header("location: ../compose_mail.php");
        }
        exit;
    }
}
else{
    // Redirect user to welcome page
    header("location: ../index.php");
    exit;
}