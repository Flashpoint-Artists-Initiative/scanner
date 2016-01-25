<?php require_once('header.php'); ?>
    <div class="jumbotron">
      <h1>Ready to scan</h1>
      <input id="username" name="username" placeholder="Who are you" />
      <input id="ticket" name="ticket" placeholder="Barcode" />
    </div>
    <pre class="debug">
    </pre>
  </div>
  <audio src="assets/audio/adminhelp.ogg" id="errorSound"></audio>
  <audio src="assets/audio/ping.ogg" id="successSound"></audio>
  <script>var ticket_length = <?php echo TICKET_LENGTH; ?>;</script>
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>
  </body>
</html>