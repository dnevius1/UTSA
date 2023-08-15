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
if (isset($_POST['submit']) && ($_POST['submit']=="submit"))
{
	$dblink=db_iconnect("test");
	$time_start=microtime(true);
	$query=$_POST['manufacturer'];
	$sql="Select `type`,`serial_num` from `equipment_testing` where `manufacturer`='$query'";
	$result=$dblink->query($sql) or
		die("Something went wrong with: $sql<br>".$dblin->error);
	echo '<h3>Search by manufacturer: '.$query.'</h3>';
	echo '<table>';
	echo '<tr><td>Type</td><td>Serial Number</td></tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo "<tr>";
		echo "<td>$data[type]</td>";
		echo "<td>$data[manufacturer]</td>";
		echo "<td>$data[serial_num]<td>";
		echo "</tr>";
	}
	echo "</table>";
	$time_end=microtime(true);
	$seconds=$time_end-$time_start;
	$execution_time=($seconds)/60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
else
{
	$dblink=db_iconnect("test");
	$time_start=microtime(true);
	$sql="Select distinct(`manufacturer`) from `equipment_testing`";
	$result=$dblink->query($sql) or
		die("Something went wrong with: $sql<br>".$dblink->error);
	echo '<form method="post" action="">';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<button type="submit" name="submit" value="submit">Submit</button>';
	echo '</form>';
	$time_end=microtime(true);
	$seconds=$time_end-$time_start;
	$execution_time=($seconds)/60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
?>