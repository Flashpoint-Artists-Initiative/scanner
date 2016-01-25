<?php require_once('header.php'); ?>
    <div class="jumbotron">
      <h1>Ready to scan</h1>
      <input id="username" name="username" placeholder="Who are you" />
      <input id="ticket" name="ticket" placeholder="Barcode" />
    </div>
    <div class="panel panel-default hide" id="ticketInfo">
      <div class="panel-heading">
        <h3 class="panel-title">Duplicate Ticket Info</h3>
      </div>
      <div class="panel-body">

      </div>
    </div>
  </div>
  <audio src="assets/audio/adminhelp.ogg" id="errorSound"></audio>
  <audio src="assets/audio/ping.ogg" id="successSound"></audio>
  <script>var ticket_length = <?php echo TICKET_LENGTH; ?>;</script>
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>
  </body>
</html>
