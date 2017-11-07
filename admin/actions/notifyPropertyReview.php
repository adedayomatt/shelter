<?php
/*$agent = $_GET['ag'];
$agentId = $_GET['agid'];
$propertyDir = $_GET['p'];
*/
require('../../resources/php/site_config.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$oneDay = 86400;
$now = time();
$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
if(!$connection->error){
	require('../../resources/php/notification_handler.php');
	$i = 0;
	$p = $connection->query("SELECT properties.directory AS property_dir, properties.last_reviewed AS property_lr, profiles.Business_Name AS agentBN, profiles.ID AS agentid FROM properties LEFT JOIN profiles ON (properties.uploadby = profiles.User_ID)");
while($property = $p->fetch_array(MYSQLI_ASSOC)){
	$last_notified = $connection->query("SELECT timestamp FROM agent_notifications WHERE link = '".$property['property_dir']."'" );

//if last reviewed is more than 5 days
	if(($now - $property['property_lr']) >= 5*$oneDay){
//if the review notification have not been sent at all before or it's been 5 days the notification has been sent, snet it again
		if($last_notified->num_rows == 0){
		$notification_fb = send_agent_notification($connection,'nil','nil',0,$property['agentBN'],$property['agentid'],'RVN',$property['property_dir']);
		$i++;
		}
//if the notification has been sent before but no response yet after 2 days
else if(($now - $last_notified->fetch_array(MYSQLI_ASSOC)['timestamp']) >= 2*$oneDay ){
	//first delete the previously sent one
	$connection->query("DELETE FROM agent_notifications WHERE link = '".$property['property_dir']."'");
	//then insert a new fresh notification
	$notification_fb = send_agent_notification($connection,'nil','nil',0,$property['agentBN'],$property['agentid'],'RVN',$property['property_dir']);
	$i++;		
		}
	}
}
}
echo "$i total notifications sent";
?>