<?php
include "includes/head.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get POST
    if(isset($_POST["reply"])){
        $reply = $link->real_escape_string(trim($_POST["reply"]));
    }
    else{
        $reply = $link->real_escape_string(trim($_POST["reply_all"]));
    }
    $subject = $link->real_escape_string(trim($_POST["subject"]));
    if(substr($subject,0,4) == 'Re: '){
        $subject = substr($subject, 4);
    }
    $sender_un = $link->real_escape_string(trim($_POST["sender_un"]));
    $receivers = $link->real_escape_string(trim($_POST["receivers"]));
    $send_date = $link->real_escape_string(trim($_POST["send_date"]));
    $text = trim($_POST["text"]);
}
else{
    header("location: ../inbox.php");
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="mail.php">Back</a></button>
<p></p>

<h1>Reply Mail</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_send_mail.php">

<p><strong>To:</strong><font color='red'> *</font><br>
<input type="text" name="to" size=40 maxlength=150 value='<?php echo $reply; ?>' required>
</b>(separate usernames by comma for multiple receivers)<br></p>

<p><strong>Subject:</strong><font color='red'> *</font><br>
<input type="text" name="subject" size=40 maxlength=150 value='Re: <?php echo $subject; ?>' required></p>

<p><strong>Content:</strong><br>
<textarea name="content" rows=8 cols=40 wrap=virtual>

-----------------------------

From: <?php echo $sender_un; ?>

To: <?php echo $receivers; ?>

Sent: <?php echo $send_date; ?>


<?php echo $text; ?>
</textarea>

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