<?php

require_once('inc/bootstrap.php');

$scanner = new scanner();
$ticket = new ticket();

$returnCodes = array(
  0 => 'Invalid Ticket ID',
  1 => 'Duplicate Scan',
  2 => 'Missing username',
  3 => 'Success (cleared to enter)'
);

$col = TICKET_COL;

$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
$barcode = $ticket->sanitizeBarcode(filter_input(INPUT_POST, 'ticket', FILTER_SANITIZE_SPECIAL_CHARS));

if (!$user){
  $return = json_encode(array('message'=>"No username specified", 'code'=>2));
  $scanner->logEvent("NU","Tried to scan without a username");
  return;
}

if ($barcode){
  $return = $ticket->scanTicket($barcode,$user);
} else {
  $return = json_encode(array('message'=>"Barcode cannot be empty", 'code'=>2));
}


if (isset($_GET['barcode']) && is_admin()){
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