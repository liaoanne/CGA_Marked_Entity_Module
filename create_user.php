<?php
session_start();
include "./includes/config.php";
?>

<style>
.sidebar{width:20%; float:left;}
.content{width:78%; margin-top:-8px; padding:1%; float:right;background-color:rgb(250, 240, 230);}
</style>

<html>
<head>
<Title>CGA - The CrsMgr Group-work Assistant</title>
</head>

<body>

<!-- Displays the coursemanager header -->
<div class=header>
<?php
include "templates/header.php";
?>
</div>

<hr>

<!-- Displays the coursemanager nagivation sidebar -->
<div class=sidebar>
<?php
include "templates/sidebar.php";
?>
</div>

<!-- Displays the coursemanager main content -->
<div class=content>
    <h1>Create a User</h1>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username<font color='red'> *</font></label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>    
        <div class="form-group">
            <label>Password<font color='red'> *</font></label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
        <label>First Name<font color='red'> *</font></label>
        <input type="text" name="fname" class="form-control"  value="<?php echo $fname; ?>">
    </div>
    <div class="form-group">
        <label>Last Name<font color='red'> *</font></label>
        <input type="text" name="lname" class="form-control"  value="<?php echo $lname; ?>">
    </div>
    <div class="form-group">
        <label>Email<font color='red'> *</font></label>
        <input type="email" name="email" class="form-control"  value="<?php echo $email; ?>">
    </div>
    <div class="form-group">
        <label>User type</label>
        <select name="user_type" id="user_type" class="form-control" >
            <option value="">Select an option</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div class="form-group">
            <input type="checkbox"  name="active"  value="1">
            <label for="Active">Active</label>
    </div>
        <div class="form-group">
            <input type="submit" style='background-color:pink' value="Submit">
        </div>
    </form>
</div>

</body>
</html>