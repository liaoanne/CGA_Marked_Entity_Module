<?php
include "includes/head.php";

// Check if person does not have access
if(!isset($_SERVER['HTTP_REFERER'])){
    // Redirect user back to previous page
    header("location: marked_entities.php");
    exit;
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="discussion_board.php">Back</a></button>
<p></p>
<h1>
<?php
// Get topic name
$data = $link->query("SELECT title FROM forum_topics WHERE topic_id=" . $_SESSION['topic_id']);
if($data->num_rows>0){
    $topic_data = $data->fetch_assoc();
    $title = $topic_data['title'];
    echo $title;
}

// Check whether due date is passed or group enrolment is over
$data = $link->query("SELECT due_date, DATE(SYSDATE()) FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id']);
if ($data->num_rows>0){
    $entity_data = $data->fetch_assoc();
    $due_date = $entity_data['due_date'];
    $current_date = $entity_data['DATE(SYSDATE())'];
    if($_SESSION['group_id'] != '0' && $_SESSION['group_id'] != 'all'){
        $data = $link->query("SELECT left_group_date FROM group_users WHERE group_id=" . $_SESSION['group_id']);
        if ($data->num_rows>0){
            $group_data = $data->fetch_assoc();
            $left_date = $group_data['left_group_date'];
        }
    }
}
$readonly = false;
if($due_date < $current_date || isset($left_date)){
    $readonly = true;
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
// Print the replies that are still viewable to user - encase they leave a group, replies should not be viewable
if($_SESSION['role_id'] < 4 || $_SESSION['group_id'] == 'all'){
    $data = $link->query("SELECT fr.reply_id,fr.text,fr.date,u.fname,u.lname,u.user_id FROM forum_replies fr 
    JOIN users u ON fr.reply_by=u.user_id WHERE topic_id=" . $_SESSION['topic_id'] . " ORDER BY date");
}
else{
    $data = $link->query("SELECT fr.reply_id,fr.text,fr.date,u.fname,u.lname,u.user_id FROM forum_replies fr 
    JOIN users u ON fr.reply_by=u.user_id 
    WHERE topic_id=" . $_SESSION['topic_id'] . " 
    AND fr.date<=(select coalesce(left_group_date,date('9999-01-01')) FROM group_users WHERE group_id=" . $_SESSION['group_id'] . " 
    AND user_id=" . $_SESSION['id'] . ") ORDER BY date");
}
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $reply_id = $row[0];
        $text = $row[1];
        $date = $row[2];
        $reply_by = $row[3] . " " . $row[4];
        $user_id = $row[5];

        echo "<table><tbody><tr><th>" . $reply_by . ", Posted on: " . $date . "</th><th>Options</th></tr>";
        echo "<tr><td><pre>$text</pre></td>";
        echo "<td>";
        $f_text = $link->real_escape_string($text);
        // Display reply button for everyone
        if(!$readonly){
            echo "<input type='button' value='Reply' onclick=\"insertQuote('$f_text')\">";
        }
        // Display delete button for admin or instructor
        if($_SESSION['role_id']<3){
            echo "<form class='form-button' method=post action='includes/delete_reply.php'>";
            echo "<button type='submit' name='delete' value=$reply_id onclick=\"return confirm('Are you sure you want to delete this reply?')\">Delete</button>";
            echo "</form>";
        }
        // Display delete and edit button for original poster
        else{
            if(!$readonly){
                if($user_id == $_SESSION['id']){
                    echo "<form class='form-button' method=post action='includes/delete_reply.php'>";
                    echo "<button type='submit' name='delete' value=$reply_id>Delete</button>";
                    echo "</form>";
                }
            }
        }

        if(!$readonly){
            if($user_id == $_SESSION['id']){
                echo "<form class='form-button' method=post action='edit_reply.php'>";
                echo "<input type='hidden' name='text' value='$text'>";
                echo "<button name='edit' value=$reply_id>Edit</button>";
                echo "</form>";
            }
        }
        echo "</td></tr>";
        echo "</tbody></table>";
        echo "<br>";
    }
}
?>

<p></p>

<?php if(!$readonly){ ?>
<!-- Reply textbox -->
<form method=post action="includes/do_add_reply.php">
<p><strong>Reply to topic:</strong><br>
<textarea id='reply-box' name='reply' rows=8 cols=40 wrap=virtual></textarea></p>
<p><button type="submit" name="submit">Reply</button></p>
</form>
<?php } ?>

<script type="text/javascript">
    function insertQuote(text){
        const textarea = document.getElementById('reply-box');
        rt = "Reply to: \"";
        reply_text = rt.concat(text, "\"\n------\n");
        if (!textarea.value.endsWith(reply_text)) {
            textarea.value = reply_text;
        }
    }
</script>

</div>

</body>
</html>