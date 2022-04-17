<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<?php
if($_SESSION['role_id'] == 1){
  echo "<h3>Welcome To Course Admin Home Page</h3>";
}
elseif($_SESSION['role_id'] == 2){
  echo "<h3>Welcome To Course Instructor Home Page</h3>";
}
elseif($_SESSION['role_id'] == 3){
  echo "<h3>Welcome To Course TA Home Page</h3>";
}
else{
  echo "<h3>Welcome To Course Student Home Page</h3>";
}
?>
<p></p>
<hr>

<?php
// Display success message when adding notice
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font>";
  unset($_SESSION['message']);
}
?>

<p></p>
Announcement
<p></p>

<?php
$data = $link->query("SELECT * FROM notices WHERE section_id=" . $_SESSION['section_id']);
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
      $notice_id = $row[0];
      $title = $row[2];
      $text = $row[3];
      $date = $row[4];
      echo "<table><tbody>";
      echo "<tr><th bgcolor='pink'>Post Time:<br>(24-hour format)</th>";
      echo "<td>$date</td></tr>";
      echo "<tr><th bgcolor='pink'>Title:</th>";
      echo "<td><font color='blue'>$title</font></td></tr>";
      echo "<tr><th bgcolor='pink'>Detail</th>";
      echo "<td>" . nl2br($text) . "</td></tr>";
      if($_SESSION['role_id'] < 3){
        echo "<tr><th bgcolor='pink'>Actions</th>";
        echo "<td>";
        echo "<form class='form-button' method=post action='includes/delete_notice.php'>";
        echo "<button type='submit' name='delete' value=$notice_id onclick=\"return confirm('Are you sure you want to delete this notice?')\">Delete</button>";
        echo "</form>";
        echo "<form class='form-button' method=post action='edit_notice.php'>";
        echo "<input type='hidden' name='title' value='$title'>";
        echo "<input type='hidden' name='text' value='$text'>";
        echo "<button name='edit' value=$notice_id>Edit</button>";
        echo "</form>";
        echo "</td></tr>";
      }
      echo "</table></tbody>";
      echo "</p></p>";
    }
?>

<p></p>
<hr>
<p></p>
Latest Discussions
<p></p>

</div>

</body>
</html>
