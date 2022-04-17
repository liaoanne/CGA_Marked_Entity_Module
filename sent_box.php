<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1>Sent Mail</h1>
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
<tr><th>Mail Title</th><th>To</th><th>Date</th></tr>
<?php
$data = $link->query("SELECT mail_id, subject, text, send_date FROM mail WHERE sender_id=" . $_SESSION['id'] . " ORDER BY send_date DESC");
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $mail_id = $row[0];
        $subject = $row[1];
        $text = $row[2];
        $send_date = $row[3];

        $data2 = $link->query("SELECT receiver_id FROM mail_receivers WHERE mail_id=$mail_id");
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

        echo "<tr><td><button class='button-link' name='mail_id' value=$mail_id type='submit'>";
        echo $subject . "</button></td><td>" . $receivers . "</td><td>" . $send_date . "</td>";
    }
    echo "</form></tbody></table>";
}
?>