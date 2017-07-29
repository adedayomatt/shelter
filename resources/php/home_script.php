<?php

class home{
    function mini_notification(){
    GLOBAL $general;
    GLOBAL $db;
    GLOBAL $status;
    $NOTIFICATIONS = null;
if($status == 1){
    GLOBAL $Business_Name;
	$getnotifications = $db->query_object("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents')  ORDER BY time DESC LIMIT 2");
}
else if($status == 9){
    GLOBAL $ctaname;
	$getnotifications = $db->query_object("SELECT * FROM notifications WHERE ((receiver='$ctaname' OR receiver='allAgents') AND action != 'CTA created') ORDER BY time DESC");
}
	if($getnotifications->num_rows != 0){
		while($n = $getnotifications->fetch_array(MYSQL_ASSOC)){
			//if notification was received on the same date with the date of checking notifications
if(date('dmy',$n['time'])== date('dmy',time())){
	$NOTIFICATIONS =  $general->display_notification($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'today');
}
//if notification was received a day before date of checking notifications
else if((date('d',time())- date('d',$n['time']))==1){
	$NOTIFICATIONS =  $general->display_notification($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'yesterday');
	}
else{
	$NOTIFICATIONS = $general->display_notification($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'older');
	                  }
		         }
    $NOTIFICATIONS .= "<p style=\"text-align:right\"><a href=\"notifications\" >See all notifications ($getnotifications->num_rows)</a></p>";
            }
         return $NOTIFICATIONS;
    }
    
function most_viewed(){
    GLOBAL $db;
    GLOBAL $general;
    $most_viewed = null;
$most_viewed_query = "SELECT property.property_ID AS propertyid, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent, 
        property.uploadby AS agentUserName, property.timestamp AS since, property.views AS views, agent.Business_Name AS agentBussinessName  
        FROM properties AS property INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) 
         ORDER BY views DESC LIMIT 10";

$most_viewed = $db->query_object($most_viewed_query);
  //if  error error string was returned
 if(is_string($most_viewed)){
    error::report_error($most_viewed,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
 }
 //if the result object was returned
 else if(is_object($most_viewed)){
return $most_viewed;
 }

    }

 }//end of class
?>