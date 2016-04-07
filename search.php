<?php require_once('header.php'); ?>

<div class="page-header">
  <h1>Ticket search</h1>
</div>

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
          <th>Barcode</th>
          <th>Name</th>
          <th>Date Scanned</th>
          <th>Scanned by</th>
          <th>From IP</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tickets as $result) :
          $result = $ticket->parseTicket($result);?>
          <tr <?php echo ($result->scanned) ? "class='success'" : ''; ?>>
            <td><code><?php echo $result->barcode;?></code></td>
            <td><?php echo $result->firstname.' '.$result->lastname?></td>
            <?php if($result->scanned) : ?>
              <td><?php echo timestamp($result->scanned_at);?></td>
            <?php else : ?>
              <td>Not Scanned Yet</td>
            <?php endif; ?>
            <td><?php echo $result->scanned_by;?></td>
            <?php if (!$result->scanned) : ?>
              <td><?php echo $result->ip_addr;?></td>
              <td>
                <a href="<?php echo $result->scanlink;?>">Manual check in</a>
              </td>
            <?php else : ?>
              <td colspan='2'><?php echo $result->ip_addr;?></td>
            <?php endif; ?>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>

  <?php } ?>

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
