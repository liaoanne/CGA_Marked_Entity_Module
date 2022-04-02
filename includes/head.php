<?php
session_start();
include "./includes/config.php";

// Check if the user is not logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login_page.php");
    exit;
}
?>

<style>
.sidebar{
    width:20%;
    float:left;
}
.content{
    width:78%; 
    margin-top:-8px; 
    padding:1%; 
    float:right;
    background-color:rgb(250, 240, 230);
}
.content table, .content th, .content td{
    border:1px solid;
}
.content th{
    background-color:pink;
}
.button-link{
   background-color: transparent;
   border: none;
   color: blue;
   text-decoration: underline;
}
.button-link:hover{
   background-color: transparent;
   text-decoration: none;
}
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