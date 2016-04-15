<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>

  <div class="page-heaer">
    <h1>Dashboard</h1>
  </div>

<?php
$db = new database();
$db->query("SELECT count(tbl_ticket.barcode) AS total,
(SELECT count(tbl_ticket.scanned) FROM tbl_ticket WHERE tbl_ticket.scanned = 1) AS scanned
FROM tbl_ticket;");
try {
  $db->execute();
} catch (Exception $e) {
  echo "Database error: ".$e->getMessage();
}
$stats = $db->single();
$percent = ($stats->scanned/$stats->total) * 100;

$db->query("SELECT count(tbl_log.id) AS invalid FROM scan_log WHERE tbl_log.what = 'IT';");
$db->execute();
$invalidCount = $db->single()->invalid;

$db->query("SELECT count(tbl_log.id) AS duplicates FROM scan_log WHERE tbl_log.what = 'AS';");
$db->execute();
$duplicates = $db->single()->duplicates;

$db->query("SELECT tbl_ticket.ticket,
COUNT(DISTINCT tbl_ticket.barcode) AS total,
SUM(CASE WHEN (tbl_ticket.scanned = 1) THEN 1 ELSE 0 END) AS num_scanned
FROM tbl_ticket
GROUP BY tbl_ticket.ticket");
$db->execute();
$typeBreakdown = $db->resultset();
?>

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Total Tickets</h3>
      </div>
      <div class="panel-body">
        <h1>
          <?php echo $stats->total;?>
        </h1>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Successful Scans</h3>
      </div>
      <div class="panel-body">
        <h1>
          <?php echo $stats->scanned;?>
        </h1>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title">Invalid Scans</h3>
      </div>
      <div class="panel-body">
        <h1>
          <?php echo $invalidCount;?>
        </h1>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title">Duplicate Scans</h3>
      </div>
      <div class="panel-body">
        <h1>
          <?php echo $duplicates;?>
        </h1>
      </div>
    </div>
  </div>
</div>

<h1>Overall Checkin Progress</h1>
<p>
  <div class="progress">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent;?>%;">
      <span class="sr-only"><?php echo $percent;?>% Scanned</span>
      <?php echo 100==$percent?'🎉🎉💯🎉🎉':''; ?>
    </div>
  </div>
</p>

<h1>Breakdown by ticket type</h1>

<table class="table table-condensed table-bordered table-striped">
  <thead>
    <tr>
      <th>Type</th>
      <th>Total Tickets</th>
      <th>Number Scanned</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($typeBreakdown as $type) :?>
    <tr>
      <th><?php echo $type->ticket;?></th>
      <td><?php echo $type->total; ?></td>
      <td><?php echo $type->num_scanned; ?></td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>
<?php require_once('footer.php'); ?>
