<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h3>Welcome To Course Student Home Page</h3>
<p></p>
<hr>

<?php
// Display success message when adding marked entity
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
?>

<p></p>
Announcement
<p></p>

<?php
$data = $link->query("SELECT * FROM notices WHERE section_id=" . $_SESSION['section_id']);
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $title = $row[2];
        $text = $row[3];
        $date = $row[4];
        echo "<table><tbody>";
        echo "<tr><th bgcolor='pink'>Post Time:<br>(24-hour format)</th>";
        echo "<td>$date</td></tr>";
        echo "<tr><th bgcolor='pink'>Title:</th>";
        echo "<td>$title</td></tr>";
        echo "<tr><th bgcolor='pink'>Detail</th>";
        echo "<td><pre>$text<pre></td></tr>";
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
