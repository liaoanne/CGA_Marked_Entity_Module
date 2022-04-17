<?php
include "includes/head.php";

// Get POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $date = $link->real_escape_string(trim(substr($_POST["edit"], 0, strpos($_POST["edit"], ' '))));
    $time = $link->real_escape_string(trim(substr($_POST["edit"], strpos($_POST["edit"], ' ')+1)));
    $end_time = $link->real_escape_string(trim($_POST['end_time']));
}
else{
    // Redirect user to welcome page
    header("location: index.php");
    exit;
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="meeting_info.php">Back</a></button>
<p></p>

<h1>Edit Meeting Date/Time</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_edit_meeting_time.php">

<p><strong>Set Date:</strong><font color='red'> *</font><br>
<input type='date' name='meeting_date' value=<?php echo $date; ?> required></p>

<p><strong>Set Start Time:</strong><font color='red'> *</font><br>
<input type='time' name='meeting_time' value=<?php echo $time; ?> required></p>

<p><strong>Set End Time:</strong><font color='red'> *</font><br>
<input type='time' name='meeting_end_time' value=<?php echo $end_time; ?> required></p>

<p><button type="submit" name="edit">Edit Meeting</button></p>
</form>

<?php
// Print error message from db and unset error
if (isset($_SESSION['error'])){
  echo "<font color='red'>".$_SESSION['error']."</font>";
  unset($_SESSION['error']);
}
?>

</div>

</body>
</html>