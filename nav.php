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
      <p class="navbar-text navbar-right">
      <?php

      if(!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        if(isset($_POST['admin_pw'])){
          if($_POST['admin_pw'] && isset($_GET['login'])){
            if(!password_verify($_POST['admin_pw'],password_hash(ADMIN_PASS,PASSWORD_DEFAULT))) {
              echo "Password incorrect";
            } else {
              $_SESSION['is_admin'] = TRUE;
              echo "<a href='?logout'>Logout</a>";
            }
          } else {
            require_once('admin-pw-form.php');
          }
        } else {
          require_once('admin-pw-form.php');
        }
      } else {
        echo "<a href='?logout'>Logout</a>";
      }
      ?>
     </p>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
