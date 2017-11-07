 <?php 
require('../resources/php/master_script.php'); ?>

 <!DOCTYPE html>

<html>
<head>
<?php 
$pagetitle = 'Clients';
$ref = "clients_page";
require('../resources/global/meta-head.php');
?>
 <link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
 <link href="../css/clientlist_styles.css" type="text/css" rel="stylesheet" />
</head>
<body class="no-pic-background">

<?php
$showStaticHeader = true;
require('../resources/global/header.php'); ?>
  
  <div class="container-fluid body-content">
<div class="row">
<?php require('../resources/global/sidebar.php'); ?>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content">

<div class="row white-background margin-6">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
<h2 class="major-headings">Clients</h2>
</div>
<?php
if($status==1){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<?php echo $client_followers ?> followers
</div>
<?php
}
else if($status==9){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6  text-center">
<?php $followings ?>   followings
</div>
<?
}
else if($status==0){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<a href="../cta/checkin.php"><button class="btn btn-primary">Checkin</button></a>
	<p>or <a href="../login">login as an agent</a></p>
	</div>
	<?php
}
?>
</div>


<div class="row margin-5">
    <div class="col-lg-5 col-lg-offset-6 col-md-5 col-md-offset-6 col-sm-9 col-sm-offset-2 col-xs-12">
	<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<input class="form-control" id="client-search-input" type="search" placeholder="search for client"  onkeyup=""/>
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<button class="btn btn-primary" >search</button>
</div>
</div>
</div>
</div>


<?php
/****************************This part show agents their client follower*****************************************************************************/
if($status ==1){
    ?>
<div class="row">
<h3 class="container-headers">Followers</h3>
<?php
$get_client_followers = $db->query_object("SELECT * FROM client_agent_follow  LEFT JOIN cta_request ON (client_agent_follow.client_id = cta_request.ctaid) WHERE client_agent_follow.agent_id = $agentId");
if(is_object($get_client_followers)){
?>
<div class="row">
<?php
    if($get_client_followers->num_rows == 0){
 ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 client-follower-list" style="text-align:center; padding: 20px; color:grey;"> You do not have any client following you </div>
<?php      
    }
    else{
while($follower = $get_client_followers->fetch_array(MYSQLI_ASSOC) ){
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 client-follower-list">
<div class="row">
<div class = " col-lg-6 col-md-6 col-sm-6 col-xs-6 site-color font-18">
<span class="glyphicon glyphicon-user client-avatar"></span><?php echo $follower['client_name'] ?>
</div>
<div class = " col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
<?php
echo $property_obj->suggestProperty($agentId,$Business_Name,$profile_name,$agent_token,$follower['client_name'],$follower['client_id']);
?>
</div>
</div>

<div class="request-wrapper">
<span><span class="glyphicon glyphicon-question-sign red icon-size-20"></span>Request</span>
<?php if($follower['type'] != null && $follower['maxprice'] != 0 && $follower['location'] != null)
{
?>
<ul>
    <li>Type: <b><?php echo $follower['type'] ?></b></li>
    <li>Max price: <b><?php echo number_format($follower['maxprice']) ?></b></li>
    <li>Prefered location: <b><?php echo $follower['location'] ?></b></li>
     </ul>
<p class="time">Requested since: <?php echo $general->since(0)?></p>
<?php
 }
else{
    ?>
<p class="grey text-center">No Request yet</p>
    <?php
    }
    ?>
</div>
</div>
<?php
        }
    }
 ?>
</div>   
<?php
}
?>
</div>
<?php
}
/**_________________________________________________________________________________________________________________**/
?>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<img class="ads" src="../<?php echo ads::$ad001 ?>" alt="Advert will be placed here" />
</div>
</div>


<div class="row">	
    <h2 class="container-headings"><?php echo ($status==1 ? 'Other clients' :'') ?></h2>
<?php
$max = 10;
if(isset($_GET['next']) && $_GET['next'] >= 0 ){
	$start =$_GET['next'];
}
else{
	$start=0;
}
$end = $start + $max;
$x = $start;
$y = $x;
$i=0;

$clients_n_requests =  $db->query_object("SELECT * FROM cta LEFT JOIN cta_request USING (ctaid)");
$totalClients = $clients_n_requests->num_rows;


if(!$connection->error){
	while($client = $clients_n_requests->fetch_array(MYSQLI_ASSOC)){
	?>
<div class = " col-lg-12 col-md-12 col-sm-12 col-xs-12 clientbox ">

<div class="row">
 <div class = " col-lg-6 col-md-6 col-sm-6 col-xs-6 site-color font-18">
<span class="glyphicon glyphicon-user client-avatar"></span><?php echo $client['name'] ?>
</div>
<div class = " col-lg-6 col-md-6 col-sm-4 col-xs-6 text-right">
<?php if($status==1){ 
echo $property_obj->suggestProperty($agentId,$Business_Name,$profile_name,$agent_token,$client['name'],$client['ctaid']);
 } else {
 echo $property_obj->suggestProperty(null,null,null,null,$client['name'],$client['ctaid']);
 } 
 ?>
</div>
 
</div>

<div class="request-wrapper">
<span><span class="glyphicon glyphicon-question-sign red icon-size-20"></span>Request</span>
<?php if($client['type'] != null && $client['maxprice'] != 0 && $client['location'] != null)
{
?>
<ul>
    <li>Type: <b><?php echo $client['type'] ?></b></li>
    <li>Max price: <b><?php echo number_format($client['maxprice']) ?></b></li>
    <li>Prefered location: <b><?php echo $client['location'] ?></b></li>
     </ul>
 <p class="time">Requested since: <?php echo $general->since(0)?></p>
<?php
} 
 else{
    ?>
<p class="grey text-center">No Request yet</p>
  <?php
}
?>
</div>
</div>	
<?php
		$i++;
		$y++;
		if($i==5){
			?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<img src="../<?php echo ads::$ad004 ?>" alt="Advert will be placed here" width="100%" height="200px" />
</div>	
</div>
	<?php	}
	}
?>
	<p>showing <?php echo ($x+1)." - $y of $totalClients" ?> </p>

	<div class="next-prev-container">
	<?php
	if($x > 0 ){
		?>
<a class="previous" href="?next=<?php echo ($y-(2*$max) < 0 ? 0 :  $y-(2*$max)) ?>" >« prev</a>
<?php
	}
if( $y < $totalClients){
	?>
<a class="next" href="?next=<?php echo $y ?>" >next »</a>
<?php
}	
?>
</div>
<?php	
}
	else{
		?>
<h3 align="center">There was an error while getting clients</h3>
    <p align="center"><a href="#">Report</a> the problem</p>
<?php	
}

?>
	</div>
	
<?php require('../resources/global/footer.php') ?>
</div>	<!--main-content ends-->
</div><!--parent row ends-->
</div><!--container-fluid ends-->
</body>
</html>