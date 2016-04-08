<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>

  <div class="page-header">
    <h1>Scanned ticket log</h1>
  </div>

  <?php
  $limit = 30;

  if(isset($_GET['page'])){
    $page = $_GET['page'];
    $offset = $page * $limit;
  } else {
    $page = 0;
    $offset = 0;
  }

  $ticket = new ticket();
  $logs = $ticket->getLogs($offset, $limit);

  $rows = $logs->total;
  $pages = ceil($rows/$limit);

  $i = 0;

  $nextpage = $page + 1;
  $prevpage = $page - 1;

  $logs = $logs->logs;

  if ($pages > 1) {
  ?>

  <ul class='pagination'>
    <?php if ($prevpage >= 0): ?>
    <li><a href="?page=<?php echo $prevpage;?>">&laquo;</a></li>
    <?php endif; ?>
    <?php while ($i<=$pages-1) :?>
      <?php if ($i == $page) :?>
        <li class='active'>
          <a href="?page=<?php echo $i;?>">
            <?php echo $i+1;?>
          </a>
        </li>
      <?php else :?>
        <li>
          <a href="?page=<?php echo $i;?>">
            <?php echo $i+1;?>
          </a>
        </li>
      <?php endif;?>
    <?php $i++; endwhile;?>
    <?php if ($nextpage < $pages) : ?>
    <li><a href="?page=<?php echo $nextpage;?>">&raquo;</a></li>
    <?php endif;?>
  </ul>

<?php } ?>
<div class="table-responsive">
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <tr>
        <th>Barcode</th>
        <th>Name</th>
        <th>When</th>
        <th>Who</th>
        <th>IP</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($logs as $log) : ?>
        <tr>
          <td><code><?php echo $log->barcode;?></code></td>
          <td><?php echo $log->firstname. ' '.$log->lastname;?></td>
          <td><?php echo $log->scanned_at;?></td>
          <td><?php echo $log->scanned_by;?></td>
          <td><?php echo $log->ip_addr;?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php require_once('footer.php'); ?>
