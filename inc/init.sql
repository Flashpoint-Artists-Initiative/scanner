-- Create syntax for TABLE 'scan_log'
CREATE TABLE `scan_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `who` varchar(255) DEFAULT NULL,
  `what` varchar(2) DEFAULT '',
  `data` longtext,
  `timestamp` timestamp NULL DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- Create syntax for TABLE 'scan_ticket'
CREATE TABLE `scan_ticket` (
  `Order` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `scanned` int(11) DEFAULT NULL,
  `scanned_by` varchar(255) DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_email` varchar(255) DEFAULT NULL,
  `ip_addr` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE DEFINER=`scanner`@`localhost` FUNCTION `SPLIT_STR`(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
) RETURNS varchar(255) CHARSET latin1
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '');