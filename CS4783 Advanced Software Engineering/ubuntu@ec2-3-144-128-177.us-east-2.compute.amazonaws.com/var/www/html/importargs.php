<?php
function db_iconnect($dbName)
{
	$un="webuser";
	$pw="!Ra/hRdebnnICOzV";
	$db=$dbName;
	$hostname="localhost";
	$dblink=new mysqli($hostname,$un,$pw,$db);
	return $dblink;
}
echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
$dblink=db_iconnect("test");
$fp=fopen("/home/ubuntu/$argv[2]","r");
$count=0;
$time_start=microtime(true); 
echo "PHP ID:$argv[1]-Start time is: $time_start\n";
$sql="Set autocommit=0";
$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);	
while (($row=fgetcsv($fp)) !== FALSE) 
{
    $sql="Insert into `equipment` (`type`,`manufacturer`,`serial_num`) values 
	('$row[0]','$row[1]','$row[2]')";
    $dblink->query($sql) or
        die("Something went wrong with $sql<br>\n".$dblink->error);
    $count++;
}
$sql="Commit";
$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);
$time_end=microtime(true);
echo "PHP ID:$argv[1]-End Time:$time_end\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "PHP ID:$argv[1]-Execution time: $execution_time minutes or $seconds seconds.\n";
$rowsPerSecond=$count/$seconds;
echo "PHP ID:$argv[1]-Insert rate: $rowsPerSecond per second\n";
fclose($fp);
?>