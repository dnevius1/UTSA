<?php

if (isset($_GET['submit']))
{
	$firstname=$_GET['firstName'];
	$lastname=$_GET['lastName'];
	$email=$_GET['email'];
	echo "<h3>Data Received from Index.php</h3>";
	echo "<p>First Name: $firstname</p>";
	echo "<p>Last Name: $lastname</p>";
	echo "<p>Email: $email</p>";
}
else
	echo '<h3>No Data Received</h3>';

?>