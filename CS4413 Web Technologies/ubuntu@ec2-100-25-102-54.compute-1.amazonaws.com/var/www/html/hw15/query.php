<?php
	$username="webuser";
	$password="!Ra/hRdebnnICOzV";
	$db="contact_data";
	$hostname="localhost";
	$dblink=new mysqli($hostname, $username, $password, $db); //php connection string
	$sql="Select * from `entries`";
	$results=$dblink->query($sql) or 
		die("Something went wrong with: $sql<br>".$dblink->error);
		
	while ($data=$results->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'.$data['auto_id'].'</td>';
		echo '<td>'.$data['first_name'].'</td>';
		echo '<td>'.$data['last_name'].'</td>';
		echo '<td>'.$data['email'].'</td>';
		echo '<td>'.$data['phone'].'</td>';
		echo '<td>'.$data['comments'].'</td>';
		echo '</tr>';
	}
?>