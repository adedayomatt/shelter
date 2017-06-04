<html>
<head>
<title>Admin | Activities</title>
<?php
$connect = true;
require('../require/connexion.php');
?>
</head>
<style>
h1#shelter{
	font-size:200%;
	font-weight:normal;
	letter-spacing:5px;
	color:white;
	text-decoration:none;
	text-align:center;
}
body{
	background-color:purple;
}
a{
	color:red;
	text-decoration:none;
}
.headings{
	font-weight:normal;
	letter-spacing:10px;
	color:yellow;
	margin:0px;
}
#sidemenu{
	border-right:1px solid yellow;
	height:100%;
	width:20%;
	margin-right:10px;
	float:left;
}
.sidemenulinks{
	display:block;
	padding:5px;
	text-decoration:none;
}
.sidemenulinks:hover{
	background-color:red;
	color:white;
}
#all-logs-container{
	width:70%;
	height: 70%;
	overflow-y:hidden;
	float:left;
	margin:auto;
	padding:2%;
}
#all-logs-container:hover{
	overflow-y:scroll;
}
.log-container{
	background-color:F5F5F5;
	padding:1%;
	margin-bottom:5px;
}
.log-container>a:visited{
	color:yellow;
}
.no-activity{
	color:red;
	text-align:center;
	font-size:150%;
	padding:5%;
	border-radius:5px;
}
</style>

<body>
<a style="text-decoration:none" href="http://192.168.173.1/shelter"><h1 id="shelter">shelter</h1></a>
<div id="sidemenu">
<h1 class="headings">Go To..</h1>
<a class="sidemenulinks" href="profiles">Agents profiles</a>
<a class="sidemenulinks" href="cta">CTAs</a>
<a class="sidemenulinks" href="properties">Properties</a>
</div>
<h1 class="headings">Activities</h1>
<div id="all-logs-container">
<?php

function activityTime($timestamp){
	$time = time() - $timestamp;
	if($time<60){
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = (int)($time/60).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = (int)($time/3600).' hours, '.(($time/60)%60).' minutes ago';
	}
	else if($time>=86400 && $time<604800){
		$since = date('l, M d ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('M d  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
	else{
		$since = "sometime ago";
	}
return $since;
		}

$getActivities = mysql_query("SELECT * FROM activities ORDER BY timestamp DESC");
if($getActivities){
	if(mysql_num_rows($getActivities) !=0){
while($log = mysql_fetch_array($getActivities,MYSQL_ASSOC)){
	$AID = $log['activityID'];
	$subject = $log['subject'];
	$subject_ID = $log['subject_ID'];
	$subject_Username = $log['subject_Username'];
	$status = $log['status'];
	$otherlink = ($log['otherlink'] !="n/a" ? $log['otherlink'] : "" );
	$time = activityTime($log['timestamp']);
	switch($log['action']){
	//Agent Account Opening
		case "AAO":
		$action = "signs up an account";
		break;
	//Client Account Opening
		case "CAO":
		$action = "signs up a CTA";
		break;
		case "upload":
		$action = "uploaded a <a href=\"$root/properties/$otherlink\">new property</a>";
		break;
	//Agent Report
		case "AR":
		$action = "reported an issue";
		break;
	//Client Report
		case "CA":
		$action = "reported an issue";
		break;
	}
	echo "<div class=\"log-container\"><a href=\"../$subject_Username\">$subject</a> $action <span style=\"float:right;color:grey;\">$time</span></div>";
}
	}
	else{
		echo "<div class=\"log-container no-activity\" >No unseen activities in the log yet</div>";
	}
}else{
	echo "<div class=\"log-container no-activity\">Something is wrong in your query</div>";
}

?>
</div>

</body>
</html>