<?php

class ticket {

  public function __construct(){

  }

  public function sanitizeBarcode($barcode) {
    if (!STRICT_CHECKING) {
      return trim($barcode);
    }
    $barcode = trim($barcode);
    if (TICKET_LENGTH != strlen($barcode)){
      return FALSE;
    }
    if (preg_match(TICKET_PREG,$barcode)){
      $barcode = filter_var($barcode,
      FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
      return $barcode;
    }
    return FALSE;
  }

  public function scanTicket($barcode=null,$user=null) {
    $tempcode = $barcode;
    if (!$user){
      logEvent("NU","Tried to scan $barcode without a username");
      return json_encode(array('message'=>"User not specified", 'code'=>2));
    }
    $barcode = $this->sanitizeBarcode($barcode);
    if (!$barcode) {
      logEvent("IT","Invalid ticket id: ".$tempcode);
      return json_encode(array('message'=>"Ticket ID invalid", 'code'=>0));
    }
    $col = TICKET_COL;
    $db = new database();
    $db->query("SELECT * FROM tbl_ticket WHERE $col = ?");
    $db->bind(1, $barcode);
    try {
      $db->execute();
    } catch (Exception $e) {
      http_response_code(500);
      return "Database error: ".$e->getMessage();
    }
    $result = $db->single();
    if(!$result){
      logEvent("IT","Invalid ticket id: ".$barcode);
      return json_encode(array('message'=>"Ticket ID invalid", 'code'=>0));
    }
    if ($result->scanned) {
      logEvent("AS","Ticket already scanned: $result->barcode");
      if (DEBUG) {
        $db->query("UPDATE tbl_ticket SET scanned = 0");
        $db->execute();
      }
      return json_encode(array('message'=>"This ticket has already been scanned", 'code'=>1, 'data'=>$result));
    }
    $db->query("UPDATE tbl_ticket
      SET scanned = 1, scanned_at = NOW(), ip_addr = ?, scanned_by = ?
      WHERE $col = ?");
    $db->bind(1,sha1($_SERVER['REMOTE_ADDR']));
    $db->bind(2, $user);
    $db->bind(3, $barcode);
    try {
      $db->execute();
    } catch (Exception $e) {
      http_response_code(500);
      return "Database error: ".$e->getMessage();
    }
    http_response_code(200);
    logEvent('ST',"Scanned a ticket: $result->barcode");
    return json_encode(array('message'=>"$result->firstname is cleared for entry", 'code'=>3));
  }

  public function importTickets($tickets){
    $tickets = explode("\n",$tickets);

    $db = new database();
    $db->query("INSERT INTO tbl_ticket (firstname, barcode, scanned) VALUES (?,?, 0)");
    $i = 0;
    $f = 0;
    foreach ($tickets as $ticket) {
      $i++;
      $ticket = explode(',',$ticket);
      $barcode = $this->sanitizeBarcode($ticket[1]);
      $invalidBarcodes = '';
      if (!$barcode){
        $invalidBarcodes.=$ticket[1].', ';
        $f++;
        $i--;
      } else {
        $db->bind(1,$ticket[0]);
        $db->bind(2,$barcode);
        try {
          $db->execute();
        } catch (Exception $e) {
          $f++;
          $i--;
        }
      }
    }
    logEvent("AT","Imported $i tickets");
    return json_encode(array('message'=>"Imported $i tickets. $f tickets were invalid or duplicates and ignored.", 'code'=>3));
  }

}
