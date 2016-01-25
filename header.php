<?php require_once('inc/bootstrap.php'); ?>
<?php

if(isset($_GET['logout'])){
  $_SESSION['is_admin'] = FALSE;
  session_destroy();
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>
  <body>
    <?php require_once('nav.php'); ?>
  <div class="container">
