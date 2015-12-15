<?php

require_once('inc/config.php');

if (isset($_POST['ticket_id'])){
  $db = new database();
  $db->query("SELECT * FROM tbl_ticket WHERE id = ? AND checked_in = 0");
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
  $db->query("UPDATE tbl_ticket SET checked_in = 1, timestamp = NOW() WHERE id = ?");
  $db->bind(1, $_POST['ticket_id']);
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
