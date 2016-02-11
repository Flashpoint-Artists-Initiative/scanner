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
    $scanner = new scanner();
    $tempcode = $barcode;

    //No username specified. Aborting
    if (!$user){
      $scanner->logEvent("NU","Tried to scan $barcode without a username");
      return json_encode(array('message'=>"User not specified", 'code'=>2));
    }

    //Scanned barcode did not match our sanitization filters.
    $barcode = $this->sanitizeBarcode($barcode);
    if (!$barcode) {
      $scanner->logEvent("IS","Invalid scan. Barcode: ".$tempcode);
      return json_encode(array('message'=>"Ticket ID invalid", 'code'=>0));
    }

    //Barcode was scanned correctly. Perform the database lookup
    $col = TICKET_COL;
    $db = new database();
    $db->query("SELECT * FROM tbl_ticket WHERE $col = ?");
    $db->bind(1, $barcode);
    try {
      $db->execute();
    } catch (Exception $e) {
      return "Database error: ".$e->getMessage();
    }
    $result = $db->single();

    //If the barcode didn't match anything in our database, throw an error
    if(!$result){
      $scanner->logEvent("IS","Invalid ticket id: ".$barcode);
      return json_encode(array('message'=>"Ticket ID invalid", 'code'=>0));
    }

    //If the barcode is in the database, but is already marked as scanned,
    //throw an error AND send information about the ticket back
    if ($result->scanned) {
      $scanner->logEvent("DS","Ticket already scanned: $result->barcode");

      //Under debug conditions, mark this ticket as NOT SCANNED
      if (DEBUG) {
        $db->query("UPDATE tbl_ticket SET scanned = 0 WHERE $col = ?");
        $db->bind(1,$barcode);
        $db->execute();
      }
      return json_encode(array('message'=>"This ticket has already been scanned", 'code'=>1, 'data'=>$result));
    }

    //Otherwise, mark the ticket as scanned, set when it was scanned and the
    //username of whoever scanned it.
    $db->query("UPDATE tbl_ticket
      SET scanned = 1, scanned_at = NOW(), ip_addr = ?, scanned_by = ?
      WHERE $col = ?");
    $db->bind(1,sha1($_SERVER['REMOTE_ADDR']));
    $db->bind(2, $user);
    $db->bind(3, $barcode);
    try {
      $db->execute();
    } catch (Exception $e) {
      return "Database error: ".$e->getMessage();
    }
    $scanner->logEvent('ST',"Scanned a ticket: $result->barcode");
    return json_encode(array('message'=>"$result->firstname is cleared for entry", 'code'=>3));
  }

  public function importTickets($tickets){
    $db = new database();
    $scanner = new scanner();

    //Split our bundle of tickets into separate arrays
    $tickets = explode("\n",$tickets);

    //Prep the query
    $db->query("INSERT INTO tbl_ticket (firstname, barcode, scanned) VALUES (?,?, 0)");
    $i = 0; //Number of attempted imports
    $f = 0; //Number of failures (invalid barcodes)
    foreach ($tickets as $ticket) {
      $i++; //Increse attempt count
      $ticket = explode(',',$ticket); //kaboom
      $barcode = $this->sanitizeBarcode($ticket[1]);
      //Check if the barcode fits whatever pattern we're using.

      $invalidBarcodes = ''; //Empty string of invalid barcodes
      if (!$barcode){
        $invalidBarcodes.=$ticket[1].', ';
        $f++; //Failed import increase
        $i--; //Decrease attempt count
      } else {
        $db->bind(1,$ticket[0]);
        $db->bind(2,$barcode);
        try {
          $db->execute();
        } catch (Exception $e) {
          $f++; //Same thing here. This catches duplicate barcodes
          $i--;
        }
      }
    }
    $scanner->logEvent("IT","Imported $i tickets");
    return json_encode(array('message'=>"Imported $i tickets. $f tickets were invalid or duplicates and ignored.", 'code'=>3));
  }

  public function getLogs($offset=0, $count=30) {
    $db = new database();
    $db->query("SELECT tbl_ticket.*
      FROM tbl_ticket
      WHERE tbl_ticket.scanned = 1
      ORDER BY tbl_ticket.scanned_at DESC
      LIMIT $offset, $count");
    try {
      $db->execute();
    } catch (Exception $e) {
      return "Database error: ".$e->getMessage();
    }
    $logs = new stdclass();
    $logs->logs = $db->resultset();
    $db->query("SELECT COUNT(tbl_ticket.barcode) AS count FROM tbl_ticket WHERE scanned = 1");
    $db->execute();
    $logs->total = $db->single()->count;
    return $logs;
  }

}
