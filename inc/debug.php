<?php
require_once('config.php');
require_once('tempest.php');

$db = new database();
$db->query("INSERT INTO tbl_ticket(id, name)
VALUES (?, ?)");

$i = 1234567890;

while ($i < 1234568890) {
  $codename = '';
  $buttchance = floor(rand(0,20));
  if ($buttchance == 1) {
    $codename.="butt";
  } elseif ($buttchance == 2) {
    $codename.="anus";
  } else {
    $codename.='';
  }

  $codename.= ucfirst(pick($PGPWordList))." ".ucfirst(pick($nouns));
  $db->bind(1,$i);
  $db->bind(2,$codename);
  try {
    $db->execute();
  } catch (Exception $e) {
    echo "Database error: ".$e->getMessage();
  }
  $i++;
}
