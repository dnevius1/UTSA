// JavaScript Document
function calculate() {
	var num1=document.getElementById("firstNumber"); //object
	var num2=document.getElementById("secondNumber"); //object
	var output=document.getElementById("output");  //object
	var answer=num1.value*num2.value; //variable
	output.innerHTML='<h3>Your result is: '+answer+'</h3>;
}