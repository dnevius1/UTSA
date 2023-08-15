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
	
	$manu=$_POST['manufacturer'];
	$type=$_POST['type'];
	$st = $_POST['search_term'];
	$sn = $_POST['serial_number'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://ec2-3-144-128-177.us-east-2.compute.amazonaws.com/api/search?search_term=$st&manufacturer=$manu&type=$type&serial_number=$sn",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_SSL_VERIFYPEER => false
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	echo "<pre>";
	echo $response;
	echo "</pre>";
	if ($err)
	{
		echo "<h3>cURL Error Search API #: $err</h3>";
		die();
	}
	else
		$results = json_decode($response, true);
	echo "<pre>";
	print_r($results);
	var_dump($results);
	echo "</pre>";
	
	
	

    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

    echo PHP_EOL;
	die();

	
	
	
	
	
	
	
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

//////////////////////////MAIN SCREEN/////////////////////////////////////
else {
	$dblink = db_iconnect("test");
	$time_start = microtime(true);
	
	//SEARCH
	echo '<form method="post" action="">';
	echo '<h1>Search</h1>';
	echo '<label for="search_term">Search by:</label><br>';
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
	echo '<label for="type">Type: </label><br>';
	echo '<select name="type">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	$sql = "SELECT DISTINCT(`name`) FROM `manufacturer`";
	$result = $dblink->query($sql) or
		die("Something went wrong with: $sql<br>" . $dblink->error);
	echo '<label for="manufacturer">Manufacturer: </label><br>';
	echo '<select name="manufacturer">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select><br><br>';
	echo '<label for="serial_number">Serial Number: </label><br>';
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
	echo '<label for="type_ins">Type: </label><br>';
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
	echo '<label for="man_ins">Manufacturer: </label><br>';
	echo '<select name="man_ins">';
	while($data=$result->fetch_array(MYSQLI_NUM))
	{
		echo '<option value="'.$data[0].'">'.$data[0].'</option>';
	}
	echo '</select>';
	echo '<button type="submit" name="ins_new_man" value="submit"> New</button><br><br>';
	
	//Serial Number
	echo '<label for="serial_num_ins">Serial Number: </label><br>';
	echo '<input type="text" id="serial_num_ins" name="serial_num_ins">';
	echo '<br><br>';
	echo '<label for="status">Status:</label><br>';
	echo '<select name="status" id="status">';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
	echo '</select><br><br>';
	echo '<button type="submit" name="ins_submit" value="submit">Submit</button>';
	echo '</form>';
}
?>