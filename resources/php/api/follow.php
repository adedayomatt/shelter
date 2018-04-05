<?php
	require('api_tools.php');
	
		$follower_id=$_GET['flwerId'];
		$follower_name = $_GET['flwer'];
		$follower_username = $_GET['flwerUname'];

		$following_id = $_GET['flwingId'];
		$following_name = $_GET['flwing'];
		$following_username = $_GET['flwingUname'];

		$type = $_GET['t'];
        $now = time();

if($follower_id == 'nil' && $following_id == 'nil'){
	?>
	<div class="text-center">
	<h3>You are not logged as a agent or client.</h3>
	<a class="btn btn-lg btn-block opac-3-site-color-background site-color" href="<?php echo $root.'/login'?>">Login as Agent</a> 
	<a class="btn btn-lg btn-block opac-3-site-color-background site-color"  href="<?php echo $root.'/cta/checkin.php'?>">Checkin as Client</a>
	</div>
	<?php
	exit();
}

$connection = connect();
 
if($connection->connect_error){
	return '<br/>connection failed!';
}
else{
require('../notification_handler.php');
$follower_name = $connection->real_escape_string($follower_name);
$following_name = $connection->real_escape_string($following_name);
switch($type){
	case 'A4A':
$check_follow_query = "SELECT * FROM agent_agent_follow WHERE (agent_follower_id = $follower_id AND agent_following_id = $following_id)";

$follow_query = "INSERT INTO agent_agent_follow (agent_follower_id,agent_follower_business_name,agent_follower_username,agent_following_id,agent_following_business_name,agent_following_username,timestamp) 
					VALUES ($follower_id,'$follower_name','$follower_username',$following_id,'$following_name','$following_username',$now)";

$unfollow_query = "DELETE FROM agent_agent_follow WHERE(agent_follower_id=$follower_id AND agent_following_id =$following_id)";

$total_follow_query = "SELECT * FROM agent_agent_follow WHERE (agent_follower_id = $follower_id)";

break;
case 'C4A':
$check_follow_query = "SELECT * FROM client_agent_follow WHERE (client_id = $follower_id AND agent_id = $following_id)";

$follow_query = "INSERT INTO client_agent_follow (client_id,client_name,agent_id,agent_business_name,agent_username,timestamp) 
					VALUES ($follower_id,'$follower_name',$following_id,'$following_name','$following_username',$now)";

$unfollow_query = "DELETE FROM client_agent_follow WHERE(client_id=$follower_id AND agent_id =$following_id)";

$total_follow_query = "SELECT * FROM client_agent_follow WHERE (client_id = $follower_id)";
break;
}


$check_follow = $connection->query($check_follow_query);
	if($connection->error){
echo "can't check for follow";
	}
	else{
	//if no follow
		if($check_follow->num_rows == 0){
			//follow
$follow = $connection->query($follow_query);
if(!$connection->error){
	if($type=='C4A'){
		send_agent_notification($connection,$follower_name,'nil',$follower_id,$following_name,$following_id,$type,'nil');
	}
	else if($type=='A4A'){
		send_agent_notification($connection,$follower_name,$follower_username,$follower_id,$following_name,$following_id,$type,'nil');
	}
	$total_follow = $connection->query($total_follow_query)->num_rows;
				echo "positive/$total_follow";
			}
			else{
				//insert failed!
				echo '<br/>insert failed! because: '.$connection->error;
			}
		}
		else{
			//following already, unfollow
			$connection->query($unfollow_query);
	//if no error
			if(!$connection->error){
	$total_follow = $connection->query($total_follow_query)->num_rows;
				echo "negative/$total_follow";
			}else{
				echo "cannot unfollow because: ".$connection->error;
			}
		}
	}

}


















/*

$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthew';
$db_connection = @mysqli_connect($dbhost, $dbuser, $dbpass);
if($db_connection){
	if(isset($_GET['flwer']) && isset($_GET['flwing'])){
		$follower=mysqli_real_escape_string($_GET['flwer']);
		$followerid=mysqli_real_escape_string($_GET['flwerId']);
		$following= mysqli_real_escape_string($_GET['flwing']);
		$type = mysqli_real_escape_string($_GET['t']);
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
*/
?>