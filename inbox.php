<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1>Inbox</h1>
<p></p>
<hr>
<p></p>

<?php
// Display success message when adding meeting
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
?>

<table><tbody>
<form method=post action='includes/mail_select.php'>
<tr><th>Mail Title</th><th>From</th><th>Date</th></tr>
<?php
$data = $link->query("SELECT m.mail_id, m.sender_id, m.subject, m.text, m.send_date, mr.is_read FROM mail m JOIN mail_receivers mr ON m.mail_id=mr.mail_id WHERE mr.receiver_id=" . $_SESSION['id'] . " ORDER BY m.send_date DESC");
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $mail_id = $row[0];
        $sender_id = $row[1];
        $subject = $row[2];
        $text = $row[3];
        $send_date = $row[4];
        $is_read = $row[5];

        $data2 = $link->query("SELECT username FROM users WHERE user_id=$sender_id");
        if($data2 -> num_rows>0){
            $sender_data = $data2->fetch_assoc();
            $sender_un = $sender_data['username'];
        }

        echo "<tr><td><button class='button-link' name='mail_id' value=$mail_id type='submit'>";
        if (!$is_read){
            echo "<b>";
        }
        echo $subject . "</button></td><td>" . $sender_un . "</td><td>" . $send_date . "</td>";
    }
    echo "</form></tbody></table>";
}
?>