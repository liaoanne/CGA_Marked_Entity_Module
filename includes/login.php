<?php
// Initialize the session
//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
session_start();
 
// Include config file
include "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
	
	// Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Get user info
		$data = $link->query("SELECT * FROM users WHERE username = '$username'");
		if($data -> num_rows>0){
			$user_data = $data->fetch_assoc();
			$db_user_id = $user_data['user_id'];
			$db_username = $user_data['username'];
			$db_password = $user_data['password'];
			$db_fname = $user_data['fname'];
			$db_lname = $user_data['lname'];
			
			if($db_password==$password){
                // Password is correct, so start a new session
                //session_start();
                            
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $db_user_id;
                $_SESSION["username"] = $username;
				$_SESSION["fname"] = $db_fname;
				$_SESSION["lname"] = $db_lname;
                            
                // Redirect user to welcome page
                header("location: ../role_list.php");
			}
			else{
				$error = 'Incorrect password.';
			}
		}
		else{
			$error = "User doesn't exist!";
		}
	}
	else{
		$error = $username_err . " " . $password_err;
	}

    // Close connection
    mysqli_close($link);
}
else{
    header("location: ../login_page.php");
}
?>

<HTML>
<BODY>
<p>
<?php echo $error; ?>
</p>
<a href="../login_page.php">Back to login</a>
</BODY>
</HTML>