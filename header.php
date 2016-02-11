<?php require_once('inc/bootstrap.php'); ?>

<?php
if(isset($_GET['logout'])){
  $_SESSION['is_admin'] = FALSE;
  session_destroy();
}

if(isset($_GET['login'])){
  if(isset($_POST['admin_pw'])){
    if(!password_verify($_POST['admin_pw'],password_hash(ADMIN_PASS,PASSWORD_DEFAULT))) {
      echo "<div class='alert alert-danger'>Password incorrect</div>";
    } else {
      $_SESSION['is_admin'] = TRUE;
    }
  }
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Scanner</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Scan</a></li>
            <?php if(is_admin()) : ?>
              <li><a href="log.php">Ticket Logs</a></li>
              <li><a href="import.php">Import Tickets</a></li>
              <li><a href="app-log.php">Application Logs</a></li>
              <li><a href="dashboard.php">Dashboard</a></li>
            <?php endif; ?>
          </ul>

          <?php
          if(DEBUG && is_admin()): ?>
            <p class='navbar-text'>
              <span class='label label-danger'>DEBUG ON</span>
            </p>
          <?php endif; ?>

          <p class="navbar-text navbar-right">
          <?php if (is_admin()):?>
          <a href='?logout'>Logout</a>
          <?php else: require_once('admin-pw-form.php'); endif;?>
         </p>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  <div class="container">
