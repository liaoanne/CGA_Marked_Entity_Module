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
<?php include "templates/header.php"; ?>
</div>

<hr>

<!-- Displays the coursemanager nagivation sidebar -->
<div class=sidebar>
<?php include "templates/sidebar.php"; ?>
</div>

<!-- Displays the coursemanager main content -->
<div class=content>
<?php include "templates/announcements.php"; ?>
</div>

</body>
</html>
