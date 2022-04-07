<?php
include "includes/head.php";

// Check if person does not have access
if(!isset($_SERVER['HTTP_REFERER'])){
  // Redirect user back to previous page
  header("location: marked_entities.php");
  exit;
}

// Get marked entity data
$data = $link->query("SELECT * FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id']);
if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $section_id = $row[1];
        $name = $row[2];
        $post_date = $row[3];
        $due_date = $row[4];
        $type = $row[5];
        $work_type = $row[6];
        $viewable_to = $row[7];
        $file = $row[8];
        $desc = $row[9];
    }
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="entity_summary.php">Back</a></button>
<p></p>

<h1>Edit <?php echo $_SESSION['entity_name']?></h1>
<font color='red'>* Required field</font>
<form method=post action="includes/do_edit_marked_entity.php">

<p><strong>Marked Entity Name:</strong><br>
<input type="text" name="marked_entity_name" size=40 maxlength=150 value="<?php echo $_SESSION['entity_name']?>"></p>

<div><strong>Assign For (please check all the boxes that apply):</strong><font color='red'> *</font><br>
  <div class="multiselect">
      <div class="selectBox" onclick="showCheckboxes()">
      <select>
        <option>Select an option</option>
      </select>
      <div class="overSelect"></div>
      </div>
      <div id="checkboxes">
      <label for="all"><input type="checkbox" name="view[]" value=",all,"/>Individual</label>
      <?php
      // Add group checkboxes to select from
      $data = $link->query("SELECT group_id,name FROM rtc55314.groups WHERE section_id=" . $_SESSION['section_id']);
      if($data -> num_rows>0){
        while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
          // Display the categories available
          $group_id = $row[0];
          $group_name = $row[1];
          echo "<label for='" . $group_id . "'><input type='checkbox' name='view[]' value='" . $group_id . "'/>" . $group_name . "</label>";
        }
      }
      ?>
      </div>
  </div>
</div>

<p><strong>Marked Entity Type:</strong><br>
<select name="type">
  <option selected disabled value="">Select an option</option>
  <?php
  if($type == 'asg'){
    echo "<option selected='selected' value='asg'>Assignment</option>";
    echo "<option value='proj'>Project</option>";
    echo "<option value='other'>Other</option>";
  }
  elseif($type == 'proj'){
    echo "<option value='asg'>Assignment</option>";
    echo "<option selected='selected' value='proj'>Project</option>";
    echo "<option value='other'>Other</option>";
  }
  else{
    echo "<option value='asg'>Assignment</option>";
    echo "<option value='proj'>Project</option>";
    echo "<option selected='selected' value='other'>Other</option>";
  }
  ?>
</select></p>

<p><strong>Set Due Date:</strong><br>
<input type='date' name='due_date' value='<?php echo $due_date?>'></p>

<p><strong>Description:</strong><br>
<textarea name="desc" rows=8 cols=40 wrap=virtual><?php echo $desc?></textarea></p>

<p><strong>Add file (replaces if already an existing file):</strong><br>
<input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf,.zip,.PDF,.ZIP"></p>

<p><button type="submit" name="submit">Edit Marked Entity</button></p>
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

<script>
var expanded = false;
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>