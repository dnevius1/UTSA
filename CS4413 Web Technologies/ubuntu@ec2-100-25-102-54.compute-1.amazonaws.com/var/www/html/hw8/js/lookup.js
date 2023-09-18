// JavaScript Document
function lookup() {
	var fName=document.getElementById("firstName");
	var lName=document.getElementById("lastName");
	var output=document.getElementById("output");
	output.innerHTML='<h3>You Entered: '+fName.value+' '+lName.value+'</h3>';
}