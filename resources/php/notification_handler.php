<?php
//This functions send notification


function send_client_notification($connection,$subject,$subject_username,$subject_id,$receiver,$receiver_id,$action,$link){
	$now = time();
	$nid = $now + rand(1000000,9999999);
	if($connection->query("SELECT notificationid FROM client_notifications WHERE (subject_id = '$subject_id' AND receiver_id = '$receiver_id' AND action = '$action' AND link = '$link')")->num_rows > 0){
		//first delete a notification like this to relieve the database
	$connection->query("DELETE FROM client_notifications WHERE (subject_id = '$subject_id' AND receiver_id = '$receiver_id' AND action = '$action')");
	}
	$notification_query ="INSERT INTO client_notifications (notificationid,subject,subject_username,subject_id,receiver,receiver_id,action,link,timestamp,status) VALUES ($nid,'$subject','$subject_username',$subject_id,'$receiver',$receiver_id,'$action','$link',$now,'unseen')";
	$connection->query($notification_query);
	}
function send_agent_notification($connection,$subject,$subject_username,$subject_id,$receiver,$receiver_id,$action,$link){
	$now = time();
	$nid =  $now + rand(1000000,9999999);
	if($connection->query("SELECT notificationid FROM agent_notifications WHERE (subject_id = '$subject_id' AND receiver_id = '$receiver_id' AND action = '$action' AND link = '$link')")->num_rows > 0){
		//first delete a notification like this to relieve the database
	$connection->query("DELETE FROM agent_notifications WHERE (subject_id = '$subject_id' AND receiver_id = '$receiver_id' AND action = '$action')");
	}
	$notification_query ="INSERT INTO agent_notifications (notificationid,subject,subject_username,subject_id,receiver,receiver_id,action,link,timestamp,status) VALUES ($nid,'$subject','$subject_username',$subject_id,'$receiver',$receiver_id,'$action','$link',$now,'unseen')";
	$connection->query($notification_query);
	if($connection->error){
		return $connection->error;
	}
}

?>