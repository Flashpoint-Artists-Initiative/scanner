<?php require_once('header.php'); ?>

<?php

$db = new database();
$db->query("INSERT INTO tbl_ticket (barcode, firstname, scanned) VALUES(?,?, 0)");

$i = 0;
while ($i < 100) {
  $ticket = substr(sha1(rand(0,1000) . date('u')),0,11);
  $name = substr(sha1(rand(0,1000)*100 . date('u')),0,11);
  $db->bind(1,$ticket);
  $db->bind(2,$name);
  $db->execute();
  $i++;
}

echo "<div class='alert alert-success'>Added $i test tickets</div>";


var_dump($rows = $db->countRows('scan_ticket'));
