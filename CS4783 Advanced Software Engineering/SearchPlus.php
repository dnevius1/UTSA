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
//Update single record
function update_single() 
{
	$time_start = microtime(true);
	$dblink = db_iconnect("test");
	$new_man= $_POST['up_rec_man'];
	$new_type= $_POST['up_rec_type'];
	$up_search_value = $_POST['update_device'];
	if ($_POST['update_status'] == "active") {
		$table = "equipment";
	}
	else {
		$table = "inactive";
	}
	$sql = "SELECT `type`.`auto_id` AS 'type_id',
				   `manufacturer`.`auto_id` AS 'manufacturer_id'
			FROM `type`,`manufacturer`
			WHERE `type`.`name`='$new_type'
			AND `manufacturer`.`name`='$new_man'";
	echo $sql.'<br>';
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	$data = $result->fetch_array(MYSQLI_ASSOC);
	$sql = "UPDATE `$table`
			SET `type`='{$data['type_id']}', `manufacturer`='{$data['manufacturer_id']}'
			WHERE `auto_id`='$up_search_value'";
	echo $sql.'<br>';
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	$sql = "SELECT `$table`.`auto_id` AS 'auto_id', 
					`$table`.`serial_num` AS 'serial_num', 
					`type`.`name` AS 'type',
					`manufacturer`.`name` AS 'manufacturer'
		FROM `$table`
		INNER JOIN `manufacturer` ON `$table`.`manufacturer` = `manufacturer`.`auto_id`
		INNER JOIN `type` ON `$table`.`type` = `type`.`auto_id`
		WHERE `$table`.`auto_id` = '$up_search_value'";
	echo $sql.'<br>';
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<form method="post" action="">';
	echo "<h3>Updated record $up_search_value:</h3>";
	echo "<table>";
	echo "<tr><td>Auto Index</td><td>Serial Number</td><td>Type</td><td>Manufacturer</td></tr>";
	$data = $result->fetch_array(MYSQLI_ASSOC);
	echo "<tr>";
	echo "<td>{$data['auto_id']}</td>";
	echo "<td>{$data['serial_num']}</td>";
	echo "<td>{$data['type']}</td>";
	echo "<td>{$data['manufacturer']}</td>";
	echo "</tr>";
	echo "</table>";
}
//New type form
if (isset($_POST['ins_new_type']) && ($_POST['ins_new_type'] == "submit")) {	
	
	echo '<form action="" method="post">';
	echo '<h1>New Type</h1>';
	echo '<label for="nt_input">Enter name of new type: </label>';
	echo '<input type="text" id="nt_input" name="nt_input">';
	echo '<br><br>';
	echo '<label for="nt_status">Status:</label>';
	echo '<select name="nt_status" id="nt_status">';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
	echo '</select><br><br>';
	echo '<button type="submit" name="nt_submit" value="submit">Submit</button>';
	echo '</form>';
}
//New type query
elseif (isset($_POST['nt_submit']) && ($_POST['nt_submit'] == "submit")) {
	$time_start = microtime(true);
	if (!empty($_POST['nt_input'])) 
	{	
		$dblink = db_iconnect("test");
		$type_to_add = $_POST['nt_input'];
		if ($_POST['nt_status'] == "active") {
			$table = "type";
			$sql = "INSERT INTO type (name) VALUES ('$type_to_add')";
			$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
			echo '<p>'.$type_to_add.' added to the '.$table.' table!</p>';
		}
		else {
			$table = "inactive";
			$sql = "INSERT INTO inactive (type, manufacturer, serial_num) 
					VALUES ('$type_to_add','','')";
			$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
			echo '<p>'.$type_to_add.' added to the '.$table.' table!</p>';
		}
	}
	else {
		echo '<p>Error: New type field must not be blank.</p>';
	}
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
//New manufacturer form
elseif (isset($_POST['ins_new_man']) && ($_POST['ins_new_man'] == "submit")) {	
	
	echo '<form action="" method="post">';
	echo '<h1>New Manufacturer</h1>';
	echo '<label for="nm_input">Enter name of new manufacturer: </label>';
	echo '<input type="text" id="nm_input" name="nm_input">';
	echo '<br><br>';
	echo '<label for="nm_status">Status:</label>';
	echo '<select name="nm_status" id="nm_status">';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
	echo '</select><br><br>';
	echo '<button type="submit" name="nm_submit" value="submit">Submit</button>';
	echo '</form>';
}
//New manufacturer query
elseif (isset($_POST['nm_submit']) && ($_POST['nm_submit'] == "submit")) {
	$time_start = microtime(true);
	if (!empty($_POST['nm_input'])) 
	{	
		$dblink = db_iconnect("test");
		$man_to_add = $_POST['nm_input'];
		if ($_POST['nm_status'] == "active") {
			$table = "manufacturer";
			$sql = "INSERT INTO manufacturer (name) VALUES ('$man_to_add')";
			$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
			echo '<p>'.$man_to_add.' added to the '.$table.' table!</p>';
		}
		else {
			$table = "inactive";
			$sql = "INSERT INTO inactive (type, manufacturer, serial_num) 
					VALUES ('','$man_to_add','')";
			$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
			echo '<p>'.$man_to_add.' added to the '.$table.' table!</p>';
		}
	}
	else {
		echo '<p>Error: New manufacturer field must not be blank.</p>';
	}
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
//Search by type, manufacturer, or serial number
elseif (isset($_POST['submit']) && ($_POST['submit'] == "submit")) {
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	$search_term = $_POST['search_term'];
	if ($search_term == "type") {
		$search_value = $_POST['type'];
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
		$search_value = $_POST['manufacturer'];
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
		$search_value = $_POST['serial_number'];
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
		$sql = "SELECT `auto_id`,`serial_num` FROM `equipment` LIMIT 1000";
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
	}
	echo "</table>";
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
//Insert new device
elseif (isset($_POST['ins_submit']) && ($_POST['ins_submit'] == "submit")) {
	$time_start = microtime(true);
	if (!empty($_POST['serial_num_ins'])) 
	{
		$dblink = db_iconnect("test");
		$type = $_POST['type_ins'];
		$manufacturer = $_POST['man_ins'];
		$serial_num = $_POST['serial_num_ins'];
		$table ='';
		if ($_POST['status'] == "active") {
			$table = "equipment";
		}
		else {
			$table = "inactive";
		}
		$sql = "INSERT INTO $table (type, manufacturer, serial_num) 
				VALUES ('$type', '$manufacturer', '$serial_num')";
		$result = $dblink->query($sql) or
				die("Something went wrong with: $sql<br>" . $dblink->error);
		echo "<h3>Record Inserted</h3><br><br>";
	}
	else {
		echo "<h3>Error: Serial number must not be blank.</h3>";
	}
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
//Update device
elseif (isset($_POST['update_submit']) && ($_POST['update_submit'] == "submit")) {
	$time_start = microtime(true);
	$dblink = db_iconnect("test");
	if ($_POST['update_status'] == "active") {
		$table = "equipment";
	}
	else {
		$table = "inactive";
	}
	$up_status = $_POST['update_status'];
	$up_search_value = $_POST['update_device'];
	$sql = "SELECT `$table`.`auto_id` AS 'auto_id', 
					`$table`.`serial_num` AS 'serial_num', 
					`type`.`name` AS 'type',
					`manufacturer`.`name` AS 'manufacturer'
		FROM `$table`
		INNER JOIN `manufacturer` ON `$table`.`manufacturer` = `manufacturer`.`auto_id`
		INNER JOIN `type` ON `$table`.`type` = `type`.`auto_id`
		WHERE `$table`.`auto_id` = '$up_search_value'";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<form method="post" action="">';
	echo "<h3>Update device at auto id $up_search_value:</h3>";
	echo "<table>";
	echo "<tr><td>Auto Index</td><td>Serial Number</td><td>Type</td><td>Manufacturer</td></tr>";
	$data = $result->fetch_array(MYSQLI_ASSOC);
	echo "<tr>";
	echo "<td>{$data['auto_id']}</td>";
	echo "<td>{$data['serial_num']}</td>";
	echo "<td>{$data['type']}</td>";
	echo "<td>{$data['manufacturer']}</td>";
	echo "</tr>";
	echo '<p>Select the current type or manufacturer if you do not 
		 wish to change both fields</p>';
	$sql = "SELECT DISTINCT(`name`) FROM `type`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="up_rec_type">Type: </label>';
	echo '<select name="up_rec_type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	$sql = "SELECT DISTINCT(`name`) FROM `manufacturer`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="up_rec_man">Manufacturer: </label>';
	echo '<select name="up_rec_man">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	echo "<input type='hidden' name='update_device' value='$_POST[update_device]'</input>"; 
	echo "<input type='hidden' name='update_status' value='$_POST[update_status]'</input>"; 
	echo '<button type="submit" name="update_rec_submit" value="submit">Submit</button><br><br>';
	echo '</form>';
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
	
}
elseif (isset($_POST['update_rec_submit']) && ($_POST['update_rec_submit'] == "submit")) {
		
		update_single();
	}

//////////////////////////MAIN SCREEN/////////////////////////////////////
else {
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	
	//SEARCH
	echo '<form method="post" action="">';
	echo '<h1>Search</h1>';
	echo '<label for="search_term">Search by:</label>';
	echo '<select name="search_term" id="search_term">';
	echo '<option value="type">Type</option>';
	echo '<option value="manufacturer">Manufacturer</option>';
	echo '<option value="serial_num">Serial Number</option>';
	echo '<option value="all">All</option>';
	echo '</select><br><br>';
	if (isset($_POST['search_term'])) {
		$option= $_POST['search_term'];
	}
	$sql = "SELECT DISTINCT(`name`) FROM `type`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="type">Type: </label>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	$sql = "SELECT DISTINCT(`name`) FROM `manufacturer`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="manufacturer">Manufacturer: </label>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	echo '<label for="serial_number">Serial Number: </label>';
	echo '<input type="text" id="serial_number" name="serial_number">';
	echo '<br><br>';
	echo '<button type="submit" name="submit" value="submit">Submit</button>';
	echo '<br><br><p>Select what you want to search by in the first box and select the specific type, manufacturer, or serial number.<br>
	The other boxes will not affect the query if they were not selected in the Search by box.<br><br></p>';
	
	//INSERT
	echo '<h1>Insert</h1>';
	//Type
	$sql = "SELECT DISTINCT(`name`) FROM `type`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="type_ins">Type: </label>';
	echo '<select name="type_ins">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<button type="submit" name="ins_new_type" value="submit"> New</button><br><br>';
	
	//Manufacturer
	$sql = "SELECT DISTINCT(`name`) FROM `manufacturer`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="man_ins">Manufacturer: </label>';
	echo '<select name="man_ins">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<button type="submit" name="ins_new_man" value="submit"> New</button><br><br>';
	
	//Serial Number
	echo '<label for="serial_num_ins">Serial Number: </label>';
	echo '<input type="text" id="serial_num_ins" name="serial_num_ins">';
	echo '<br><br>';
	echo '<label for="status">Status:</label>';
	echo '<select name="status" id="status">';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
	echo '</select><br><br>';
	echo '<button type="submit" name="ins_submit" value="submit">Submit</button>';
	
	//UPDATE
	echo '<h1>Update</h1>';
	echo '<label for="update_device">Auto ID: </label>';
	echo '<input type="text" id="update_device" name="update_device">';
	echo '<br><br>';
	echo '<label for="update_status">Status:</label>';
	echo '<select name="update_status" id="update_status">';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
	
	echo '</select><br><br>';
	echo '<button type="submit" name="update_submit" value="submit">Submit</button>';
	
	echo '</form>';
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
?>