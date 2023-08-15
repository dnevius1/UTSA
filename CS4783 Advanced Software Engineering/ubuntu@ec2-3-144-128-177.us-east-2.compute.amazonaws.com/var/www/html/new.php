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
$dblink=db_iconnect("test");
$fp=fopen("/var/www/html/equipment_partial_utf8","r");
$count=0;
$time_start=microtime(true);
echo "<p>Start time is: $time_start</p>";
while (($row=fgetcsv($fp)) !== FALSE)
{
	$sql="Insert into `equipment2` {`item`, `brand`, `serial_num`) values ('$row[0]','$row[1]','$row[2]')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	$count++;
}
$time_end=microtime(true);
echo "<p>End Time:$time_end</p>\n";
$seconds=$time_end-$time_start;
$execution_time=
?>