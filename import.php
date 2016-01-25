<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>

<?php

if (isset($_GET['import'])) {
  $data = $_POST['data'];
  $data = explode("\n",$data);
  $db = new database();
  $db->query("INSERT INTO tbl_ticket (firstname, barcode, scanned) VALUES (?,?, 0)");
  $i = 0;
  foreach ($data as $ticket) {
    $ticket = explode(',',$ticket);
    $db->bind(1,$ticket[0]);
    $db->bind(2,$ticket[1]);
    $db->execute();
    $i++;
  }
  echo "<div class='alert alert-success'>Imported $i tickets</div>";

  logEvent('AT',"Imported $i tickets");
}?>

<div class="page-header">
  <h1>Import tickets</h1>
</div>

<p>Paste your ticket data here, separated by a comma. One barcode+name pair per line.
  <pre>firstname,barcode</pre>
</p>

<form class="form" action="import.php?import" method="POST">
  <textarea class="form-control" rows="15" name="data"></textarea>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
