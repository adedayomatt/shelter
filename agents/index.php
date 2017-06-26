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
$pagetitle = 'Registered Agents';
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
$BizName = array();
 $OAddress = array();
 $OTel = array();
 $Omail = array();
	$CEO = array();
$Phone = array();
$Phone2 = array();
$email = array();
$user_id = array();
$password = array();

$fetchprofiles = mysql_query("SELECT * FROM profiles");
$count = 0;
if($fetchprofiles){
	while($user = mysql_fetch_array($fetchprofiles,MYSQL_ASSOC)){
		$ID = $user['ID'];
		$BizName[$count] = $user['Business_Name'];
		$OAddress[$count] = $user['Office_Address'];
		$OTel[$count] = $user['Office_Tel_No'];
		$Omail [$count]= $user['Business_email'];
		$CEO[$count] = $user['CEO_Name'];
		$Phone[$count] = $user['Phone_No'];
		$Phone2[$count] = $user['Alt_Phone_No'];
		$email[$count] = $user['email'];
		$user_id[$count] = $user['User_ID'];
		$password[$count] = $user['password'];
		$timestamp[$count] = $user['timestamp'];
		$count++;
	}
//display the records
$j = 0;
$max = 10;
if(isset($_GET['next'])){
	$i =$_GET['next'];
}
else{
	$i=0;
}
if($i>=0){
while($i < $count){
		$profile = "<div class = \"Agentbox\"><div class=\"contacts-container\">
		 <ul>
		<li><a href=\"$root/".$user_id[$i]."\"><h4 class=\"Bname\">".$BizName[$i]."</h4></a>
		<span class=\"follow-unfollow-button\"><span class=\"black-icon follow-icon\"></span>Follow</span>
		<ul>
		<li class=\"Agent_Address\"><span class=\"black-icon location-icon\"></span> ".$OAddress[$i]."</li>
		<li class=\"acontact\">Contact
		<ul>
		<li class=\"tel\">Tel: ".$OTel[$i]."</li>												
		<li class=\"email\">e-mail: ".$Omail[$i]."</li>
		 </ul>
		 </li>
		 </ul>
		 </ul>
		 </div>
		 <span class=\"time\"> Shelter agent since: ".Timestamp($timestamp[$i])."</span>
		 </div>";
		echo $profile;
			$i++;
			$j++;
		if($j==3){
			echo "<a href=\"adone.html\"><img src=\"../image/images5.jpeg\" alt=\"Advert will be placed here\" class=\"ad\" ></img></a>";
		}
			if($j==$max){
				break;
			}
}
}
}
	else{
echo "<h3 align=\"center\">There was an error while fetching profiles</h3>
    <p align=\"center\"><a href=\"#\">Report</a> the problem</p>";
}

?>

<div class="Navigate">
<form  class="prev" action="<?php $_PHP_SELF ?>" method="get">
	<input name="next" type="hidden" value="<?php echo $i-($max*2) ?>"/>
	<input type="submit" value="<<Prev"/>
	</form>	
	
	<form class="nxt" action="<?php $_PHP_SELF ?>" method="get">
	<input name="next" type="hidden" value="<?php echo $i ?>"/>
	<input type="submit" value="Next>>"/>
	</form>	
	</div>	
	<style>
	.prev{
		display:inline;
		float:left
		margin-left:10px;
	}
	.nxt{
		display:inline;
		float:right;
		margin-right: 10px;
	}
	</style>
	</div>
	<?php require('../require/footer.html');
	mysql_close($db_connection);
	?>
			</div>
		
			
			</body>
		</html>