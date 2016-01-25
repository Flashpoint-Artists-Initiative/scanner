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
  $db = new database();
  $db->query("SELECT * FROM tbl_ticket WHERE $col = ?");
  $db->bind(1, $_POST['ticket']);
  try {
    $db->execute();
  } catch (Exception $e) {
    http_response_code(500);
    echo "Database error: ".$e->getMessage();
  }
  $result = $db->single();
  if(!$result){
    echo json_encode(array('message'=>"Ticket ID invalid", 'code'=>0));
    logEvent("IT","Invalid ticket id: ".$_POST['ticket']);
    return;
  }
  if ($result->scanned) {
    echo json_encode(array('message'=>"This ticket has been used", 'code'=>1, 'data'=>$result));
    logEvent("AS","Ticket already scanned: $result->barcode");
    if (DEBUG) {
      $db->query("UPDATE tbl_ticket SET scanned = 0");
      $db->execute();
    }
    return;
  }
  $db->query("UPDATE tbl_ticket
    SET scanned = 1, scanned_at = NOW(), ip_addr = ?, scanned_by = ?
    WHERE $col = ?");
  $db->bind(1,sha1($_SERVER['REMOTE_ADDR']));
  $db->bind(2, $_GET['user']);
  $db->bind(3, $_POST['ticket']);
  try {
    $db->execute();
  } catch (Exception $e) {
    http_response_code(500);
    echo "Database error: ".$e->getMessage();
  }
  http_response_code(200);
  logEvent('ST',"Scanned a ticket: $result->barcode");
  echo json_encode(array('message'=>"$result->firstname is cleared for entry", 'code'=>3));
  return;
}
