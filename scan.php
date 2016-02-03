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
  echo json_encode(array('message'=>"No username specified", 'code'=>2));
  logEvent("NU","Tried to scan without a username");
  return;
}

if (isset($_POST['ticket'])){
  $ticket = new ticket();
  echo $ticket->scanTicket($_POST['ticket'],$_GET['user']);
}
