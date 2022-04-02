<?php
include "includes/head.php";
?>

<style>
.content table, .content th, .content td{
    border:1px solid;
}
.content th{
    background-color:pink;
}
</style>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="discussion_board.php">Back</a></button>
<p></p>
<h1>
<?php
    // Get topic name
    $data = $link->query("SELECT title FROM forum_topics WHERE topic_id=" . $_SESSION['topic_id']);
    if($data -> num_rows>0){
        $topic_data = $data->fetch_assoc();
        $title = $topic_data['title'];
        echo $title;
    }
?>
</h1>
<p></p>
<hr>
<p></p>

<?php
// Display error/success message when adding reply
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
if (isset($_SESSION['error'])){
    echo "<font color='red'>".$_SESSION['error']."</font><br><br>";
    unset($_SESSION['error']);
}
?>

<!-- Display discussion thread -->
<?php
$data = $link->query("SELECT fr.reply_id,fr.text,fr.date,u.fname,u.lname,u.user_id FROM forum_replies fr JOIN users u ON fr.reply_by=u.user_id WHERE topic_id=" . $_SESSION['topic_id'] . " ORDER BY date");
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $reply_id = $row[0];
        $text = $row[1];
        $date = $row[2];
        $reply_by = $row[3] . " " . $row[4];
        $user_id = $row[5];

        echo "<table><tbody><tr><th>" . $reply_by . ", Posted on: " . $date . "</th></tr>";
        echo "<tr><td>" . $text . "</td></tr>";
        echo "</tbody></table>";
        echo "<br>";
        if($_SESSION['role_id']<3){
            echo "<form method=post action='includes/delete_reply.php'>";
            echo "<button type='submit' name='delete' value=$reply_id>Delete</button>";
            echo "</form>";
        }
        else{
            if($user_id == $_SESSION['id']){
                echo "<form method=post action='includes/delete_reply.php'>";
                echo "<button type='submit' name='delete' value=$reply_id>Delete</button>";
                echo "</form>";
                echo "<form method=post action='edit_reply.php'>";
                echo "<input type='hidden' name='text' value='$text'>";
                echo "<button name='edit' value=$reply_id>Edit</button>";
                echo "</form>";
            }
        }
    }
}
?>

<p></p>

<!-- Reply textbox -->
<form method=post action="includes/do_add_reply.php">
<p><strong>Reply to topic:</strong><br>
<textarea name="reply" rows=8 cols=40 wrap=virtual></textarea></p>
<p><button type="submit" name="submit">Reply</button></p>
</form>

</div>

</body>
</html>