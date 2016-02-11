#Scanner
###Offline barcode scanning made easy

##Intent
This tool is designed to operate in environments where access to the internet is not available or is unreliable. All the required resources (css/javascript/audio) are included locally.

**THIS IS NOT A SECURE SYSTEM**  
Where possible, provisions for security and validation have been made, but no guarantees are provided. _Conventional wisdom says that people scanning tickets aren't going to be well-versed in XSS and SQL exploits_.

##Requirements
You will need hardware to act as a server for the scanning interface and client hardware that will connect to the server over a local network. For example, I use a Mac Mini running this application on a virtual machine, which is allowed to interface with the local network. The mini is wired into an ethernet switch along with several windows laptops. The laptops load the scanning website from the Mini's virtual machine. The actual setup of this system will be left as an exercise to the end-user.

##Assumptions
This application makes several assumptions about the nature and structure of the data being scanned. Please see `init.sql` to get an idea of the expected structure. _You will almost certainly have to make changes to the structure of the table_.

At the bare minimum, your `ticket` table should have the following columns:  

* `firstname`, ticket holder's first name
* `barcode`, the column containing ticket barcodes that will be scanned from the physical ticket.

If you have that data in a column separated format (CSV) like so: `firstname,barcode` (with each entry on a new line), you can import it from `import.php`.

These columns are added once the data has been imported:

* `scanned`, a boolean column for whether or not the ticket has been scanned
* `scanned_at`, a timestamp for when the ticket was scanned
* `scanned_by`, who scanned the ticket
* `ip_addr`, used for storing the hashed IP of the hardware that the ticket was scanned from

Note that the `barcode` column is defined as a constant in `inc/constants.php` and can be changed based on the data's format.

Further work will be done to increase the scanner's flexibility.

##Installation
Copy `inc/config-example.php` to `inc/config.php` and update with your database credentials. **BE SURE TO CHANGE THE ADMIN PASSWORD**

Upload the ticket information to the database. A tool to make this easier is forthcoming.

##TODO

  - [ ] Add an import tool
  - [ ] Add an export tool

##Attributions
Audio files from [-tg-station](https://github.com/tgstation/-tg-station/), licensed [CC-SA 3.0](http://creativecommons.org/licenses/by-sa/3.0/).
