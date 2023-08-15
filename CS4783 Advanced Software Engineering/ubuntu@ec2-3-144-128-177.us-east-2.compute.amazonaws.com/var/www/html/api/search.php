<?php

	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	$search_term = $_REQUEST['search_term'];
	$info = array();
	if (!isset($_REQUEST['search_term']))
	{
		$output[]='Status: ERROR';
		$output[]='MSG: Search term data is NULL';
		$output[]='Action: Resend search term data';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	if ($search_term == "type") {
		$search_value = $_REQUEST['type'];
		$sql = "SELECT `equipment_testing`.`auto_id` AS 'auto_id', 
						`manufacturer`.`name` AS 'manufacturer',
						`equipment_testing`.`serial_num` AS 'serial_num'		
			FROM `equipment_testing`
			INNER JOIN `manufacturer` ON `equipment_testing`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment_testing`.`type` = `type`.`auto_id`
			WHERE `type`.`name` = '$search_value'
			AND `type`.`auto_id`=`equipment_testing`.`type`
			ORDER BY `manufacturer` LIMIT 100";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td><td>Manufacturer</td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			$info[]=array($search_value,$data['manufacturer'],$data['serial_num']);
			
		}
		echo "</table>";
	}
	else if ($search_term == "manufacturer") {
		$search_value = $_REQUEST['manufacturer'];
		$sql = "SELECT `equipment_testing`.`auto_id` AS 'auto_id', 
						`equipment_testing`.`serial_num` AS 'serial_num', 
						`type`.`name` AS 'type'
			FROM `equipment_testing`
			INNER JOIN `manufacturer` ON `equipment_testing`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment_testing`.`type` = `type`.`auto_id`
			WHERE `manufacturer`.`name` = '$search_value' 
			AND `manufacturer`.`auto_id`=`equipment_testing`.`manufacturer`
			ORDER BY `type` LIMIT 1000";
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
		echo "</table>";
	}
	else if ($search_term == "serial_num") {
		$search_value = $_REQUEST['serial_number'];
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment_testing` WHERE `serial_num` = '$search_value'";
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
		echo "</table>";
	}
	else if ($search_term == "all") {
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment_testing` LIMIT 1000";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Search by $search_term: $search_value</h3>";
		echo "<table>";
		echo "<tr><td>Auto Index</td><td>Serial Number</td><td><h3>1,000 LIMIT</h3></td></tr>";
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>{$data['auto_id']}</td>";
			echo "<td>{$data['serial_num']}</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	$infoJson=json_encode($info);
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	$output[]='Status: Success';
	$output[]='MSG: '.$infoJson;
	$output[]='Action: '.$execution_time.'';
	$responseData=json_encode($output);
	echo $responseData;
	//echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
	
?>