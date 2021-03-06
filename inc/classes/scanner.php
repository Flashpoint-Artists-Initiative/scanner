<?php

class scanner {
  public function getLogs($offset=0, $count=30) {
    $db = new database();
    $db->query("SELECT tbl_log.*
      FROM tbl_log
      ORDER BY tbl_log.timestamp DESC
      LIMIT $offset, $count");
    try {
      $db->execute();
    } catch (Exception $e) {
      return "Database error: ".$e->getMessage();
    }
    $logs = new stdclass();
    $logs->logs = $db->resultset();
    $count = $db->countRows('tbl_log');
    $logs->total = $count;
    return $logs;
  }

  public function logEvent($what, $data) {
    $defineWhat = array(
      "ST"=>"Scanned Ticket",
      "DS"=>"Duplicate scan",
      "IS"=>"Invalid scan (barcode not in database)",
      "NU"=>"No username specified"
    );
    $db = new database();
    if (isset($_GET['user'])) {
      $user = $user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
      $user = '';
    }
    $db = new database();
    $db->query("INSERT INTO tbl_log (who, what, data, timestamp, username) VALUES (?, ?, ?, NOW(), ?)");
    $db->bind(1,sha1($_SERVER['REMOTE_ADDR']));
    $db->bind(2,$what);
    $db->bind(3,$data);
    $db->bind(4,$user);
    try {
      $db->execute();
    } catch (Exception $e) {
      return "Database error: ".$e->getMessage();
    }
  }
}
