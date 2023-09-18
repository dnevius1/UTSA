<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP Form Input</title>
</head>
<body>
<?php
$firstname = $lastname = $email = "";
$fnameErr = $lnameErr = $emailErr = "";


if (!isset($_POST['submit']))
{
	echo '<form action="" method="post" action="<?php echo htmlspecialchars(#_SERVER["PHP_SELF"]);?>';
	if (isset($_POST['firstname']))
		echo '<p>First Name: <input type="text" name="firstname" value="'.$_POST['firstname'].'"/></p>';
	else
	{
		if (isset($_REQUEST['fnameErr']))
		{
			echo '<p>First Name: <input type="text" name="firstname" id="firstName" class="firstName"/></p>';
			echo '<p><span style="color:#F00">First name cannot be blank!</span></p>';
		}
		else
			echo '<p>First Name: <input type="text" name="firstname" id="firstName" value="'.$_REQUEST['firstname'].'"/></p>';
	}
	if (isset($_POST['lastname'])) //will get executed on reload
		echo '<p>Last Name: <input type="text" name="lastname" value="'.$_POST['lastname'].'"/></p>';
	else//gets executed if it is initial load
	{
		if (isset($_REQUEST['lnameErr']))
		{
			echo '<p>Last Name: <input type="text" name="lastname" id="lastName" class="lastName"/></p>';
			echo '<p><span style="color:#F00">Last name cannot be blank!</span></p>';
		}
		else //initial load
			echo '<p>Last Name: <input type="text" name="lastname" value="'.$_REQUEST['lastname'].'"/></p>';
	}
	if (isset($_POST['email']))
		echo '<p>Email Address: <input type="text" name="email value="'.$_POST['email'].'"/></p>';
	else
		if (isset($_REQUEST['emailErr']))
		{
			echo '<p>Email Address: <input type="text" name="email"/></p>';
			echo '<p><span style="color:#F00">Email cannot be blank!</span></p>';
		}
		else
			echo '<p>Email Address: <input type="text" name="email" value="'.$_REQUEST['email'].'"/></p>';
	echo '<p><button type="submit" name="submit" value="submit">Submit</button><p>';
	echo '</form>';
}
elseif (isset($_POST['submit']))
{

	$errString="";
	if ( ($firstname=$_REQUEST['firstname']) == "")
		$errString.="fnameErr=true&";
	if ( ($lastname=$_REQUEST['lastname']) == "")
		$errString.="lnameErr=true&";
	if ( ($email=$_REQUEST['email']) == "")
		$errString.="emailErr=true&";
	if ($errString!="")
		header("Location: https://ec2-100-25-102-54.compute-1.amazonaws.com/hw11/index.php?$errString&firstname=$_REQUEST[firstname]&lastname=$_REQUEST[lastname]&email=$_REQUEST[email]");
	echo "<h3>Data Received from Index.php</h3>";
	echo "<p>First Name: $firstname</p>";
	echo "<p>Last Name: $lastname</p>";
	echo "<p>Email: $email</p>";
}
?>
</body>
</html>