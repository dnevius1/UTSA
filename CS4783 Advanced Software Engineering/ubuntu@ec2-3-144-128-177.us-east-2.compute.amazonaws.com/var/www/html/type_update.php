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
$time_start=microtime(true);
echo "<p>Start time is: $time_start</p>";
$sql="Set autocommit=0";
$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
$sql="Select `auto_id`,`name` from `type` where `name`='laptop'";
$result=$dblink->query($sql) or
	die("Something went wrong with: $sql<br>\n".$dblink->error);
$count=0;
while ($item=$result->fetch_array(MYSQLI_ASSOC))
{
	$sql="Select `auto_id`,`type` from `equipment_testing` where `type` = '$item[name]'";
	$rst=$dblink->query($sql) or
		die("Something went wrong with: $sql<br>".$dblink->error);
	while ($data=$rst->fetch_array(MYSQLI_ASSOC))
	{
	
	$sql="Update `equipment_testing` set `type`='$item[auto_id]' where `auto_id`='$data[auto_id]'";
	$dblink->query($sql) or
		die("Something went wrong with: $sql<br>".dblink->error);
	$count++;
	}
}
$sql="Commit";
$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);
$time_end=microtime(true);
echo "<p>End Time:$time_end</p>\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>\n";
$rowsPerSecond=$count/$seconds;
echo "<p>Insert rate: $rowsPerSecond per second</p>\n";
?>