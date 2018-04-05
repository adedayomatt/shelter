
<?php
if($status==1){
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}
else if($status==9){
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}
else{
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}

if($ref=='home_page'){
		$homeActiveClass = "icon-size-25 site-color";
		$agentActiveClass = "icon-size-20 grey";
		$clientActiveClass = "icon-size-20 grey";
	}
else if($ref=='agents_page'){
		$homeActiveClass = "icon-size-20 grey";
		$agentActiveClass = "icon-size-25 site-color";
		$clientActiveClass = "icon-size-20 grey";
	}
else if($ref=='clientss_page'){
		$homeActiveClass = "icon-size-20 grey";
		$agentActiveClass = "icon-size-20 grey";
		$clientActiveClass = "icon-size-20 site-color";
	}
$staticHead = "<div class=\"row hidden-lg hidden-md visible-sm visible-xs static-head-primary\">

<div class=\"col-sm-3 col-xs-3 text-center\">
<span class=\"glyphicon glyphicon-home $homeActiveClass\"></span>
</div>

<div class=\"col-sm-4 col-xs-4 text-center\">
<a href=\"agents\" class=\"grey\"><span class=\"glyphicon glyphicon-briefcase $agentActiveClass\"></span><br/>Agents</a>
</div>

<div class=\"col-sm-3 col-xs-3 text-center\">
<a href=\"clients\" class=\"grey\" ><span class=\"glyphicon glyphicon-user $clientActiveClass\"></span><br/>Clients</a>
</div>
$staticHeadOptions
</div>
";
?>

