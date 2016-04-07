<?php

require_once('inc/bootstrap.php');

$returnCodes = array(
  0 => 'Invalid Ticket ID',
  1 => 'Duplicate Scan',
  2 => 'Missing username',
  3 => 'Success (cleared to enter)'
);

$col = TICKET_COL;

if (empty($_GET['user'])){
  $return = json_encode(array('message'=>"No username specified", 'code'=>2));
  logEvent("NU","Tried to scan without a username");
  return;
}

if (isset($_POST['ticket'])){
  $ticket = new ticket();
  $return = $ticket->scanTicket($_POST['ticket'],$_GET['user']);
}

if (isset($_GET['barcode']) && is_admin()){
  $ticket = new ticket();
  $return = $ticket->scanTicket($_GET['barcode'],$_GET['user']);
}

if (isset($_GET['format'])) :?>
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
<?php require_once('footer.php'); ?>

<script>success(<?php echo $return;?>);</script>

<?php else : 

echo $return;

endif; ?>