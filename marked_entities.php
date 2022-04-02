<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1>Marked Entities</h1>
<p></p>
<hr>
<p></p>

<?php
// Display create marked entity button if instructor or admin
if ($_SESSION['role_id'] < 3){
    echo '<a href="add_marked_entity.php">Create a Marked Entity</a>';
    echo '<p></p>';
    echo '<hr><p></p>';
}

// Display success message when adding marked entity
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}

// Display the marked entities viewable to admin, instructor, and TA
$hw_type=['asg', 'proj', 'other'];
if($_SESSION['role_id'] < 4){
    // Display each marked entities category in tables
    foreach($hw_type as $t){
        $data = $link->query("SELECT * FROM marked_entities WHERE type='$t' AND section_id=" . $_SESSION['section_id']);
        if($data -> num_rows>0){
            if($t=='asg'){
                echo "Assignment";
            }
            elseif($t=='proj'){
                echo "Project";
            }
            else{
                echo "Other";
            }
            echo "<table><tbody><tr><th>Title</th><th>Date Posted</th><th>Due Date</th><th>Work Type</th></tr>";
            echo "<form method=post action='includes/marked_entity_select.php'>";
            while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
                $entity_id = $row[0];
                $entity_name = $row[2];
                $post_date = $row[3];
                $due_date = $row[4];
                $work_type = ucfirst($row[6]);
                echo "<tr><td><button class='button-link' name='entity_id' value=$entity_id type='submit'>" . $entity_name . "</button></td><td>" . $post_date . "</td><td>" . $due_date . "</td><td>" . $work_type . "</td>";
            }
            echo "</form></tbody></table>";
            echo "<br>";
        }
    }
}
// Display marked entities viewable to students
else{
    // Get the groups that the student belong to
    $groups = ['all'];
    $data = $link->query("SELECT group_id FROM group_users WHERE user_id=" . $_SESSION['id']);
    if($data -> num_rows>0){
        while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
            array_push($groups,(string)$row[0]);
        }
    }

    // Display each marked entities category in tables
    foreach($hw_type as $t){
        if($t=='asg'){
            echo "Assignment";
        }
        elseif($t=='proj'){
            echo "Project";
        }
        else{
            echo "Other";
        }
        echo "<table><tbody><tr><th>Title</th><th>Date Posted</th><th>Due Date</th><th>Work Type</th></tr>";
        echo "<form method=post action='includes/marked_entity_select.php'>";
        foreach($groups as $value){
            $data = $link->query("SELECT * FROM marked_entities WHERE (viewable_to LIKE '%," . $value . ",%') AND type='$t' AND section_id=" . $_SESSION['section_id']);
            if($data -> num_rows>0){
                while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
                    $entity_id = $row[0];
                    $entity_name = $row[2];
                    $post_date = $row[3];
                    $due_date = $row[4];
                    $work_type = ucfirst($row[6]);
                    echo "<tr><td><button class='button-link' name='entity_id' value=$entity_id>" . $entity_name . "</button></td><td>" . $post_date . "</td><td>" . $due_date . "</td><td>" . $work_type . "</td>";
                }
            }
        }
        echo "</form></tbody></table>";
        echo "<br>";
    }
}
?>

</div>

</body>
</html>