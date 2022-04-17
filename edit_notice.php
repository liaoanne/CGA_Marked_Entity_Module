<?php
include "includes/head.php";

// Get POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $notice_id = $link->real_escape_string(trim($_POST["edit"]));
    $title = $link->real_escape_string(trim($_POST["title"]));
    $text = trim($_POST["text"]);
}
else{
    // Redirect user to welcome page
    header("location: index.php");
    exit;
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="index.php">Back</a></button>
<p></p>

<h1>Edit Notice</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_edit_notice.php">

<p><strong>Notice Title:</strong><font color='red'> *</font><br>
<input type="text" name="title" size=40 maxlength=150 value='<?php echo $title?>' required>

<p><strong>Notice Text:</strong><font color='red'> *</font><br>
<textarea name="text" rows=8 cols=40 wrap=virtual required><?php printf($text) ?></textarea>

<p><button type="submit" name="edit" value=<?php echo $notice_id?>>Edit Notice</button></p>
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