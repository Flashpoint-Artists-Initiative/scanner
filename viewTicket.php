<?php require_once('header.php'); ?>

<?php if (isset($_GET['barcode'])) :
  $ticket = new ticket();
  $ticket = $ticket->getByBarcode($_GET['barcode']);
  else:
    die("No barcode specified");
  endif; ?>

<ol class="breadcrumb">
  <li><a href="index.php">Scan</a></li>
  <li><a href="search.php">Search</a></li>
  <li class="active">#  <?php echo $ticket->barcode;?></li>
</ol>

<div class="page-header">
  <h1>Ticket <code><?php echo $ticket->barcode;?></code>
  <?php if (!$ticket->scanned) :?>
    <p class="pull-right">
      <?php echo $ticket->scanlink;?>
    </p>
  <?php endif;?>
  </h1>
</div>

<h2>
  <small>Name</small>
  <?php echo $ticket->firstname.' '.$ticket->lastname;?>
</h2>
<h2>
  <small>Email</small>
  <?php echo $ticket->order_email;?>
</h2>
<h2>
  <small>Order number</small>
  <?php echo $ticket->Order;?>
</h2>
<h2><small>Ticket Type</small>
<?php echo $ticket->ticket;?>
</h2>
<h2>
  <small>Status</small>
  <?php echo $ticket->fullStatus;?>
</h2>
<?php if ($ticket->scanned): ?>
  <hr>
  <h2>
    <small>Scanned at</small>
    <?php echo $ticket->scanned_at;?>
  </h2>
  <h2>
    <small>Scanned by</small>
    <?php echo $ticket->scanned_by;?>
  </h2>
<?php endif;?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}
?>




<?php require_once('footer.php'); ?>
