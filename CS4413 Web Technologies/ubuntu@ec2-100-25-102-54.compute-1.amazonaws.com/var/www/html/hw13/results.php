<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="assets/css/bootstrap.css" rel="stylesheet"/>
<link href="assets/css/bootstrap-theme.css" rel="stylesheet"/>

<title>Contact Page</title>
</head>
<body>
	<div style="backgroun-color:#F2F2F2;padding:5px"></div>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="index.html">Home</a></li>
		<li role="presentation"><a href="School.html">School</a></li>
		<li role="presentation"><a href="Work.html">Work</a></li>
		<li role="presentation"><a href="Hobbies.html">Hobbies</a></li>
		<li role="presentation"><a href="SMlinks.html">SM Links</a></li>
		<li role="presentation" class="active"><a href="Contact.html">Contact</a></li>
	</ul>
<?php
	$username="webuser";
	$password="!Ra/hRdebnnICOzV";
	$db="contact_data";
	$hostname="localhost";
	$dblink=new mysqli($hostname, $username, $password, $db); //php connection string
	$sql="Select * from `entries`";
	$results=$dblink->query($sql) or 
		die("Something went wrong with: $sql<br>".$dblink->error);
	echo '<h3>Database Entries</h3>';
	echo '<table class="table">';
		echo '<thead>';
			echo '<tr>';
				echo '<th>Id</td>
					  <th>First Name</td>
					  <th>Last Name</td>
					  <th>Email</td>
					  <th>Phone</td>
					  <th>Comments</td>';
			echo '</tr>';
		echo '</thead>';
	
	while ($data=$results->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tbody>';
			echo '<tr>';
				echo "<td>$data[auto_id]:</td>
					  <td>$data[first_name]</td>
					  <td>$data[last_name]</td>
					  <td>$data[email]</td>
					  <td>$data[phone]</td>
					  <td>$data[comments]</td>";
			echo '</tr>';
		echo '</tbody>';
	}
	echo '</table>';
?>
</body>
</html>