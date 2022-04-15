<?php
include "includes/head.php";

// Check if person does not have access
if(!isset($_SERVER['HTTP_REFERER'])){
    // Redirect user back to previous page
    header("location: meetings.php");
    exit;
}

$data = $link->query("SELECT m.title, m.agenda, m.minutes, m.date, g.name FROM meetings m JOIN rtc55314.groups g ON g.group_id=m.group_id WHERE m.meeting_id=" . $_SESSION['meeting_id']);
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $title = $row[0];
        $agenda = $row[1];
        $minutes = $row[2];
        $date = $row[3];
        $group_name = $row[4];
    }
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="meetings.php">Back</a></button>
<p></p>
<h1><?php echo $title; ?></h1>
<p></p>
<hr>
<p></p>
<form class='form-button' method=post action='edit_meeting.php'>
<button class='button-link2' type='submit' name='edit' value='<?php echo $date; ?>'>Change Date/Time</button>
</form>
<p></p>
<form class='form-button' method=post action='includes/delete_meeting.php'>
<button class='button-link2' type='submit' name='delete' value=<?php echo $_SESSION['meeting_id']; ?> onclick="return confirm('Are you sure you want to cancel this meeting?')">Cancel Meeting</button>
</form>
<p></p>
<hr>
<p></p>
<?php
if (isset($_SESSION['message'])){
    echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])){
    echo "<font color='red'>".$_SESSION['error']."</font><br><br>";
    unset($_SESSION['error']);
}
?>
Group Name: <font color='darkblue'><?php echo $group_name; ?></font><br>
Meeting date and time (24-hour format): <font color='darkblue'><?php echo $date; ?></font><br>
<p></p>
<table><tbody>
<tr><th bgcolor='pink'>Agenda:</th>
<td id="agenda" contenteditable="true" onblur="saveText1()"><?php echo nl2br($agenda); ?></td></tr>
<tr><th bgcolor='pink'>Minutes:</th>
<td id="minutes" contenteditable="true" onblur="saveText2()"><?php echo nl2br($minutes); ?></td></tr>
</tbody></table>
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