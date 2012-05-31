<?php
/**************************
This file runs a backup of the live database. The db dump file has the date and time in the name, 
so I am able to check the time on the server and then construct a file name, and then check if 
that file exists or not. So if it doesnt exist, do a db dump, and gzip it up when it is done. 

Please note the database is now so large that it will probably not run from within the OSCommerce 
restore utility, due to memory limitations in PHP.  A proper restore action will have to be
run from the command line or  by a php script. 

invoked in a cron job using /usr/local/bin/php /crons/dbdump.php
****************************/

$account = "somedomain.com";
$filePrefixName = "db_dump_name-";
$dateTime = date('Ymd-A'); // 'A' =  AM or PM timestamp for file name 
$sqlfile = "/home/$account/public_html/admin/backups/$filePrefixName"  .  $dateTime . ".sql";
$tarballName = $sqlfile . ".gz";
$dbuser = "user";
$dbpass = "pass";
$dbhost = "localhost";
$dbname = "dbname";

$dbDumpToFile = "/usr/local/mysql/bin/mysqldump -u $dbuser -p $dbpass -h $dbhost  $dbname > $sqlfile";

if(!file_exists($tarballName)) {
  $makeFile = `$dbDumpToFile`;
  $tarFile  = `gzip $sqlfile`; // make a tarball 
}

