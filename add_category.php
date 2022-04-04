<?php
include "includes/head.php";

// Check if person does not have access
if ($_SESSION['role_id']>2){
  // Redirect user back to previous page
  header("location: index.php");
  exit;
}
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

<h1>Create a Discussion Category</h1>
<font color='red'>* Required field</font>
<form method=post action="includes/do_add_category.php">

<p><strong>Category Name:</strong><font color='red'> *</font><br>
<input type="text" name="category_name" size=40 maxlength=150 required>

<div><strong>Viewable To:</strong><font color='red'> *</font><br>
  <div class="multiselect">
      <div class="selectBox" onclick="showCheckboxes()">
      <select>
        <option>Select an option</option>
      </select>
      <div class="overSelect"></div>
      </div>
      <div id="checkboxes">
      <?php
      // Check viewable access
      $data = $link->query("SELECT viewable_to FROM marked_entities WHERE marked_entity_id=" . $_SESSION['entity_id']);
      if($data -> num_rows>0){
        $entity_data = $data->fetch_assoc();
        $view_string = $entity_data['viewable_to'];
        $view_string = substr($view_string, 1, -1);
        //$view_array = explode(',', $view_string);
      }
      // Add group checkboxes to select from
        $data = $link->query("SELECT group_id,name FROM rtc55314.groups WHERE group_id IN ($view_string)");
        if($data -> num_rows>0){
          while($row = mysqli_fetch_array($data,MYSQLI_NUM))
          {
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

<p><button type="submit" name="submit">Create Category</button></p>
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