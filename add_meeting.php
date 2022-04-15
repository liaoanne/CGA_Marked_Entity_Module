<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="meetings.php">Back</a></button>
<p></p>

<h1>Create a Meeting</h1>
<br><br>
<font color='red'>* Required field</font>

<form method=post action="includes/do_add_meeting.php">

<p><strong>Meeting Title:</strong><font color='red'> *</font><br>
<input type="text" name="title" size=40 maxlength=150 required></p>

<p><strong>Group:</strong><font color='red'> *</font><br>
<select name="group" required>
	<option selected disabled value="">Please choose a group</option>
    <?php
    $data = $link->query("SELECT gu.group_id, g.name FROM group_users gu JOIN rtc55314.groups g ON g.group_id=gu.group_id WHERE gu.user_id=" . $_SESSION['id'] . " AND gu.left_group_date is null AND g.section_id=" . $_SESSION['section_id']);
        if($data -> num_rows>0){
            while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
                $group_id = $row[0];
                $group_name = $row[1];
                echo "<option value='" . $group_id . "'>" . $group_name . "</option>";
            }
        }
    ?>
</select></p>

<p><strong>Set Date:</strong><font color='red'> *</font><br>
<input type='date' name='meeting_date' required></p>

<p><strong>Set Time:</strong><font color='red'> *</font><br>
<input type='time' name='meeting_time' required></p>

<p><strong>Meeting Agenda:</strong><br>
<textarea name="agenda" rows=8 cols=40 wrap=virtual></textarea></p>

<p><button type="submit" name="submit">Create Meeting</button></p>
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