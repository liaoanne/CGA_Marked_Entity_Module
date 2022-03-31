<?php
include "includes/head.php";
?>

<!-- Displays the coursemanager main content -->
<div class=content>
<h1>Add a Topic</h1>
<font color='red'>* Required field</font>

<form method=post action="includes/do_add_topic.php">

<p><strong>Topic Title:</strong><font color='red'> *</font><br>
<input type="text" name="title" size=40 maxlength=150 required>

<p><strong>Topic Category:</strong><font color='red'> *</font><br>
<select name="category" required>
	<option selected disabled value="">Please choose a category</option>
  <?php
	$data = $link->query("SELECT category_id,name FROM forum_categories");
	if($data -> num_rows>0){
		while($row = mysqli_fetch_array($data,MYSQLI_NUM))
		{
			// Display the categories available
			$cat_id = $row[0];
      $cat_name = $row[1];
			echo "<option value='" . $cat_id . "'>" . $cat_name . "</option>";
		}
	}
	?>
</select>

<p><strong>Post Text:</strong><font color='red'> *</font><br>
<textarea name="text" rows=8 cols=40 wrap=virtual required></textarea>
<p><button type="submit" name="submit">Add Topic</button></p>
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