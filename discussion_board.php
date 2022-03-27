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
<h1>Discussion Boards</h1>
<p>
<hr>
<p>
<a href="add_category.php">Create a Category</a>
<p>
<a href="add_topic.php">Create a Topic</a>
<p>
<hr>
<p>
<b>Category: Other</b>
<br>
<br>
<table border='1'>
    <tbody>
        <tr bgcolor='pink'>
            <th>Topic</th>
            <th>Post</th>
            <th>Author</th>
            <th>Post Time</th>
            <th>Replies</th>
        </tr><tr>
            <th><a class='topic' href="forum/posts">Quiz system is broken</a></th>
            <th>The quiz system is always crashing and I want to apologize. My course manager is really bad and I promise that in the future I will discontinue the system and move to Moodle. Thank you.</th>
            <th>Desai</th>
            <th>Never</th>
            <th>100</th>
        </tr>
    </tbody>
</table>

<style>
a.topic:link{color:blue; text-decoration:underline;}
</style>

</div>

</body>
</html>