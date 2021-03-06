<?php

require_once('../inc/bootstrap.php');

function testCheck($name,$data,$expected) {
  $data = json_decode($data);
  if ($data->code === $expected){
    return "Testing for: $name... Passed<br>";
  }
  return "Testing for: $name... Failed<br>";
}

$_GET['user'] = 'testSuite';

?>

<h1>Ticket Test Suite</h1>
<pre>
Ticket barcode length: <?php echo TICKET_LENGTH;?> characters<br>
Ticket regular expression match: <?php echo TICKET_PREG;?><br>
Ticket table: <?php echo TICKET_TABLE;?><br>
Barcode column: <?php echo TICKET_COL;?><br>
Scanned boolean column: <?php echo SCAN_COL;?><br>
Strict barcode checking is: <?php echo !STRICT_CHECKING?'Disabled':'Enabled';?><br>
<?php
$ticket = new ticket();

$barcode = 'ZZZ111111111';
echo testCheck("Successful import",$ticket->importTickets("Testing,$barcode"),3);


echo testCheck('Valid scan',$ticket->scanTicket($barcode,'nick'),3);
echo testCheck('Duplicate scan',$ticket->scanTicket($barcode,'nick'),1);
echo testCheck('Empty barcode',$ticket->scanTicket('','nick'),0);
echo testCheck('Invalid barcode',$ticket->scanTicket('asdfghjkl','nick'),0);
echo testCheck('Empty user',$ticket->scanTicket($barcode,''),2);
echo testCheck('Empty user, empty barcode',$ticket->scanTicket('',''),2);

$db = new database();
$db->query("DELETE FROM tbl_ticket WHERE tbl_ticket.barcode = '$barcode'");
$db->execute();
?>

</pre>
