<?php

/*
This script get all properties belonging to an agent, it uses GET method the index of the GET array are:

aid, ---------->Agent id
uBn, ------------->agent Business name
un, ------------->agent username
tkn, --------->agent token
client_name, ------------->client
cid, ------------->client id

First created: 2nd Aug, 2017 ; 6:10 PM
*/


	$agentid = $_GET['aid'];
	$agent_name = $_GET['aBn'];
    $agent_username = $_GET['un'];
    $token = $_GET['tkn'];
    $client_name = $_GET['client'];
    $cid = $_GET['cid'];

   //check if agent is logged in 
if(isset($_COOKIE['user_agent']) && $token == $_COOKIE['user_agent']){

require('../site_config.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
 
$getproperties = $connection->query("SELECT property_ID,directory,type,rent,location,timestamp FROM properties WHERE (uploadby = '$agent_username')");
	if(!$connection->error ){
		if($getproperties->num_rows==0){
    ?>
<div>
<p class="no-data-loaded">You have not uploaded any property <a href="<?php echo "$root/upload" ?>" class="deepblue-inline-block-link"> Upload now </a></p>
	</div>
<?php
		}
		else{
    ?>
<ul style="padding:0px;margin:0px;">
<?php
while($p = $getproperties->fetch_array(MYSQLI_ASSOC)){
//get clients that each property is suggested to
$suggestedTo = array();
$getSuggested = $connection->query("SELECT client_name FROM properties LEFT JOIN property_suggestion ON (properties.property_ID = property_suggestion.property_id) WHERE (property_suggestion.property_id = '".$p['property_ID']."')");
  while($s = $getSuggested->fetch_array(MYSQLI_ASSOC) ){
    $suggestedTo[] = $s['client_name'];
  }
  $getSuggested->free();
?>

<div style="border-bottom:1px solid #e3e3e3">
<?php
$totalSuggestedTo = count($suggestedTo);
//if this property have been suggested already to this client
if(in_array($client_name,$suggestedTo)){
  //if suggested already
    ?>
<button class="btn btn-default white site-color-background float-right" onclick="">Already suggested</button>
<?php
}
else{
?>
<button class="btn btn-default site-color float-right one-click-suggest-btn" id="<?php echo $p['property_ID'] ?>" data-pid="<?php echo $p['property_ID'] ?>" data-pdir="<?php echo $p['directory'] ?>" data-agent-name="<?php echo $agent_name?>" data-agent-username="<?php echo $agent_username?>" data-agent-id="<?php echo $agentid ?>" data-agent-token="<?php echo $token ?>" data-client-name="<?php echo $client_name ?>" data-client-id="<?php echo $cid ?>">suggest</button>
<?php
}
?>
<h4 class="normal font-20"> <?php echo $p['type']?> </h4>
 <ul>
       <li > Rent : <?php echo number_format($p['rent']) ?></li>
        <li>Location: <?php echo $p['location']?></li>
        </ul>
        <p class="grey font-14 text-right">
suggested to  <?php echo (in_array($client_name,$suggestedTo) ? $client_name.' and '.($totalSuggestedTo-1).' other clients ' : $totalSuggestedTo.' clients') ?></p>
        <p style="color:grey; font-size:85%">uploaded : <?php echo date('M, d ',$p['timestamp']) ?></p>
	</div>
<?php
//clear
unset($suggestedTo);
		}
$getproperties->free();
?>
</ul>
<?php
	}
}
	else{
		echo "<div class=\"search-whatsup\">Oops!, an error occurred while getting your properties</div>";
	}

$connection->close();
}
else{
require('../../global/mini-login-form.html');
}
