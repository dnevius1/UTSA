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
/*
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
*/
//Search by type, manufacturer, or serial number
if (isset($_POST['submit']) && ($_POST['submit'] == "submit")) {
	$time_start = microtime(true);
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
	
	if ($err)
	{
		echo "<h3>cURL Error Search API #: $err</h3>";
		die();
	}
	else {
		$results = json_decode($response, true);
	}
	$tmp=explode(":",$results[0]);
	$status=trim($tmp[1]);
	if ($status=="Success")
	{
		$tmp=explode(":",$results[1]);
		$data=json_decode($tmp[1], true);
		if ($st == "type") 
		{
			echo '<table id="results" class="display" width="40%">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Type</th>';
			echo '<th>Manufacturer</th>';
			echo '<th>Serial Number</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($data as $key=>$value)
			{
				echo '<tr>';
				echo '<td>'.$value[0].'</td>';
				echo '<td>'.$value[1].'</td>';
				echo '<td>'.$value[2].'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}
		else
		{
			echo '<table id="results" class="display" width="40%">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Auto ID</th>';
			echo '<th>Serial Number</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach($data as $key=>$value)
			{
				echo '<tr>';
				echo '<td>'.$value[0].'</td>';
				echo '<td>'.$value[1].'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}
	}
	$time_end = microtime(true);
	$seconds = $time_end - $time_start;
	$execution_time = ($seconds) / 60;
	echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
}
//Insert new device
elseif (isset($_POST['ins_submit']) && ($_POST['ins_submit'] == "submit")) {
	$time_start = microtime(true);
	$manu=$_POST['man_ins'];
	$type=$_POST['type_ins'];
	$st = $_POST['search_term'];
	$sn = $_POST['serial_num_ins'];
	$stat=$_POST['status'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://ec2-3-144-128-177.us-east-2.compute.amazonaws.com/api/insert?search_term=$st&man_ins=$manu&type_ins=$type&serial_num_ins=$sn&status=$stat",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_SSL_VERIFYPEER => false
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	$test=json_encode($response, true);
	if ($err)
	{
		echo "<h3>cURL Error Search API #: $err</h3>";
		die();
	}
	else 
		$results = json_decode($test, true);
	
	if (empty($sn)) 
	{
		echo '<p> Serial number must not be empty.</p>';
		die();
	}
	else 
	{
		$tmp=explode(":",$results);
		$toReplace = array( "[", "]", "\"");
		$cleaned = str_replace($toReplace, "", $tmp[2]);
		$noSlashes = stripslashes($cleaned);
		$tmp2=explode(",",$noSlashes);
	
		echo "New device with<br> Type: <b>".$tmp2[0]."</b><br>Manufacturer: 
		<b>".$tmp2[1]."</b><br>Serial number: <b>".$tmp2[2]."</b> <br>added to table: 
		<b>".$tmp2[3]."</b>";
		$time_end = microtime(true);
		$seconds = $time_end - $time_start;
		$execution_time = ($seconds) / 60;
		echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>";
	}
}

//////////////////////////MAIN SCREEN/////////////////////////////////////
else {
	$dblink = db_iconnect("test");
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
	//echo "<input type='hidden' name='hidden_st' value='$_POST[search_term]'</input>";
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
	echo '<br><br>';
	
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
	echo '<br><br>';
	
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
