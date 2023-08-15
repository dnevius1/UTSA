<?php
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$url=$_SERVER['REQUEST_URI']; //request URI component of URL
$path=parse_url($url,PHP_URL_PATH);
$pathComponents=explode("/",trim($path,"/"));
$endPoint=$pathComponents[1]; //Take the value at index 1 in the array and assign to endPoint variable
function db_iconnect($dbName)
{
	$un="webuser";
	$pw="!Ra/hRdebnnICOzV";
	$db=$dbName;
	$hostname="localhost";
	$dblink=new mysqli($hostname,$un,$pw,$db);
	return $dblink;
}
switch($endPoint)
{
	case "search":
		include("search.php");
		break;
	default:
		$output[]='Status: Error';
		$output[]='MSG: '.$endPoint.' Endpoint Not Found';
		$output[]='Action: None';
		$responseData=json_encode($output);
		echo $responseData;
}
?>