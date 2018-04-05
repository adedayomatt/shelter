 <?php 
require('../resources/master_script.php'); ?>

 <!DOCTYPE html>

<html>
<head>
<?php 
$pagetitle = 'Agents';
$ref = "agents_page";
require('../resources/global/meta-head.php'); ?>
</head>

<body>
<?php
$showStaticHeader = true;
 require('../resources/global/header.php'); ?>

  <div class="container-fluid pad-lg pad-md pad-sm no-pad-xs">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="white-background e3-border-bottom padding-5">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
<h4 class="text-left">Agents</h4>
</div>
<?php
if($status==1){
?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
<div class="padding-10-0 text-center bold">
<?php echo count($loggedIn_agent->agent_followers()) ?><br/> followers
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
<div class="padding-10-0 text-center bold">
<?php echo count($loggedIn_agent->followings()) ?><br/> followings
</div>
</div>
<?php
}
else if($status==9){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<div class="padding-10-0 text-center bold">
<?php echo count($loggedIn_client->followings()) ?><br/> followings
</div>
</div>
<?php
}
else  if($status==0){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<a href="../login" class="btn btn-primary">Login</a> or <a href="../cta/checkin.php" class="btn btn-primary site-color-background">checkin as a client</a></p>
	</div>
<?php
}
?>
</div>
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
$i=0;
	$getAgents = $db->query_object("SELECT profiles.ID AS agent_id,COUNT(properties.property_ID) AS uploads FROM profiles LEFT JOIN properties ON (properties.uploadby = profiles.User_ID) GROUP BY (profiles.User_ID) ORDER BY uploads DESC LIMIT $start,$end");
while($a = $getAgents->fetch_array(MYSQLI_ASSOC)){
	$agent = new agent($a['agent_id']);
	?>
	<div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="contain remove-side-margin-xs">
	<div class="head f7-background">
	
	<div class="row">
		<span class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<a href="../agents/<?php echo $agent->username ?>">
			<h4 class="text-left site-color"><span class="glyphicon glyphicon-briefcase round e3-border"></span>  <?php echo $agent->business_name ?></h4>
			</a>
		</span>
		<span class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<div data-action="toggle">
						<button class="width-70p margin-auto padding-5 btn btn-primary site-color-background" data-toggle-role="toggle-trigger" data-toggle-on = "hide contact" data-toggle-off = "Contacts"></button>
						<ul data-toggle-role="main-toggle" class="absolute box-shadow padding-5 f7-background site-color e3-border box-shadow border-radius-5 text-left" style="width:200px;z-index:2">
							<li class="padding-5 no-style-type"><span class="glyphicon glyphicon-earphone"></span>  <?php echo $agent->office_contact ?> (office)</li>												
							<li class="padding-5 no-style-type"><span class="glyphicon glyphicon-earphone"></span>  <?php echo $agent->contact1 ?></li>												
							<li class="padding-5 no-style-type"><span class="glyphicon glyphicon-earphone"></span>  <?php echo $agent->contact2 ?></li>												
							<li class="padding-5 no-style-type"><span class="glyphicon bold">@</span>  <?php echo $agent->business_mail ?></li>
						</ul>
					</div>		
			</span>
		<span class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

					<div class="text-right">
			<?php 
				if($status == 1){
					echo $agent->follow_button($loggedIn_agent->id, $loggedIn_agent->business_name,$loggedIn_agent->username,'A4A');
				}
				else if($status == 9){
					echo $agent->follow_button($loggedIn_client->id, $loggedIn_client->name,null,'C4A');
				}
				else{
					echo $agent->follow_button(null,null,null,null);
				}
				?>
				</div>
		</span>
	</div>
	
	</div>
	<div class="body white-background remove-side-padding-xs remove-side-padding-sm remove-side-padding-md ">
		<div class="padding-0-5">
			<p class="padding-2"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $agent->address ?></p>
			<p class="padding-2 bold"><span class="glyphicon glyphicon-upload"></span>  <?php echo count($agent->uploads()); ?> properties</p>
		</div>
		<?php
			$recent_uploads = $agent->recent_uploads(0,7);
			if(count($recent_uploads > 0)){
					?>
				<div class="scrollable-x">
					<div class="scrollable-x-inner" style="width:<?php echo 160 * count($recent_uploads) ?>px">
					<?php
							$ru = 0;
							while($ru < count($recent_uploads)){
								$p = new property($recent_uploads[$ru])
								?>
								<div class="e3-border margin-2 f7-background padding-2" style="float:left; width:150px">
									<h5 class="text-center"><?php echo $tool->substring($p->type,'abc',15) ?></h5>
									<div class="text-center">
										<img src="<?php echo $p->display_photo_url() ?>" class="property-images mini-property-image size-100" <?php echo $p->image_attributes($popup = true) ?>/>
									</div>
									<p class="text-center"><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $tool->substring($p->location,'xyz',15) ?> </p>
									<p class="text-center"><span class="opac-3-site-color-background site-color padding-10 border-radius-5"><?php echo $p->rent ?>/year</span> </p>
									<p class="text-center font-12 grey">updated <?php echo $tool->substring($tool->since($p->last_reviewed),'abc',10) ?> </p>
									<div class="text-center">
										<a class="text-center btn btn-primary" href="../<?php echo $p->url ?>">see full details</a>
									</div>
								</div>
								<?php
								$ru++;
							}
							?>
					</div>
				</div>
		<?php
			}
			else{
				?>
				<div class="padding-10 e3-border ">
					No recent upload
				</div>
				<?php
			}
			?>
				<span class="text-right font-12 grey"> Shelter agent since: <?php echo $tool->since($agent->registration_timestamp) ?></span>
			</div>
		</div>
</div>
			
	<?php
	unset($agent);
	$i++;
	}
?>

<!--	<div class="next-prev-container">
	<p style="display:block">showing <?php //echo ($x+1)." - $y of $totalAgents" ?> </p>
	<?php
	//if($x > 0 ){
		?>
<a class="previous" href="?next=<?php //echo ($y-(2*$max) < 0 ? 0 :  $y-(2*$max)) ?>" >« prev</a>
<?php
//	}
//if( $y < $totalAgents){
	?>
<a class="next" href="?next=<?php// echo $y ?>" >next »</a>
<?php
//}	
?>
</div>
-->
</div>

<?php require('../resources/global/footer.php') ?>
</div><!--main-content-->
</div><!--parent row-->
</div><!--container-fluid body-content-->
</body>
</html>