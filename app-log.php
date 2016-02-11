<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>

  <div class="page-heaer">
    <h1>Application logs</h1>
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

  $scanner = new scanner();
  $logs = $scanner->getLogs($offset, $limit);

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
  <table class="table table-condensed table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Who</th>
        <th>Username</th>
        <th>What</th>
        <th>Data</th>
        <th>When</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($logs as $log) : ?>
        <?php if ($log->what == 'ST') : ?>
        <tr class="success">
        <?php elseif ($log->what == 'IT') :?>
        <tr class="danger">
        <?php elseif ($log->what == 'AS') :?>
        <tr class="warning">
        <?php else : ?>
        <tr>
        <?php endif; ?>
          <td><?php echo $log->id;?></td>
          <td><?php echo $log->who;?></td>
          <td><?php echo $log->username;?></td>
          <td><?php echo $log->what?></td>
          <td><?php echo $log->data;?></td>
          <td><?php echo timestamp($log->timestamp);?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php require_once('footer.php'); ?>
