var today = new Date();
var hourNow = today.getHours();
var greeting = document.getElementById('welcome');

if (hourNow > 18) {
	greeting.innerHTML = '<h3> Good evening! </h3>';
}	else if (hourNow > 12) {
	greeting.innerHTML = '<h3> Good afternoon! </h3>';
}	else if (hourNow > 0) {
	greeting.innerHTML = '<h3> Good morning! </h3>';
}	else {
	greeting.innerHTML = '<h3> Welcome! </h3>';
}

//document.write('<h3>' + greeting + '</h3>');