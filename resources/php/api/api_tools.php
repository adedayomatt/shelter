<?php
require('../../mato/lib/php/param.php');
	
function connect(){
	$HOST = config::$db_host;
	$USER = config::$db_user;
	$PASSWORD =config::$db_password;
	$DBN = config::$db_name;

	$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
	return $connection;
}

?>