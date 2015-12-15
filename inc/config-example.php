<?php
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');

define('DB_METHOD', 'mysql');//Probably won't need to change
define('DB_NAME', 'CHANGEME');
define('DB_USER', 'CHANGEME');
define('DB_PASS', 'CHANGEME');
define('DB_HOST', 'localhost');//Probably won't need to change

//Probably won't need to change,
//unless you want two or more parallel installations
define('TBL_PREFIX', 'scan_');

###### DEBUG FLAG ######
define('DEBUG', TRUE);
###### DEBUG FLAG ######

require_once ('functions.php');
require_once ('autoload.php');
