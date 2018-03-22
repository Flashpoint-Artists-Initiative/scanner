<div class="container">

<footer>
  <hr>
  <?php echo HELP_LINE; ?>
</footer>

<nav class="navbar navbar-default navbar-fixed-bottom hidden-lg">
  <div class="container">
    <ul class="nav navbar-nav toolbar">
      <li><a href="index.php">
        <span class="glyphicon glyphicon-barcode"></span>
      </a></li>
      <?php if(is_admin()) : ?>
        <li><a href="log.php">
          <span class="glyphicon glyphicon-list-alt"></span>
        </a></li>
        <li><a href="import.php">
          <span class="glyphicon glyphicon-import"></span>
        </a></li>
        <li><a href="app-log.php">
          <span class="glyphicon glyphicon-tasks"></span>
        </a></li>
        <li><a href="search.php">
          <span class="glyphicon glyphicon-search"></span>
        </a></li>
        <li><a href="dashboard.php">
          <span class="glyphicon glyphicon-dashboard"></span>
        </a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

</div>

<audio src="assets/audio/adminhelp.ogg" id="errorSound"></audio>
<audio src="assets/audio/notice2.ogg" id="successSound"></audio>
<audio src="assets/audio/buzz-two.ogg" id="duplicateSound"></audio>
<script>var ticket_length = <?php echo TICKET_LENGTH; ?>;</script>
<script src="assets/js/jQuery.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
