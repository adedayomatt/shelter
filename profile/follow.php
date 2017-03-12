<?php
$connect=true;
require('../require/connexion.php');
	if(isset($_GET['flwer']) && isset($_GET['flwing'])){
		$follower=mysql_real_escape_string($_GET['flwer']);
		$followerid=mysql_real_escape_string($_GET['flwerId']);
		$following= mysql_real_escape_string($_GET['flwing']);
		$type = mysql_real_escape_string($_GET['t']);
		$goback = mysql_real_escape_string($_GET['r']);
//if already following...
	if(mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$follower' AND following='$following'"))>=1){
//...then unfollow
		if(mysql_query("DELETE FROM follow WHERE(follower='$follower' AND following ='$following')")){
		header("location: http://localhost/shelter/$goback");
		exit();
	}
	}
//if not following before, start following
	else{
	if(mysql_query("INSERT INTO follow (follower,following,followtype) VALUE ('$follower','$following','$type')")){
		$time = time();
		$id = uniqid($type);
//send notification
$action=$type.'follow';
mysql_query("INSERT INTO notifications (notificationid,subject,subjecttrace,receiver,action,status,time) VALUE ('$id','$follower','$followerid','$following','$action','unseen',$time)");
		header("location: http://localhost/shelter/$goback");
		exit();
	}
	}
	}	 
	else{
		echo 'could not follow';
	}

?>