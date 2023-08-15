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

if (isset($_POST['submit']) && ($_POST['submit'] == "submit")) {
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	$search_term = $_POST['search_term'];
	$search_value = $_POST['search_value'];
	if ($search_term == "type") {
		$sql = "SELECT `equipment`.`auto_id` AS 'auto_id', 
						`manufacturer`.`name` AS 'manufacturer',
						`equipment`.`serial_num` AS 'serial_num'		
			FROM `equipment`
			INNER JOIN `manufacturer` ON `equipment`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment`.`type` = `type`.`auto_id`
			WHERE `type`.`name` = '$search_value'
			AND `type`.`auto_id`=`equipment`.`type`
			ORDER BY `manufacturer`";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td><td>Manufacturer</td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>{$data['auto_id']}</td>";
			echo "<td>{$data['serial_num']}</td>";
			echo "<td>{$data['manufacturer']}</td>";
			echo "</tr>";
		}
	}
	else if ($search_term == "manufacturer") {
		$sql = "SELECT `equipment`.`auto_id` AS 'auto_id', 
						`equipment`.`serial_num` AS 'serial_num', 
						`type`.`name` AS 'type'
			FROM `equipment`
			INNER JOIN `manufacturer` ON `equipment`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment`.`type` = `type`.`auto_id`
			WHERE `manufacturer`.`name` = '$search_value' 
			AND `manufacturer`.`auto_id`=`equipment`.`manufacturer`
			ORDER BY `type`";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td><td>Type</td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>{$data['auto_id']}</td>";
			echo "<td>{$data['serial_num']}</td>";
			echo "<td>{$data['type']}</td>";
			echo "</tr>";
		}
	}
	else if ($search_term == "serial_num") {
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment` WHERE `serial_num` = '$search_value'";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>{$data['auto_id']}</td>";
			echo "<td>{$data['serial_num']}</td>";
			echo "</tr>";
		}
	}
	else if ($search_term == "all") {
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment` LIMIT 500000";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td><td><h3>500,000 LIMIT</h3></td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>{$data['auto_id']}</td>";
			echo "<td>{$data['serial_num']}</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
 
else {
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	$sql = "SELECT DISTINCT(`name`) FROM `type`";
	$type_result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	$sql = "SELECT DISTINCT(`name`) FROM `manufacturer`";
	$manufacturer_result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<form method="post" action="">';
	echo '<label for="search_term">Search by:</label>';
	echo '<select name="search_term" id="search_term">';
	echo '<option value="type">Type</option>';
	echo '<option value="manufacturer">Manufacturer</option>';
	echo '<option value="serial_num">Serial Number</option>';
	echo '<option value="all">All</option>';
	echo '</select><br><br>';
	echo '<label for="search_value">Enter search value:</label>';
	echo '<input type="text" name="search_value" id="search_value"><br><br>';
	echo '<button type="submit" name="submit" value="submit">Submit</button>';
	echo '</form>';
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
?>