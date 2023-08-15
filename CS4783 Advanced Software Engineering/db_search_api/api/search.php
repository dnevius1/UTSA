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
		$sql = "SELECT `equipment`.`auto_id` AS 'auto_id', 
						`manufacturer`.`name` AS 'manufacturer',
						`equipment`.`serial_num` AS 'serial_num'		
			FROM `equipment`
			INNER JOIN `manufacturer` ON `equipment`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment`.`type` = `type`.`auto_id`
			WHERE `type`.`name` = '$search_value'
			AND `type`.`auto_id`=`equipment`.`type`
			ORDER BY `manufacturer` LIMIT 1000";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			$info[]=array($search_value,$data['manufacturer'],$data['serial_num']);
		}
	}
	else if ($search_term == "manufacturer") {
		$search_value = $_REQUEST['manufacturer'];
		$sql = "SELECT `equipment`.`auto_id` AS 'auto_id', 
						`equipment`.`serial_num` AS 'serial_num', 
						`type`.`name` AS 'type'
			FROM `equipment`
			INNER JOIN `manufacturer` ON `equipment`.`manufacturer` = `manufacturer`.`auto_id`
			INNER JOIN `type` ON `equipment`.`type` = `type`.`auto_id`
			WHERE `manufacturer`.`name` = '$search_value' 
			AND `manufacturer`.`auto_id`=`equipment`.`manufacturer`
			ORDER BY `type` LIMIT 1000";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			$info[]=array($data['auto_id'],$data['serial_num']);
		}
	}
	else if ($search_term == "serial_num") {
		$search_value = $_REQUEST['serial_number'];
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment` WHERE `serial_num` = '$search_value'";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			$info[]=array($data['auto_id'],$data['serial_num']);
		}
	}
	else if ($search_term == "all") {
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment` LIMIT 1000";
		$result = $dblink->query($sql) or
			die("Something went wrong with: $sql<br>" . $dblink->error);
		
		while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
			$info[]=array($data['auto_id'],$data['serial_num']);
		}
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
?>