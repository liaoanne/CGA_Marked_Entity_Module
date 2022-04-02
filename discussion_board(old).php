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
<h1>Discussion Boards</h1>
<p></p>
<hr>
<p></p>
<a href="add_category.php">Create a Category</a>
<p></p>
<a href="add_topic.php">Create a Topic</a>
<p></p>
<hr>
<p></p>

<!-- Display discussions available -->
<?php
// Display the posts viewable to admin, instructor, and TA
if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3){
    $data = $link->query("SELECT * FROM forum_categories WHERE section_id=" . $_SESSION['section_id']);
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
			$cat_id = $row[0];
			$cat_name = $row[2];
			$cat_desc = $row[3];
            $data2 = $link->query("SELECT ft.topic_id, ft.title, ft.date created, CONCAT(u.fname,' ',u.lname) author, max(fr.date) last_modified, count(fr.reply_id) num_replies FROM forum_topics ft JOIN forum_replies fr ON ft.topic_id=fr.topic_id JOIN users u ON ft.topic_by=u.user_id WHERE category_id=$cat_id GROUP BY ft.topic_id, ft.title, ft.date, CONCAT(u.fname,' ',u.lname);");

            echo $cat_name . ": " . $cat_desc;
			echo "<table><tbody><tr><th>Topic Title</th><th>Date Created</th><th>Latest Post</th><th>Author</th><th>Replies</th></tr>";

            if($data2 -> num_rows>0){
                while($row2 = mysqli_fetch_array($data2,MYSQLI_NUM)){
                    $topic_name = $row2[1];
                    $topic_date = $row2[2];
                    $topic_author = $row2[3];
                    $topic_modified = $row2[4];
                    $topic_replies = $row2[5];
                    echo "<tr><td>" . $topic_name . "</td>";
                    echo "<td>" . $topic_date . "</td>";
                    echo "<td>" . $topic_modified . "</td>";
                    echo "<td>" . $topic_author . "</td>";
                    echo "<td>" . $topic_replies . "</td></tr>";
                }
            }

            echo "</tbody></table>";
			echo "<br>";
		}
	}
}
// // Display posts viewable to TA
// elseif($_SESSION['role_id'] == 3){
//     $data = $link->query("SELECT * FROM forum_categories WHERE (viewable_to LIKE '%ta%' OR viewable_to='all') AND section_id=" . $_SESSION['section_id']);
// 	if($data -> num_rows>0){
// 		while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
// 			$cat_id = $row[0];
// 			$cat_name = $row[2];
// 			$cat_desc = $row[3];
//             $data2 = $link->query("SELECT ft.topic_id, ft.title, ft.date created, CONCAT(u.fname,' ',u.lname) author, max(fr.date) last_modified, count(fr.reply_id) num_replies FROM forum_topics ft JOIN forum_replies fr ON ft.topic_id=fr.topic_id JOIN users u ON ft.topic_by=u.user_id WHERE category_id=$cat_id GROUP BY ft.topic_id, ft.title, ft.date, CONCAT(u.fname,' ',u.lname);");

//             echo $cat_name . ": " . $cat_desc;
// 			echo "<table><tbody><tr><th>Topic Title</th><th>Date Created</th><th>Latest Post</th><th>Author</th><th>Replies</th></tr>";

//             if($data2 -> num_rows>0){
//                 while($row2 = mysqli_fetch_array($data2,MYSQLI_NUM)){
//                     $topic_name = $row2[1];
//                     $topic_date = $row2[2];
//                     $topic_author = $row2[3];
//                     $topic_modified = $row2[4];
//                     $topic_replies = $row2[5];
//                     echo "<tr><td>" . $topic_name . "</td>";
//                     echo "<td>" . $topic_date . "</td>";
//                     echo "<td>" . $topic_modified . "</td>";
//                     echo "<td>" . $topic_author . "</td>";
//                     echo "<td>" . $topic_replies . "</td></tr>";
//                 }
//             }

//             echo "</tbody></table>";
// 			echo "<br>";
// 		}
// 	}
// }
// Display posts viewable to students
else{
    // Get the groups that the student belong to
    $data = $link->query("SELECT group_id FROM group_users WHERE user_id=" . $_SESSION['id']);
    if($data -> num_rows>0){
        $groups = array();
        while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
            array_push($groups,$row[0]);
        }
    }
    
    $checked_ids = array();
    foreach($groups as $value){
        $data = $link->query("SELECT * FROM forum_categories WHERE (viewable_to LIKE '%," . $value . ",%' OR viewable_to='all') AND section_id=" . $_SESSION['section_id']);
        if($data -> num_rows>0){
            while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
                $cat_id = $row[0];
                if (in_array($cat_id, $checked_ids)){
                    continue;
                }
                else {
                    array_push($checked_ids,$cat_id);
                }
                $cat_name = $row[2];
                $cat_desc = $row[3];
                $data2 = $link->query("SELECT ft.topic_id, ft.title, ft.date created, CONCAT(u.fname,' ',u.lname) author, max(fr.date) last_modified, count(fr.reply_id) num_replies FROM forum_topics ft JOIN forum_replies fr ON ft.topic_id=fr.topic_id JOIN users u ON ft.topic_by=u.user_id WHERE category_id=$cat_id GROUP BY ft.topic_id, ft.title, ft.date, CONCAT(u.fname,' ',u.lname);");

                echo $cat_name . ": " . $cat_desc;
                echo "<table><tbody><tr><th>Topic Title</th><th>Date Created</th><th>Latest Post</th><th>Author</th><th>Replies</th></tr>";
    
                if($data2 -> num_rows>0){
                    while($row2 = mysqli_fetch_array($data2,MYSQLI_NUM)){
                        $topic_name = $row2[1];
                        $topic_date = $row2[2];
                        $topic_author = $row2[3];
                        $topic_modified = $row2[4];
                        $topic_replies = $row2[5];
                        echo "<tr><td>" . $topic_name . "</td>";
                        echo "<td>" . $topic_date . "</td>";
                        echo "<td>" . $topic_modified . "</td>";
                        echo "<td>" . $topic_author . "</td>";
                        echo "<td>" . $topic_replies . "</td></tr>";
                    }
                }

                echo "</tbody></table>";
                echo "<br>";
            }
        }
    }
}
?>

<style>
a.topic:link{color:blue; text-decoration:underline;}
</style>

</div>

</body>
</html>