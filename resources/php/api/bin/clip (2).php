<?php
	require('../../master_script.php');

if(isset($_GET['p']) && isset($_GET['cb']) && isset($_GET['ref'])){

	$property = $_GET['p'];
	$by = $_GET['cb'];
	$ref = $_GET['ref'];
	$client_token = $_GET['tkn'];

//if cta is checked in
if(isset($_COOKIE['user_cta']) && $_COOKIE['user_cta']==$client_token){
$property = new property($property);
$property->clip($by,$client_token,$ref);
}
//if cta is not logged in
else{
	require('../../global/mini-checkin-form.html');
}
$db->close();
}
else{
	header("Location: $root");
	exit();
}

?>