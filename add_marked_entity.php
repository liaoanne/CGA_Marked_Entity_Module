<?php
include "includes/head.php";

// Check if person does not have access
if ($_SESSION['role_id']>2){
  // Redirect user back to previous page
  header("location: index.php");
  exit;
}
?>

<!-- Displays the coursemanager main content -->
<div class=content>

<button><a href="marked_entities.php">Back</a></button>
<p></p>
  
<h1>Create a Marked Entity</h1>
<font color='red'>* Required field</font>
<form method=post action="includes/do_add_marked_entity.php">

<p><strong>Marked Entity Name:</strong><font color='red'> *</font><br>
<input type="text" name="marked_entity_name" size=40 maxlength=150 required></p>

<div><strong>Assign For:</strong><font color='red'> *</font><br>
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

<p><strong>Marked Entity Type:</strong><font color='red'> *</font><br>
<select name="type" required>
  <option selected disabled value="">Select an option</option>
  <option value="asg">Assignment</option>
  <option value="proj">Project</option>
  <option value="other">Other</option>
</select></p>

<p><strong>Set Due Date:</strong><font color='red'> *</font><br>
<input type='date' name='due_date' required></p>

<p><strong>Description:</strong><br>
<textarea name="desc" rows=8 cols=40 wrap=virtual></textarea></p>

<p><strong>Add file:</strong><br>
<!-- TODO: ADD UPLOAD FUNCTION --></p>

<p><button type="submit" name="submit">Create Marked Entity</button></p>
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