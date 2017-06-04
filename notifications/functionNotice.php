<?php
function notify($subject,$subjecttrace,$action,$timestamp,$howold){
	$root = "http://192.168.173.1/shelter";
	$time = time() - $timestamp;
//if less than 60 secs
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
	if($time<60){
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = (int)($time/60).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = (int)($time/3600).' hours, '.(($time/60)%60).' minutes ago';
	}
	else if($time>=86400 && $time<604800){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
}
	
	switch($action){
	//if it is a client following an agent, specify the client need
		case 'C4Afollow':
		$requests = mysql_query("SELECT * FROM cta_request WHERE (ctaid='$subjecttrace')");
		if(mysql_num_rows($requests)!=0){
			$get=mysql_fetch_array($requests,MYSQL_ASSOC);
			$reqtype = $get['type'] ;
			$reqmaxprice =$get['maxprice'];
			$reqlocation = $get['location'];
			$xtra = "<p style=\"font-style:normal;\">This client needs $reqtype with rent not more than N".number_format($reqmaxprice)." around $reqlocation <a href=\"\">Suggest a property for this client</a></p>";
					
		}
		else{
			$xtra="<p>This client has no specific preference <a href=\"\">Suggest a property for this client</a></p>";
		}
		return "<li class=\"client-follow-notice\">
					+<i class=\"black-icon user-icon\"></i>A client <a href=\"$root/cta/ctarequests/?target=$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"since\">$since</p>
					 $xtra</li>";
		break;
		
		case 'A4Afollow':
		return "<li class=\"notice\">
					+<i class=\"black-icon user-icon\" ></i>An agent <a href=\"$root/$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"since\">$since</p>
						</li>";
		break;
		

		case 'CTA created':
		return "<li class=\"notice\">
					+<i class=\"black-icon\" id=\"user-icon\"></i>You created your CTA as $subject
					 <p class=\"since\">$since</p>
					 
						</li>";
		break;
		case '':
		break;
	}
}
