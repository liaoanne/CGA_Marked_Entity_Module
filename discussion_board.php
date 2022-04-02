<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="marked_entities.php">Back</a></button>
<p></p>

<h1>Discussion Boards <?php echo "For " . $_SESSION['entity_name'];?></h1>
<p></p>
<hr>
<p></p>
<?php
// Display create a custom category if admin or instructor
if ($_SESSION['role_id'] < 3){
    echo "<a href='add_category.php'>Create a Custom Category</a>";
    echo "<p></p>";
}
?>
<a href="add_topic.php">Create a Topic</a>
<p></p>
<a href="add_file_to_entity.php">Create a Poll</a>
<p></p>
<a href="add_file_to_entity.php">Upload a File</a>
<p></p>
<hr>
<p></p>

<?php
// Display success message when adding marked entity
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
?>

<!-- Display discussions available -->
<?php
// Display the posts viewable to admin, instructor, and TA
if($_SESSION['role_id']< 4){
    $data = $link->query("SELECT * FROM forum_categories WHERE marked_entity_id=" . $_SESSION['entity_id']);
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
			$cat_id = $row[0];
			$cat_name = $row[2];

            echo $cat_name;
			echo "<table><tbody><tr><th>Topic Title</th><th>Date Created</th><th>Latest Post</th><th>Author</th><th>Replies</th></tr>";
            echo "<form method=post action='includes/topic_select.php'>";

            $data2 = $link->query("SELECT ft.topic_id, ft.title, ft.date created, CONCAT(u.fname,' ',u.lname) author, max(fr.date) last_modified, count(fr.reply_id) num_replies FROM forum_topics ft JOIN forum_replies fr ON ft.topic_id=fr.topic_id JOIN users u ON ft.topic_by=u.user_id WHERE category_id=$cat_id GROUP BY ft.topic_id, ft.title, ft.date, CONCAT(u.fname,' ',u.lname);");

            if($data2 -> num_rows>0){
                while($row2 = mysqli_fetch_array($data2,MYSQLI_NUM)){
                    $topic_id = $row2[0];
                    $topic_name = $row2[1];
                    $topic_date = $row2[2];
                    $topic_author = $row2[3];
                    $topic_modified = $row2[4];
                    $topic_replies = $row2[5];
                    echo "<tr><td><button class='button-link' name='topic_id' value=$topic_id type='submit'>" . $topic_name . "</button></td>";
                    echo "<td>" . $topic_date . "</td>";
                    echo "<td>" . $topic_modified . "</td>";
                    echo "<td>" . $topic_author . "</td>";
                    echo "<td>" . $topic_replies . "</td></tr>";
                }
            }

            echo "</form></tbody></table>";
			echo "<br>";
		}
	}
}
// Display posts viewable to students
else{
    // Get the groups that the student belong to
    $groups = ['all'];
    $data = $link->query("SELECT group_id FROM group_users WHERE user_id=" . $_SESSION['id']);
    if($data -> num_rows>0){
        while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
            array_push($groups,(string)$row[0]);
        }
    }

    // Display the discussion boards available
    foreach($groups as $value){
        $data = $link->query("SELECT * FROM forum_categories WHERE (viewable_to LIKE '%," . $value . ",%') AND marked_entity_id=" . $_SESSION['entity_id']);
        if($data -> num_rows>0){
            while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
                $cat_id = $row[0];
                $cat_name = $row[2];

                echo $cat_name;
                echo "<table><tbody><tr><th>Topic Title</th><th>Date Created</th><th>Latest Post</th><th>Author</th><th>Replies</th></tr>";
                echo "<form method=post action='includes/topic_select.php'>";

                $data2 = $link->query("SELECT ft.topic_id, ft.title, ft.date created, CONCAT(u.fname,' ',u.lname) author, max(fr.date) last_modified, count(fr.reply_id) num_replies FROM forum_topics ft JOIN forum_replies fr ON ft.topic_id=fr.topic_id JOIN users u ON ft.topic_by=u.user_id WHERE category_id=$cat_id GROUP BY ft.topic_id, ft.title, ft.date, CONCAT(u.fname,' ',u.lname);");
    
                if($data2 -> num_rows>0){
                    while($row2 = mysqli_fetch_array($data2,MYSQLI_NUM)){
                        $topic_id = $row2[0];
                        $topic_name = $row2[1];
                        $topic_date = $row2[2];
                        $topic_author = $row2[3];
                        $topic_modified = $row2[4];
                        $topic_replies = $row2[5];
                        echo "<tr><td><button class='button-link' name='topic_id' value=$topic_id type='submit'>" . $topic_name . "</button></td>";
                        echo "<td>" . $topic_date . "</td>";
                        echo "<td>" . $topic_modified . "</td>";
                        echo "<td>" . $topic_author . "</td>";
                        echo "<td>" . $topic_replies . "</td></tr>";
                    }
                }

                echo "</form></tbody></table>";
                echo "<br>";
            }
        }
    }
}
?>

</div>

</body>
</html>