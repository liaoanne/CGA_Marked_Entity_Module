<?php
// Initialize the session
//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
session_start();
 
// Include config file
include "config.php";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $link->real_escape_string(trim($_POST["username"]));
    $password = $link->real_escape_string(trim($_POST["password"]));
	
	// Validate credentials
    $data = $link->query("SELECT * FROM users WHERE username = '$username'");
    if($data -> num_rows>0){
        $user_data = $data->fetch_assoc();
        $db_user_id = $user_data['user_id'];
        $db_username = $user_data['username'];
        $db_password = $user_data['password'];
        $db_fname = $user_data['fname'];
        $db_lname = $user_data['lname'];
        
        if($db_password==$password){  
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $db_user_id;
            $_SESSION["username"] = $username;
            $_SESSION["fname"] = $db_fname;
            $_SESSION["lname"] = $db_lname;
                        
            // Redirect user to role list page
            header("location: ../role_list.php");
            exit;
        }
        else{
            $_SESSION['error'] = "Incorrect password.";
            header("location: ../login_page.php");
            exit;
        }
    }
    else{
        $_SESSION['error'] = "User doesn't exist!";
        header("location: ../login_page.php");
        exit;
    }

    // Close connection
    mysqli_close($link);
}
else{
    header("location: ../login_page.php");
}
?>