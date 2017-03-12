		<?php

$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthews';

$error = array();
	$connection = mysql_connect($dbhost,$dbuser,$dbpass);
	if(!$connection){
		die('connection was not successful: '.mysql_error());
	}
	echo('<h1>connection successful!!!</h1><br/>');
	if(isset($_POST['sub'])){
	$a=$_POST['one'];
	$b=$_POST['two'];
	$c=$_POST['three'];
	$d=$_POST['four'];
	if(empty($a)){
		$error[] = 'Row1 is missing';
	}
	if(empty($b)){
		$error[] = 'Row2 is missing';
	}
	if(empty($c)){
		$error[] = 'Row3 is missing';
	}
	if(empty($d)){
		$error[] = 'Row4 is missing';
	}
	$data = "INSERT INTO example(row1,row2,row3,row4)VALUES('$a',$b,$c,$d)";
	mysql_select_db('firstdb');
	$r = mysql_query($data,$connection);
	if($r){
		echo('<h2>Insertion successful!!!</h2>');
		}
	else{
	echo('<h2>Failed to insert<h2><br/><h3>Some fields are missing</h3>');
	foreach ($error as $msg) { // Print each error.
	echo " - $msg<br />\n";
 }
	require('test.php');
	}
	mysql_close($connection);
	}
?>
