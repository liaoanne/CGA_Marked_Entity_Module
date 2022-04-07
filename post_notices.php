<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1>Post a Notice</h1>
</b>This will post a notice for all students in the course to see.<br><br>
<font color='red'>* Required field</font>

<form method=post action="includes/do_post_notice.php">

<p><strong>Notice Title:</strong><font color='red'> *</font><br>
<input type="text" name="title" size=40 maxlength=150 required>

<p><strong>Notice Text:</strong><font color='red'> *</font><br>
<textarea name="text" rows=8 cols=40 wrap=virtual required></textarea>

<p><button type="submit" name="submit">Post Notice</button></p>
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