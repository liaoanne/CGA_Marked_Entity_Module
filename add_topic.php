<?php
session_start();
include "./includes/config.php";
?>

<style>
.sidebar{width:20%; float:left;}
.content{width:78%; margin-top:-8px; padding:1%; float:right;background-color:rgb(250, 240, 230);}
</style>

<html>
<head>
<Title>CGA - The CrsMgr Group-work Assistant</title>
</head>

<body>

<!-- Displays the coursemanager header -->
<div class=header>
<?php
include "templates/header.php";
?>
</div>

<hr>

<!-- Displays the coursemanager nagivation sidebar -->
<div class=sidebar>
<?php
include "templates/sidebar.php";
?>
</div>

<!-- Displays the coursemanager main content -->
<div class=content>
<h1>Add a Topic</h1>
<font color='red'>* Required field</font>
<form method=post action="includes/do_add_topic.php">

<p><strong>Topic Title:</strong><font color='red'> *</font><br>
<input type="text" name="topic_title" size=40 maxlength=150>

<p><strong>Topic Category:</strong><font color='red'> *</font><br>
<select name="topic_category">
	<option value="">Please choose a category</option>
	<option value="other">Other</option>
</select>

<p><strong>Viewable To:</strong><font color='red'> *</font><br>
<div class="multiselect">
    <div class="selectBox" onclick="showCheckboxes()">
		<select>
			<option>Select an option</option>
		</select>
		<div class="overSelect"></div>
    </div>
    <div id="checkboxes">
		<label for="all"><input type="checkbox" name="view[]" value="1" id="all" />All</label>
		<label for="ta"><input type="checkbox" name="view[]" value="2" id="ta" />TAs</label>
		<label for="three"><input type="checkbox" name="view[]" value="3" id="three" />Third checkbox</label>
    </div>
</div>

<p><strong>Topic Description:</strong><font color='red'> *</font><br>
<textarea name="topic_text" rows=8 cols=40 wrap=virtual></textarea>
<p><button type="submit" name="submit">Add Topic</button></p>

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

<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
</style>

</form>
</div>

</body>
</html>