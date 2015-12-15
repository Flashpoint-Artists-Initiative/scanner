<?php

require_once('inc/config.php');

if (empty($_GET['user'])){
  echo json_encode(array('msg'=>"No username specified", 'code'=>0));
  return;
}

if (isset($_POST['ticket_id'])){
  $db = new database();
  $db->query("SELECT * FROM tbl_ticket WHERE id = ?");
  $db->bind(1, $_POST['ticket_id']);
  try {
    $db->execute();
  } catch (Exception $e) {
    http_response_code(500);
    echo "Database error: ".$e->getMessage();
  }
  $result = $db->single();
  if(!$result){
    echo json_encode(array('msg'=>"Ticket ID invalid", 'code'=>0));
    return;
  }
  if ($result->checked_in) {
    echo json_encode(array('msg'=>"Ticket has been used", 'code'=>0));
    return;
  }
  $db->query("UPDATE tbl_ticket
    SET checked_in = 1, timestamp = NOW(), ip_addr = ?, user = ?
    WHERE id = ?");
  $db->bind(1,sha1($_SERVER['REMOTE_ADDR']));
  $db->bind(2, $_GET['user']);
  $db->bind(3, $_POST['ticket_id']);
  try {
    $db->execute();
  } catch (Exception $e) {
    http_response_code(500);
    echo "Database error: ".$e->getMessage();
  }
  http_response_code(200);
  echo json_encode(array('msg'=>"$result->name is cleared for entry", 'code'=>1));
  return;
}
