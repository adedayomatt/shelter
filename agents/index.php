 <?php 
require('../resources/php/master_script.php'); ?>

 <!DOCTYPE html>

<html>
<head>
<?php 
$pagetitle = 'Agents';
$ref = "agents_page";
require('../resources/global/meta-head.php'); ?>
<link href="../css/agentlist_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
</head>

<body class="no-pic-background">
<?php
$showStaticHeader = true;
 require('../resources/global/header.php'); ?>

  <div class="container-fluid body-content">
<div class="row">

<?php require('../resources/global/sidebar.php'); ?>
<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content">
<div class="row white-background e3-border padding-5 margin-6">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
<h2 class="major-headings">Agents</h2>
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
<?php echo $followings ?> followings
</div>
<?php
}
else  if($status==0){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<a href="../login"><button class="btn btn-primary">Login</button></a>
	<p>or <a href="../cta/checkin.php">checkin as a client</a></p>
	</div>
<?php
}
?>
</div>

<div class="row">	
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
$totalAgents = $db->query_object("SELECT User_ID FROM profiles")->num_rows;
$fetchprofiles = $db->query_object("SELECT * FROM profiles LIMIT $start,$end");

if(!$connection->error){
	while($ag = $fetchprofiles->fetch_array(MYSQLI_ASSOC)){
	?>
	<div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12 Agentbox">
	<div class="Agentbox-inner">
	<div class="row">
	<div class="row">
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	
	<a href="<?php echo $root.'/'.$ag['User_ID'] ?>">
	<h4 class="Bname"><span class="glyphicon glyphicon-briefcase agent-avatar"></span><?php echo $ag['Business_Name']?></h4>
	</a>
	
	</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
		<?php 
if($status == 1){
	echo $agent->follow($agentId,$Business_Name,$profile_name,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'A4A');
}
else if($status==9){
	echo $agent->follow($ctaid,$cta_name,null,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'C4A');
}
else{
	echo $agent->dummy_follow();
}
 ?>
	</div>
	</div>
	

	<div class="row" style="padding:10px">
		<ul class="no-padding">
		<li><span class="glyphicon glyphicon-map-marker"></span> <?php echo $ag['Office_Address'] ?></li>
		<li>Contact
		<ul>
		<li><span class="glyphicon glyphicon-earphone"></span>Tel:<?php echo $ag['Office_Tel_No'] ?></li>												
		<li><span class="glyphicon bold">@</span>e-mail: <?php echo $ag['Business_email'] ?></li>
		 </ul>
		 </li>
		 </ul>
	
		 </div>
		 </div>
<div class="row">
		 <span class="time"> Shelter agent since: <?php echo $general->since($ag['timestamp']) ?></span>
		 </div>
		 
		 </div>
		 </div>
		<?php
		$i++;
		$y++;
		if($i==3){
			?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<img src="<?php echo $root.'/'.ads::$ad003 ?>" alt="Advert will be placed here" class="ads" />
	</div>
	<?php	}
	}
?>
	<div class="next-prev-container">
	<p style="display:block">showing <?php echo ($x+1)." - $y of $totalAgents" ?> </p>
	<?php
	if($x > 0 ){
		?>
<a class="previous" href="?next=<?php echo ($y-(2*$max) < 0 ? 0 :  $y-(2*$max)) ?>" >« prev</a>
<?php
	}
if( $y < $totalAgents){
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
<h3 align="center">There was an error while fetching profiles</h3>
    <p align="center"><a href="#">Report</a> the problem</p>
<?php	
}

?>
	</div>
<?php require('../resources/global/footer.php') ?>
</div><!--main-content-->
</div><!--parent row-->
</div><!--container-fluid body-content-->
</body>
</html>