<?php require_once('header.php'); ?>

<?php

if(!is_admin()) {
  echo "<div class='alert alert-danger'>You must be an administrator to view this page!</div>";
  die();
}

if (isset($_GET['searchby'])){
  $ticket = new ticket();
  switch ($_GET['searchby']) {
    default:
      return;
    break;

    case 'barcode':
      $tickets = $ticket->searchTickets('barcode',$_POST['barcode']);
    break;

    case 'name':
      $tickets = $ticket->searchTickets('name',$_POST['name']);
    break;

    case 'email':
      $tickets = $ticket->searchTickets('email',$_POST['email']);
    break;
  } ?>

  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped">
      <thead>
        <tr>
          <th>Ticket #</th>
          <th>Name</th>
          <th>When</th>
          <th>Who</th>
          <th>IP</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tickets as $result) : ?>
          <tr>
            <td><?php echo $result->barcode;?></td>
            <td><?php echo $result->firstname;?></td>
            <td><?php echo timestamp($result->scanned_at);?></td>
            <td><?php echo $result->scanned_by;?></td>
            <td><?php echo $result->ip_addr;?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>

  <?php 
}


?>

  <div class="page-header">
    <h1>Ticket search</h1>
  </div>

<div class="row">
<div class="col-md-4">
<h2>Barcode Search</h2>
<form class="form" method="POST" action="?searchby=barcode">
  <div class="form-group">
    <input name="barcode" class="form-control" placeholder="Scan or enter barcode" />
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>
</div>
<div class="col-md-4">
<h2>Name Search</h2>
<form class="form" method="POST" action="?searchby=name">
  <div class="form-group">
    <input name="name" class="form-control" placeholder="Enter first or last name" />
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>
</div><div class="col-md-4">
<h2>Email search</h2>
<form class="form" method="POST" action="?searchby=email">
  <div class="form-group">
    <input name="email" class="form-control" placeholder="Enter an email address" />
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>
</div>
</div>
<?php require_once('footer.php'); ?>
