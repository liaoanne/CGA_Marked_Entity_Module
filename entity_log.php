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
<h1>Audit Log for <?php echo $_SESSION['entity_name']; ?></h1>

<?php
$data = $link->query("SELECT * FROM marked_entities_log WHERE marked_entity_id=" . $_SESSION['entity_id']);
if($data -> num_rows>0){
    echo "<table><tbody><tr><th>Time of Change</th><th>User ID</th><th>Name</th><th>Query</th></tr>";
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $user_id = $row[2];
        $fname = $row[3];
        $lname = $row[4];
        $query = $row[5];
        $log_time = $row[6];
        $name = $fname . " " . $lname;
        echo "<tr><td>" . $log_time . "</td><td>" . $user_id . "</td><td>" . $name . "</td><td>" . $query . "</td>";
    }
    echo "</tbody></table>";
}
?>