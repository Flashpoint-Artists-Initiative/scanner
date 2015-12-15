#Scanner
Given a barcode scanner that acts like a keyboard and a database of ticket IDs, check to see if the scanned barcode exists in the database and mark it as scanned if so.

This application is designed to be used as a ticket scanning system in environments where internet or cellular access is not extant.

##Installing
Copy `config-example.php` to `config.php` and change the database settings as needed.

If you want some test data to work with, run `inc/debug.php`. 1000 ticket IDs and names will be generated and inserted into the database. The IDs will range from `1234567890` to `1234568889`.
