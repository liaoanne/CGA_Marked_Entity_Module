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
.button-link2{
    color: #333366;
    border: none;
    background-color: transparent;
    font-weight: bold;
    font-family: Times New Roman;
    font-size: 18px;
    padding-left: 0;
}
.button-link2:hover{
    background-color: #CCFFCC;
}
button a:hover{
    background-color: transparent;
}
.form-button{
    margin-block-end: 0em;
    display: inline;
}

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
  background-color: white;
}
#checkboxes label {
  display: block;
}
#checkboxes label:hover {
  background-color: #1e90ff;
}
pre{
  font-family: Times New Roman;
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