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
$sql="Select = * from `equipment2 where `brand` = 'Microsoft'";
$time_start=microtime(true);
$result=$dblink->query($sql) or
	die("Something went wrong with: $sql<br>".$dblink->error);
$count=$result->num_rows;
$time_end=microtime(true);
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "<p>Number of rows for brand type: Microsoft: $count </p>";
echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
?>