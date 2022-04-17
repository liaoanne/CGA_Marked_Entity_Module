<?php
include "includes/head.php";

if(!isset($_SERVER['HTTP_REFERER'])){
    // Redirect user back to previous page
    header("location: inbox.php");
    exit;
}

$link->query("UPDATE mail_receivers SET is_read=1 WHERE mail_id=" . $_SESSION['mail_id'] . " AND receiver_id=" . $_SESSION['id']);
$data = $link->query("SELECT * FROM mail WHERE mail_id=" . $_SESSION['mail_id']);
if($data -> num_rows>0){
    $mail_data = $data->fetch_assoc();
    $sender_id = $mail_data['sender_id'];
    $subject = $mail_data['subject'];
    $text = $mail_data['text'];
    $send_date = $mail_data['send_date'];

    $data2 = $link->query("SELECT username FROM users WHERE user_id=$sender_id");
    if($data2 -> num_rows>0){
        $sender_data = $data2->fetch_assoc();
        $sender_un = $sender_data['username'];
    }
    $data2 = $link->query("SELECT receiver_id FROM mail_receivers WHERE mail_id=" . $_SESSION['mail_id']);
    if($data2 -> num_rows>0){
        $receivers = "";
        while($row = mysqli_fetch_array($data2,MYSQLI_NUM)){
            $data3 = $link->query("SELECT username FROM users WHERE user_id=$row[0]");
            if($data3 -> num_rows>0){
                $receiver_data = $data3->fetch_assoc();
                $receiver_un = $receiver_data['username'];
                if(empty($receivers)){
                    $receivers = $receiver_un;
                }
                else{
                    $receivers = $receivers . ", " . $receiver_un;
                }
            }
        }
    }
    $reply_all_users = $receivers;
    $reply_all_users = str_replace(", " . $_SESSION['username'] . ", ", ", ", $reply_all_users);
    if(strpos($reply_all_users, $_SESSION['username'] . ", ") === 0){
        $reply_all_users = substr($reply_all_users, strlen($_SESSION['username'] . ", "));
    }
    if(substr($reply_all_users,-strlen(", " . $_SESSION['username']))===", " . $_SESSION['username']){
        $reply_all_users = substr($reply_all_users, 0, -strlen(", " . $_SESSION['username']));
    }
    $reply_all_users = $sender_un . ", " . $reply_all_users;
    // $reply_all_users = preg_replace("{, " . $_SESSION['username'] . "}$", "", $reply_all_users);
    // $reply_all_users = preg_replace("^{" . $_SESSION['username'] . ", }", "", $reply_all_users);
    // $reply_all_users = str_replace(", " . $_SESSION['username'], "", $reply_all_users);
    // $reply_all_users = str_replace($_SESSION['username'] . ", ", "", $reply_all_users);
}

?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1><?php echo $subject; ?></h1>
<p></p>
<hr>
<p></p>

<p>
From: <?php echo $sender_un; ?><br>
To: <?php echo $receivers; ?><br>
Sent: <?php echo $send_date; ?><br>
<form method='post' action='reply_mail.php'>
    <input type='hidden' name='subject' value='<?php echo $subject; ?>'>
    <input type='hidden' name='sender_un' value='<?php echo $sender_un; ?>'>
    <input type='hidden' name='receivers' value='<?php echo $receivers; ?>'>
    <input type='hidden' name='send_date' value='<?php echo $send_date; ?>'>
    <input type='hidden' name='text' value='<?php echo $text; ?>'>
    <button name='reply' value='<?php echo $sender_un; ?>' type='submit'>Reply</button>
    <button name='reply_all' value='<?php echo $reply_all_users; ?>' type='submit'>Reply All</button>
</form>
<hr>
<?php echo nl2br($text); ?>
</p>

<?php
// Display success message when adding meeting
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
if (isset($_SESSION['error'])){
    echo "<font color='red'>".$_SESSION['error']."</font><br><br>";
    unset($_SESSION['error']);
  }
?>