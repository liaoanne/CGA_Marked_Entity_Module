<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="inbox.php">Back</a></button>
<p></p>

<h1>Compose Mail</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_send_mail.php">

<p><strong>To:</strong><font color='red'> *</font><br>
<input type="text" name="to" size=40 maxlength=150 required>
</b>(separate usernames by comma for multiple receivers)<br></p>

<p><strong>Subject:</strong><font color='red'> *</font><br>
<input type="text" name="subject" size=40 maxlength=150 required></p>

<p><strong>Content:</strong><br>
<textarea name="content" rows=8 cols=40 wrap=virtual></textarea>

<p><button type="submit" name="submit">Send</button></p>
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