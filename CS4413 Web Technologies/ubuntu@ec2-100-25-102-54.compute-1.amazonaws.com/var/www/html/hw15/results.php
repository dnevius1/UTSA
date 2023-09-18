<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="assets/css/bootstrap.css" rel="stylesheet"/>
<link href="assets/css/bootstrap-theme.css" rel="stylesheet"/>
<script src="assets/js/jquery-3.5.1.js"></script>
<title>Results</title>
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
<div class="panel panel-default">
<div class="panel-body">
<h3 align="center">Contact Form Data Results</h3>
<table border="1" width="100%">
		<tr>
			<th>Id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Comments</th>
		</tr>
	<tbody id="results">
	</tbody>
</table>
</div>
</div>
</body>
</html>
<script>
	function refresh_table() {
	$.ajax({
		type: 'post',
		url: 'https://ec2-100-25-102-54.compute-1.amazonaws.com/hw15/query.php',
		success: function(data){
			$('#results').html(data);//document.getElementById('results').innerHTML=data
		}
	});
	};
	setInterval(function(){ refresh_table(); }, 500);
</script>