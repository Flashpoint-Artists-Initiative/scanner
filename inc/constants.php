<?php

define('TICKET_LENGTH',11); //Length of ticket IDs
define('TICKET_TABLE','ticket');
define('TICKET_COL','barcode');
define('SCAN_COL','scanned');
define('TICKET_PREG',"/[[:upper:]]{3}\\d{8}/s");
