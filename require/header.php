
<script type="text/javascript" language="javascript" src="http://localhost/shelter/js/jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function(){
$('#acct-dropdown').click(function(){
	$('#acct-dropdown-box').toggle();
	});
	/*	
$('#menuicon').click(function(){
	$('#sidebar-original').css({'position':'absolute'});
	$('#top-nav-bar-content').css({'position':'relative'});
	$('#sidebar-original').toggle();
		});	*/
});

</script>
<?php
function redirect(){
	header("location: http://192.168.173.1/shelter/login");
	//header("location: http://localhost/shelter/login");
	exit();
}

//since this headeer scripts will always be required by scripts other than the homepage
if(!isset($ref)){
	 require('connexion.php');
}else{
	require('connexion.php');
}

//if user is logged in as an agent
if(isset($_COOKIE['name']) ){
	$status = 1;
	 $profile_name=$_COOKIE['name'];
//if this header is required from a page where the Business name is needed, get it!
	 if(isset($getuserName) && $getuserName==true){
		 $getBussinessName = mysql_query("SELECT ID,Business_Name FROM profiles WHERE (User_ID='$profile_name')");
		 if($getBussinessName && mysql_num_rows($getBussinessName)==1){
			 $biz = mysql_fetch_array($getBussinessName,MYSQL_ASSOC);
				 $Business_Name = $biz['Business_Name'];
				 $myid  = $biz['ID'];
		 }else{
			 $Business_Name = "couldn't reach profile";
		 }
}
//get the number of notifications, followers, following corresponding to the user
$messages = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver='$Business_Name' AND status='unseen'"));
$notifications = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE receiver='$Business_Name' AND status='unseen'"));	 
 $following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$Business_Name'"));	
 $clientfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$Business_Name' AND followtype='C4A'"));	
 $agentfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$Business_Name' AND followtype='A4A'"));	
		
	}
//if a CTA account is logged in
else if(isset($_COOKIE['CTA'])) {
	$ctaid = $_COOKIE['CTA'];
	$status = 9;
//get CTA data
if(isset($getuserName) && $getuserName==true){
	$CTAmatches = array();
$matchcounter = 0;
	$k=0;
//get CTA 	
$getCTA = mysql_query("SELECT ctaid,name,request FROM cta WHERE (ctaid='$ctaid')");
	 if($getCTA && mysql_num_rows($getCTA)==1){
//if CTA is found...
	 if(mysql_num_rows($getCTA)==1){
			 $cta = mysql_fetch_array($getCTA,MYSQL_ASSOC);
				 $ctaname = $cta['name'];
				 $myid  = $cta['ctaid'];
				 $rqstatus = $cta['request'];
//if request has been placed
if($rqstatus==1){
//get request 
$rq = mysql_query("SELECT * FROM cta_request WHERE (ctaid='$ctaid')");
if($rq){
$request = mysql_fetch_array($rq,MYSQL_ASSOC);
 $rqtype = $request['type'];
 $rqpricemax = $request['maxprice'];
 $rqlocation = $request['location'];
 
		}
	}
 //get matches id after the requests data has been retrieved and get the number of rows that mathes the request
if(isset($rqtype) && isset($rqpricemax) && isset($rqlocation)){
$getCTAmatches = mysql_query("SELECT property_ID FROM properties WHERE (type='$rqtype' AND rent<=$rqpricemax AND location LIKE '%$rqlocation%')");
	$matchcounter = mysql_num_rows($getCTAmatches);
	while($match=mysql_fetch_array($getCTAmatches,MYSQL_ASSOC)){
		$CTAmatches[$k]=$match['property_ID'];
		$k++;
	}
			 }
				}
		 
//get clipped
$getclipped = mysql_query("SELECT * FROM clipped WHERE clippedby='$ctaid'");
if($getclipped){
	$c = 0;
	$clipcounter = mysql_num_rows($getclipped);
	while($clipped = mysql_fetch_array($getclipped,MYSQL_ASSOC)){
		$clippedproperty[$c] = $clipped['propertyId'];
		$c++;
	}
}
else{
	$clipcounter = 999;
}
$messages = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver='$ctaname' AND status='unseen'"));
	$notifications = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE receiver='$ctaname' AND status='unseen'"));
$following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$ctaname'"));

}
else{
	//if the cta info cannot be get, clear cookie and redirect to checkin
	setcookie('CTA',"",time()-60,"/","",0);
		header("location: $root/cta/checkin.php");
	mysql_close($db_connection);
	exit();
		 }
}
}
 //if user is not logged in as either agent or client
else{
	$status = 0;
}
?>
<title>Shelter | <?php echo $pagetitle; ?></title>
<div class="top-nav-bar" id="top-nav-bar-content">

<i class="white-icon" id="menuicon"></i><div id="templogo"><a href="<?php echo $root ?>"><i><h1 style="display:inline; color:white;">Shelter</h1><h6 style="display:inline; color:white;" >.com</h6></i></a></div>
<div id="menus">
<ul id="nav-bar">
<a  href="<?php echo $root ?>" title="Home"><li class="nav-menu">Home</li></a>
<?php if($status==1){
//if user is logged, include this menu on the nav-bar
	echo "<a href=\"$root/$profile_name\" title=\"$profile_name\"> <li class=\"nav-menu\">Profile</li></a>";
}?>
<a href="<?php echo $root."/agents"; ?>" title="Agents"><li class="nav-menu" >Agents</li></a>
<a href="#" title="Contacts"><li class="nav-menu" >Contacts</li></a>
<a href="#" title="About"><li class="nav-menu" >FAQs</li></a>
<style>
#notification{
	padding-top:15px;
	padding-left:50px;
	color:white;
	font-size:10px;
	font-weight:bold;
	margin-left:20px;
}
#notifications-icon{
	background-position:-48px -144px;
}
</style>
<?php
if($status==1 || $status==9){
	echo "<a href=\"$root/notifications\"><li id=\"notification\">$notifications<i class=\"white-icon\" id=\"notifications-icon\"></i></li></a>";
}
 ?>
</ul>
</div>
</div>
<div class="top-nav-bar" id="top-nav-bar-under" ></div>
<?php
if($status == 0){
 //echo "<div style=\"width:20%;margin:0\"><marquee style=\"font-size:12px; color:red\"><i><b>*NOTICE: you are currently not logged in as agent</b></i></marquee></div>";
}
?>
