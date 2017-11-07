
<?php

/*
This script is for suggestion property, it uses GET method the index of the GET array are:

client, ---------->client name
cid, ------------->client id
ag_Bname ----------?agent Business name
ag_name, --------->agent username
aid, ------------->agent id
tkn, ------------->agent token

First created: 2nd Aug, 2017 ; 8:13PM
*/

$clientname = $_GET['client'];
$clientid = $_GET['cid'];
$propertyid = $_GET['pid'];
$propertydir = $_GET['pdir'];
$agent_Bname = $_GET['ag_Bname'];
$agent_username = $_GET['ag_name'];
$agentid = $_GET['aid'];
$token = $_GET['tkn'];


$now = time();
if(isset($_COOKIE['user_agent']) && $token == $_COOKIE['user_agent'])
{
require('../site_config.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
if(!$connection->connect_error){
if($connection->query("SELECT client_id FROM property_suggestion WHERE (client_id = $clientid AND property_id = '$propertyid')")->num_rows == 1){
    echo "Already suggested";
}
//if not already suggested
else{
$q = "INSERT INTO property_suggestion (client_name, client_id, property_id,agent,agent_id,timestamp) 
     VALUES('$clientname',$clientid,'$propertyid','$agent_username',$agentid,$now)";
$insert_suggestion = $connection->query($q);

if(!$connection->error && $connection->affected_rows == 1){
		require('../notification_handler.php');
	send_client_notification($connection,$agent_Bname,$agent_username,$agentid,$clientname,$clientid,'PSG',$propertydir);

	echo "Suggested";
	
}
else{
    echo "<span class=\"white-icon warning-icon\"></span>Failed";
            }
        }
 }
else{
    echo "<span class=\"white-icon warning-icon\"></span> No connection";
            }

}
//if agent is not logged in
else{
require('../../html/mini-login-form.html');
}

$connection->close()
?>