
<div class="sidebar" id="sidebar-original">
<div id="sidebar-inner">
<?php  
if($status==1){
//$profile_name and $Business_Name would have been initialize in the header which would have beeen required before this script
echo "<h5 align=\"left\" id=\"biz-name\"><a href=\"$profile_name\">$Business_Name</a></h5>";
}
else if($status ==9){

}
else{
	echo "<br/>";
}
 ?>

<!--user navigation sidebar begins here-->
<?php switch($status){
//All the variables like $messages,$following,$clientfollower are already set in the header
	case 0:
echo "<p align=\"center\" style=\"margin-bottom:0px \"><strong>Client Temporary Account (CTA)</strong></p>
	<div class=\"account-nav-container\">
	<a href=\"\" class=\"account-nav-link\">What is CTA?</a>
	<a href=\"cta\" class=\"account-nav-link\">Checkin my CTA</a>
	<a href=\"\" class=\"account-nav-link\">Clipped properties</a>
	<a href=\"\" class=\"account-nav-link\">My agents</a>
	</div>";
break;
	case 1:
echo "<a href=\"$root/upload\"><div id=\"upload-btn\"><i class=\"white-icon\" id=\"upload-icon\"></i>Upload property</div></a>
	<div class=\"account-nav-container\">
	<a href=\"$root/messages\" class=\"account-nav-link\">($messages) Messages</a>
	<a href=\"\" class=\"account-nav-link\">($following) Following agents</a>
	<a href=\"\" class=\"account-nav-link\">($clientfollower) Follower[client]</a>
	<a href=\"\" class=\"account-nav-link\">($agentfollower) Follower[agent]</a>
	<a href=\"manage/account.php\" class=\"account-nav-link\">Edit profile</a>
	<a href=\"$profile_name\" class=\"account-nav-link\">My properties</a>
	</div>";
break;
case 9:
echo "<div class=\"account-nav-container\">
	<p align=\"center\" style=\"margin-bottom:0px \"><strong>Client Temporary Account (CTA)</strong><br/>$ctaname</p>
	<a href=\"$root/messages\" class=\"account-nav-link\" id=\"msgs\">($messages) Messages</a>
	<a href=\"$root/cta/?src=matches\" class=\"account-nav-link\">($matchcounter) Matches</a>
	<input type=\"hidden\" value=\"$clipcounter\" id=\"clips\">
	<a href=\"$root/cta/?src=clipped\" class=\"account-nav-link\" id=\"clipstring\">($clipcounter) Clipped properties</a>
	<a href=\"\" class=\"account-nav-link\">($following) Following Agents</a>
	<a href=\"\" class=\"account-nav-link\">(0) Agents Suggestions</a>
	<a href=\"$root/cta/request.php?p=$rqstatus\" class=\"account-nav-link\">Adjust request</a>
	<a href=\"\" class=\"account-nav-link\">Change CTA details</a>
	<a href=\"\" class=\"account-nav-link\">Deactivate this CTA</a>								
	</div>";
break;
default:
echo "<div class=\"account-nav-container\">
	Nothing to show here
	</div>";
break;
} 
?>
<hr/>
<div id="category-container">
<h5 align="center" id="categories"><i class="black-icon" id="category-icon"></i>Categories</h5>
<!--<p id="expand-all" ></i>Expands all<i id="all-arrow" class="arrow-down"></i></p>-->
<div id="flats" class = "btn-dropdown" style="font: Arial">Flats<i title="Expand" id="flat-arrow" class="arrow-down"></i></div>
<div id="flat-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">4 Bedroom</a>
<a href="#" class="dropdown-menu">3 Bedroom</a>
<a href="#" class = "dropdown-menu">2 Bedroom</a>
</div>
</div>


<div id="sc" class = "btn-dropdown">Self Contain<i title="Expand" id="sc-arrow" class="arrow-down"></i></div>
<div  id="sc-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div>
</div>


<div id="wings" class = "btn-dropdown">Wings<i title="Expand" id="wings-arrow" class="arrow-down"></i></div>
<div  id="wings-dropdown"class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div></div>


<div id="others" class = "btn-dropdown">Others<i  title="Expand"id="others-arrow" class="arrow-down"></i></div>
<div  id="others-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">Single Room</a>
<a href="#" class="dropdown-menu">Single Room and Parlour</li></a>
</div>
</div>


<div id="sale" class = "btn-dropdown">FOR SALE<i title="Expand" id="sale-arrow" class="arrow-down"></i></div>
<div  id="sale-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">House</a>
<a href="#" class="dropdown-menu">Land</a>
</div>
</div>

</div>
</div>
</div>
<div id="sidebar-under" class="sidebar"></div>
