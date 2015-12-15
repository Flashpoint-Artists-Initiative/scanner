<?php

require_once('inc/config.php');

$offset = 0;
$limit = 30;

$db = new database();
$db->query("SELECT * FROM tbl_ticket
  WHERE tbl_ticket.checked_in = 1
  ORDER BY tbl_ticket.timestamp DESC
  LIMIT $offset, $limit");
try {
  $db->execute();
} catch (Exception $e) {
  echo "Database error: ".$e->getMessage();
}
$logs = $db->resultset(); ?>
<table>
  <thead>
    <tr>
      <td>Ticket #</td>
      <td>Name</td>
      <td>When</td>
      <td>Who</td>
      <td>IP</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($logs as $log) : ?>
      <tr>
        <td><?php echo $log->id;?></td>
        <td><?php echo $log->name;?></td>
        <td><?php echo timestamp($log->timestamp);?></td>
        <td><?php echo $log->user;?></td>
        <td><?php echo $log->ip_addr;?></td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>

<?php

$db->query("SELECT count(tbl_ticket.ID) AS total,
(SELECT count(tbl_ticket.checked_in) FROM tbl_ticket WHERE tbl_ticket.checked_in = 1) AS scanned
FROM tbl_ticket;");
try {
  $db->execute();
} catch (Exception $e) {
  echo "Database error: ".$e->getMessage();
}

$stats = $db->single();?>

<p>Out of <?php echo $stats->total;?> tickets, <?php echo $stats->scanned;?> have been successfully scanned</p>
