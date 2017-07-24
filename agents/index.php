 <!DOCTYPE html>
 <?php 
$connect = true;
require('../require/connexion.php'); ?>
<html>
<?php require('../require/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
 <link href="../css/agentlist_styles.css" type="text/css" rel="stylesheet" />
 <link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php 
$pagetitle = 'Agents';
$ref = "agentspage";
$connect=true;
$getuserName=true;
require('../require/header.php');
?>
</head>
<body class="no-pic-background">
<?php require('../require/sidebar.php'); ?>

<div class="maincontent">
<h3 style="font-weight:normal;">Agents</h3>
<div class="mainlist">	
<?php

$max = 10;
$i = 0;
if(isset($_GET['next']) && $_GET['next'] >= 0 ){
	$start =$_GET['next'];
}
else{
	$start=0;
}
$end = $start + $max;
$totalAgents = mysql_num_rows(mysql_query("SELECT User_ID FROM profiles"));
$fetchprofiles = mysql_query("SELECT * FROM profiles LIMIT $start,$end");
$x = $start;
$y = $x;
if($fetchprofiles){
	while($agent = mysql_fetch_array($fetchprofiles,MYSQL_ASSOC)){
	$profile = "<div class = \"Agentbox\"><div class=\"contacts-container\">
		 <ul>
		<li><a href=\"$root/".$agent['User_ID']."\"><h4 class=\"Bname\">".$agent['Business_Name']."</h4></a>
		<span class=\"follow-unfollow-button\"><span class=\"black-icon follow-icon\"></span>Follow</span>
		<ul>
		<li class=\"Agent_Address\"><span class=\"black-icon location-icon\"></span> ".$agent['Office_Address']."</li>
		<li class=\"acontact\">Contact
		<ul>
		<li class=\"tel\">Tel: ".$agent['Office_Tel_No']."</li>												
		<li class=\"email\">e-mail: ".$agent['Business_email']."</li>
		 </ul>
		 </li>
		 </ul>
		 </ul>
		 </div>
		 <span class=\"time\"> Shelter agent since: ".Timestamp($agent['timestamp'])."</span>
		 </div>";
		echo $profile;
		$i++;
		$y++;
		if($i==3){
		echo "<a href=\"adone.html\"><img src=\"../image/images5.jpeg\" alt=\"Advert will be placed here\" class=\"ad\" ></img></a>";
		}
	}
	echo "<p style=\"display:block\">showing ".($x+1)." - $y of $totalAgents</p>";
	echo "<div class=\"next-prev-container\">";
	if(isset($_GET['next']) && $_GET['next'] > 0 ){
		echo "<a class=\"previous\" href=\"?next=".($start-$max)."\" >« prev</a>";
	}
if( !isset($_GET['next']) || $y < $totalAgents){
	echo "<a class=\"next\" href=\"?next=$y\" >next »</a>";
}	
echo "</div>";
	
}
	else{
echo "<h3 align=\"center\">There was an error while fetching profiles</h3>
    <p align=\"center\"><a href=\"#\">Report</a> the problem</p>";
}

?>

	</div>
	<?php require('../require/footer.html');
	mysql_close($db_connection);
	?>
			</div>	
			</body>
		</html>