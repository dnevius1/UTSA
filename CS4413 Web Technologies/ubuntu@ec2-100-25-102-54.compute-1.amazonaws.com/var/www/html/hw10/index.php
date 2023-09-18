<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP Form Input</title>
</head>
<body>
<?php
if (!isset($_POST['submit']))
{

	echo '<form action="" method="post">';
	echo '<p>First Name: <input type="text" name="firstName" id="firstName" class="firstName"/></p>';
	echo '<p>Last Name: <input type="text" name="lastName"/></p>';
	echo '<p>Email Address: <input type="text" name="email"/></p>';
	echo '<p>Phone Number: <input type="text" name="phone"/></p>';
	echo '<p><button type="submit" name="submit" value="submit">Submit</button><p>';
	echo '</form>';
}
elseif (isset($_POST['submit']))
{
	$firstname=$_POST['firstName'];
	$lastname=$_POST['lastName'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	echo "<h3>Data Received from Index.php</h3>";
	echo "<p>First Name: $firstname</p>";
	echo "<p>Last Name: $lastname</p>";
	echo "<p>Email: $email</p>";
	echo "<p>Phone Number: $phone</p>";
}
?>
</body>
</html>