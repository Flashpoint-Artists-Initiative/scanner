<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>

<?php

if (isset($_GET['import'])) {
  $ticket = new ticket();
  echo $ticket->importTickets($_POST['data']);
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

<?php require_once('footer.php'); ?>
