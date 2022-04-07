<?php
include "includes/head.php";
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

<h1>Add a File</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_add_file_to_entity.php" enctype="multipart/form-data">

<p><strong>Topic Category:</strong><font color='red'> *</font><br>
<select name="category" required>
	<option selected disabled value="">Please choose a category</option>
  <?php
  // Display categories available to post to for admin, instructor, and TA
  if($_SESSION['role_id']< 4){
    $data = $link->query("SELECT category_id, name FROM forum_categories WHERE marked_entity_id=" . $_SESSION['entity_id']);
    if($data -> num_rows>0){
      while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        // Display the categories available
        $cat_id = $row[0];
        $cat_name = $row[1];
        echo "<option value='" . $cat_id . "'>" . $cat_name . "</option>";
      }
    }
  }
  // Display categories available to post to for students
  else{
    // Get the groups that the student belong to
    $groups = ['all'];
    $data = $link->query("SELECT group_id FROM group_users WHERE user_id=" . $_SESSION['id'] . " AND left_group_date is null");
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
              echo "<option value='" . $cat_id . "'>" . $cat_name . "</option>";
          }
      }
    }
  }
	?>
</select>

<p><font color='red'> *</font>
<input type="file" name="fileToUpload" id="fileToUpload" required accept=".pdf,.zip,.PDF,.ZIP"></p>
<p><small>Accepted formats: zip/pdf</small></p>

<button type="submit" name="submit">Upload File</button>
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