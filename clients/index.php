 <?php 
require('../resources/master_script.php'); ?>

 <!DOCTYPE html>

<html>
<head>
<?php 
$pagetitle = 'Clients';
$ref = "clients_page";
require('../resources/global/meta-head.php');
?>
</head>
<body>

<?php
$showStaticHeader = true;
require('../resources/global/header.php'); ?>
  
<div class="container-fluid pad-lg pad-lg pad-md pad-sm no-pad-xs">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="white-background e3-border-bottom padding-5">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
<h4 class="site-color">Clients</h4>
</div>
<?php
if($status==1){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center bold">
<?php echo count($loggedIn_agent->client_followers()) ?><br/>followers
</div>
<?php
}
else if($status==0){
	?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<a href="../cta/checkin.php" class="btn btn-primary">Checkin</a> or <a href="../login" class="btn btn-primary">login as an agent</a>
	</div>
	<?php
}
?>
</div>
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
<div class="contain remove-side-margin-xs">
<div class="head f7-background">
<h4 class="text-left" >Client Followers</h4>
</div>
<div class="body white-background padding-0">
<?php
$followers = $loggedIn_agent->client_followers();
if(count($followers) > 0){
	$f = 0;
?>
<div class="scrollable-x">
<div class="scrollable-x-inner" style="width: <?php  echo 160 * count($followers) ?>px">
<?php
while($f < count($followers)){
	$client_follower = new client($followers[$f]);
	$request = new cta_request($followers[$f]);
?>
<div class="e3-border-bottom white-background e3-border margin-2" style="width:150px; float:left">
<div class="f7-background padding-2">
<h4 class="text-center margin-0"><?php echo $client_follower->name ?></h4>
<div class="text-center">
<span class="glyphicon glyphicon-user icon-size-25 round e3-border white-background"></span>
</div>
</div>

<h5 class="grey text-center padding-3 margin-0" style="border-top:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3;" >Request</h5>
<div style="height:110px">
<?php
if($request->type != "" && $request->maxprice != 0 && $request->location != ""){
?>
<div class="text-center">
	<p><?php echo $request->type ?></p>
	<p class="padding-5-10 bold opac-3-site-color-background site-color border-radius-5 margin-0-10"><?php echo number_format($request->maxprice) ?></p>
	<p><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $request->location ?></p>
</div>
<?php
}
else{
	?>
	<div class="text-center">No request yet</div>
<?php
}
?>
</div>
<div class="text-center">
<?php
echo $request->suggest_property_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,$loggedIn_agent->token)
?>
</div>

</div>
<?php
unset($client_follower);
unset($request);
      $f++;  
	  }
	?>
</div>   
</div>
<?php
}
else{
 ?>
<div class="text-center"> You do not have any client following you </div>
<?php      
	}
	?>
	</div>
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
<div class="col-lg-8 col-md-8  col-sm-10 col-sm-offset-1 col-xs-12">	
<div class="contain">
<div class="head f7-background">
   <h4 class="text-left"><?php echo ($status==1 ? 'Other clients' :'') ?></h4>
   </div>
<div class="body remove-padding-md remove-padding-sm remove-padding-xs">
<?php
$max = 10;
if(isset($_GET['next']) && $_GET['next'] >= 0 ){
	$start =$_GET['next'];
}
else{
	$start=0;
}
$end = $start + $max;
if($status == 9){
	$clients = $loadData->load_clients_id($start,$end,$loggedIn_client->id);
}
else{
	$clients = $loadData->load_clients_id($start,$end,null);
}
$counter = 0;
	while($counter < count($clients)){
		if($status==1){
			if(in_array($clients[$counter],$followers)){
				$follower_ = true;
			}
		}
		$client = new client($clients[$counter]);
		$request = new cta_request($clients[$counter]);
	?>
	<div class="white-background padding-5 e3-border-bottom margin-5">
		<h4><span class="glyphicon glyphicon-user round e3-border"></span>  <?php echo $client->name."  ".(isset($follower_) && ($follower_) ? "<span class=\"grey margin-0-10 font-12\">following you</span>" : "") ?><span class="grey font-12"></span></h4>
		<?php
if($request->type != "" && $request->maxprice != 0 && $request->location != ""){
?>
<div class="padding-5 e3-border f7-background margin-5">
<div class="row">
	<span class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	<span class="glyphicon glyphicon-question-sign site-color round site-color-border float-left"></span>
	<p class="padding-2 text-center bold">Type: <?php echo $request->type ?></p>
	</span>
	<span class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<p class="padding-2 text-center bold">Rent <= <?php echo number_format($request->maxprice) ?></p>
		</span>
	<span class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<p class="padding-2 text-center"><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $request->location ?></p>
	</span>
</div>
</div>
<p class="text-right grey">Requested since: <?php echo $tool->since($request->request_timestamp)?></p>
<?php
}
else{
	?>
	<div class="padding-5 e3-border f7-background margin-5 text-center">No request yet</div>
<?php
}
?>
<div class="text-center">
<?php
if($status == 1){
echo $request->suggest_property_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,$loggedIn_agent->token);
}
else{
echo $request->suggest_property_button(null,null,null,null);
}
?>
</div>
</div>
<?php
unset($client);
unset($request);
unset($follower_);
$counter++;
	}
?>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
Some content will be here
</div>
</div>
	
<?php require('../resources/global/footer.php') ?>
</div>	<!--main-content ends-->
</div><!--parent row ends-->
</div><!--container-fluid ends-->
</body>
</html>