<?php
$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthews';
$db_connection = @mysql_connect($dbhost, $dbuser, $dbpass);
if($db_connection){
	if(isset($_GET['flwer']) && isset($_GET['flwing'])){
		$follower=mysql_real_escape_string($_GET['flwer']);
		$followerid=mysql_real_escape_string($_GET['flwerId']);
		$following= mysql_real_escape_string($_GET['flwing']);
		$type = mysql_real_escape_string($_GET['t']);
		//$goback = mysql_real_escape_string($_GET['r']);
//if already following...
mysql_select_db('shelter');
	if(mysql_num_rows(mysql_query("SELECT * FROM follow WHERE (follower='$follower' AND following='$following')"))>=1){
//...then unfollow
		if(mysql_query("DELETE FROM follow WHERE(follower='$follower' AND following ='$following')")){
			echo "negative";		
		}
	}
//if not following before, start following
	else{
	if(mysql_query("INSERT INTO follow (follower,following,followtype) VALUE ('$follower','$following','$type')")){
		$time = time();
		$id = uniqid($type);
//send notification
//the subjecttrace is to create link to the subject of the notification when rendering it to the target
$action=$type.'follow';
mysql_query("INSERT INTO notifications (notificationid,subject,subjecttrace,receiver,action,status,time) VALUE ('$id','$follower','$followerid','$following','$action','unseen',$time)");
		echo "positive";
		
	}
	}
	}	 
	else{
		echo 'could not follow';
	}
mysql_close($db_connection);
}
else{
	echo 'error connecting to the server';
}
?>