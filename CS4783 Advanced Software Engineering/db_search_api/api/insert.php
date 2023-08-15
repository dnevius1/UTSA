<?php
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	$info = array();
	$error = "Error: Serial number must not be blank.";
	if (!empty($_REQUEST['serial_num_ins'])) 
	{
		$type = $_REQUEST['type_ins'];
		$manufacturer = $_REQUEST['man_ins'];
		$serial_num = $_REQUEST['serial_num_ins'];
		$table ='';
		if ($_REQUEST['status'] == "active") {
			$table = "equipment";
		}
		else {
			$table = "inactive";
		}
		$sql = "INSERT INTO $table (type, manufacturer, serial_num) 
				VALUES ('$type', '$manufacturer', '$serial_num')";
		$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
		$info[]=array($type,$manufacturer,$serial_num,$table);
	}
	else {
		$info[]=array($error);
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