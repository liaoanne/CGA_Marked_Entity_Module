<?php
include "includes/head.php";

// Check if person does not have access
if(!isset($_SERVER['HTTP_REFERER'])){
    // Redirect user back to previous page
    header("location: meetings.php");
    exit;
}

$data = $link->query("SELECT m.title, m.agenda, m.minutes, m.date, m.end_time, g.name, g.group_id FROM meetings m JOIN rtc55314.groups g ON g.group_id=m.group_id WHERE m.meeting_id=" . $_SESSION['meeting_id']);
if($data -> num_rows>0){
    $meeting_data = $data->fetch_assoc();
    $title = $meeting_data['title'];
    $agenda = $meeting_data['agenda'];
    $minutes = $meeting_data['minutes'];
    $date = $meeting_data['date'];
    $end_time = $meeting_data['end_time'];
    $group_name = $meeting_data['name'];
    $group_id = $meeting_data['group_id'];
}

$readonly = false;
$data = $link->query("SELECT left_group_date FROM group_users WHERE group_id=$group_id AND user_id=" . $_SESSION['id']);
if($data -> num_rows>0){
    $left_data = $data->fetch_assoc();
    if($left_data['left_group_date'] != ''){
        $readonly = true;
    }
}
?>

<style>
#agenda {
    min-width:300px;
}
</style>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="meetings.php">Back</a></button>
<p></p>
<h1><?php echo $title; ?></h1>
<p></p>
<hr>
<p></p>
<?php if(!$readonly){ ?>
    <form class='form-button' method=post action='edit_meeting.php'>
    <input type='hidden' name='end_time' value=<?php echo $end_time; ?>>
    <button class='button-link2' type='submit' name='edit' value='<?php echo $date; ?>'>Change Date/Time</button>
    </form>
    <p></p>
    <form class='form-button' method=post action='includes/delete_meeting.php'>
    <button class='button-link2' type='submit' name='delete' value=<?php echo $_SESSION['meeting_id']; ?> onclick="return confirm('Are you sure you want to cancel this meeting?')">Cancel Meeting</button>
    </form>
    <p></p>
    <hr>
    <p></p>
<?php } ?>
<?php
// Display success/error messages
if (isset($_SESSION['message'])){
    echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])){
    echo "<font color='red'>".$_SESSION['error']."</font><br><br>";
    unset($_SESSION['error']);
}

// Notify the user when they are in read only mode
if($readonly){
    echo "<font color='red'>You are in read-only mode because you left this group.</font><p></p>";
}
?>
Group Name: <font color='darkblue'><?php echo $group_name; ?></font><br>
Meeting date and time (24-hour format): <font color='darkblue'><?php echo $date . "-" . $end_time; ?></font><br>
<p></p></b>
The meeting agenda and minutes can be edited at any time by any group member.<br>
To edit, click inside the table cell. When done editing, click the ‘Save’ button below.<br>
Groups should avoid editing the details at the same time, since edits may get overwritten.<br>
Refresh the page to make sure you are viewing the latest updates.<br>
<p></p>
<table><tbody>
<tr><th bgcolor='pink'>Agenda:</th>
<td id="agenda" <?php if(!$readonly){ ?>contenteditable="true" onblur="saveText1()" <?php } ?>><?php echo nl2br($agenda); ?></td></tr>
<tr><th bgcolor='pink'>Minutes:</th>
<td id="minutes" <?php if(!$readonly){ ?>contenteditable="true" onblur="saveText2()" <?php } ?>><?php echo nl2br($minutes); ?></td></tr>
</tbody></table>
<button onclick="return alert('Saved')">Save</button>
</div>

<script>
    function saveText1(){
        var xr = new XMLHttpRequest();
        var url = "includes/do_edit_meeting_info.php";
        var text = document.getElementById("agenda").innerHTML;
        var vars = "new_agenda="+text;
        xr.open("POST", url, true);
        xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xr.send(vars);
    }
    function saveText2(){
        var xr = new XMLHttpRequest();
        var url = "includes/do_edit_meeting_info.php";
        var text = document.getElementById("minutes").innerHTML;
        var vars = "new_minutes="+text;
        xr.open("POST", url, true);
        xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xr.send(vars);
    }
</script>