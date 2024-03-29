<?php
include "includes/head.php";

// Check if person does not have access
if(!isset($_SERVER['HTTP_REFERER'])){
  // Redirect user back to previous page
  header("location: marked_entities.php");
  exit;
}

// Get reply id
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reply_id = $link->real_escape_string(trim($_POST["edit"]));
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

<button><a href="discussion.php">Back</a></button>
<p></p>

<h1>Edit Reply</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_edit_reply.php">

<p><strong>Post Text:</strong><font color='red'> *</font><br>
<textarea name="text" rows=8 cols=40 wrap=virtual required><?php echo "$text" ?></textarea>
<p><button type="submit" name="edit" value=<?php echo $reply_id?>>Edit Reply</button></p>
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