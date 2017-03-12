 <!DOCTYPE html>
<html>
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
<br/>
<input name="searchagent" size="40" type="search" placeholder="Search for an Agent"/><input value="Go" type="submit"/>
<p align="center" style="font: Arial">The following Land and Estate Agents are duly registered under the Corporate Affairs Commision and with Shelter. <a class="learn" href="criteria.html">Learn more</a> on criteria for registering our agents </p>
	<hr/>
<div class="maincontent">
<div class="mainlist">	
<button type="button" autofocus="autofocus" value="refresh" onclick="javascript:location.reload(true)" style="border:none; cursor:pointer; background-color:inherit; display:inline; float:right;"><i style="display:inline-block;width:14px;height:14px;background-image:url('../resrc/black-icons.png');background-position:-216px -24px;"></i>Refresh</button>
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
		$count++;
	}
//display the records
$j = 0;
$max = 3;
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
		<li><h4><a href=\"$root/".$user_id[$i]."\">[".($i+1)."]  ".$BizName[$i]."</a></h4>
		<ul>
		<li class=\"Agent_Address\">Office Address: ".$OAddress[$i]."</li>
		<li class=\"acontact\">Contact
		<ul>
		<li class=\"tel\">Tel: ".$OTel[$i]."</li>												
		<li class=\"email\">e-mail: ".$Omail[$i]."</li>
		 </ul></li></ul></ul><hr/></div>
		<div class=\"fav-container\">options will be placed here</div>
		 </div>";
		echo $profile;
			$i++;
			$j++;
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
<div align="center" class="RHSr">
<h3>Ads</h3><p size="10px"><a href="advert.html">Place your advert here</a></p>
<a href="adone.html"><img src="../image/images5.jpeg" height="25%" width="100%" ></img></a>
<a href="adtwo.html"><img src="../image/images6.jpeg" height="25%" width="100%"></img></a>
<a href="adthree.html"><img src="../image/images7.jpeg" height="25%" width="100%"></img></a>
</div>
			</div>
			</body>
	<?php require('../require/footer.html');
	mysql_close($db_connection);
	?>
			</html>