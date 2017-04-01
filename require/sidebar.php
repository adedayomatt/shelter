<div class="sidebar" id="sidebar-original">
<div id="sidebar-inner">
<!--user navigation sidebar begins here-->
<?php switch($status){
//All the variables like $messages,$following,$clientfollower are already set in the header
	case 0:
echo "<div class=\"account-nav-container\">
	<h4 align=\"center\" style=\"margin-bottom:0px; color:grey; \">Agents</h4>
		<a href=\"login\" class=\"account-nav-link\">Login</a>
		<a href=\"signup\" class=\"account-nav-link\">Sign up</a>
		<hr/>
	<h4 align=\"center\" style=\"margin-bottom:0px; color:grey; \">Client Temporary Account (CTA)</h4>
		<a href=\"cta/checkin.php?_rdr=0#checkin\" class=\"account-nav-link\">Checkin my CTA</a>
		<a href=\"cta/checkin.php?_rdr=0#createnew\" class=\"account-nav-link\">Create new CTA</a>
		<a href=\"\" class=\"account-nav-link\">What is CTA?</a>
		<a href=\"cta/checkin.php?_rdr=1\" class=\"account-nav-link\">My Clipped properties</a>
		<a href=\"cta/checkin.php?_rdr=1\" class=\"account-nav-link\">My agents</a>
	</div>";
break;
	case 1:
echo "<h4 align=\"center\" style=\"margin-bottom:0px; color:grey; text-transform:uppercase;\">$Business_Name</h4>
	<a href=\"$root/upload\"><div id=\"upload-btn\"><i class=\"white-icon\" id=\"upload-icon\"></i>Upload property</div></a>
	<div class=\"account-nav-container\">
	<a href=\"$root/messages\" class=\"account-nav-link\">($messages) Messages</a>
	<a href=\"\" class=\"account-nav-link\">($following) Following agents</a>
	<a href=\"\" class=\"account-nav-link\">($clientfollower) Follower[client]</a>
	<a href=\"\" class=\"account-nav-link\">($agentfollower) Follower[agent]</a>
	<a href=\"manage/account.php\" class=\"account-nav-link\">Edit profile</a>
	<a href=\"manage\" class=\"account-nav-link\">Manage Property</a>
	</div>";
break;
case 9:
echo "<div class=\"account-nav-container\">
	<h4 align=\"center\" style=\"margin-bottom:0px; color:grey; text-transform:uppercase\">$ctaname</h4>
	<a href=\"$root/messages\" class=\"account-nav-link\" id=\"msgs\">($messages) Messages</a>
	<a href=\"$root/cta/?src=matches\" class=\"account-nav-link\">($matchcounter) Matches</a>
	<a href=\"$root/cta/?src=clipped\" class=\"account-nav-link\" id=\"clipstring\">($clipcounter) Clipped properties</a>
	<a href=\"\" class=\"account-nav-link\">($following) Following Agents</a>
	<a href=\"\" class=\"account-nav-link\">(0) Agents Suggestions</a>
	<a href=\"$root/cta/request.php?p=$rqstatus\" class=\"account-nav-link\">Adjust request</a>
	<a href=\"\" class=\"account-nav-link\">Change CTA details</a>
	<a href=\"\" class=\"account-nav-link\">Check out</a>
	<a href=\"\" class=\"account-nav-link\">Deactivate this CTA</a>	
	</div>";
break;
default:
echo "<div class=\"account-nav-container\">
	Nothing to show here, you should <a href=\"$root/login\">logging in now to</a> to see your menu 
	</div>";
break;
} 
?>
<hr/>
<span align="center" id="categories"><i class="black-icon" id="category-icon"></i>Categories</span>
<div id="category-container">
<div class = "btn-dropdown" id="all-btn-dropdown" onclick="toggleall()">Expand all <i id="all-arrow" class="arrow-down" title="Expand all"></i></div>
<div id="flats" class = "btn-dropdown" style="font: Arial" onclick="toggleSidebar('flats','flat-dropdown','flat-arrow')">Flats<i title="Expand" id="flat-arrow" class="arrow-down"></i></div>
<div id="flat-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">4 Bedroom</a>
<a href="#" class="dropdown-menu">3 Bedroom</a>
<a href="#" class = "dropdown-menu">2 Bedroom</a>
</div>
</div>


<div id="sc" class = "btn-dropdown" onclick="toggleSidebar('sc','sc-dropdown','sc-arrow')" >Self Contain<i title="Expand" id="sc-arrow" class="arrow-down"></i></div>
<div  id="sc-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div>
</div>


<div id="wings" class = "btn-dropdown" onclick="toggleSidebar('wings','wings-dropdown','wings-arrow')" >Wings<i title="Expand" id="wings-arrow" class="arrow-down"></i></div>
<div  id="wings-dropdown"class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div></div>


<div id="others" class = "btn-dropdown" onclick="toggleSidebar('others','others-dropdown','others-arrow')" >Others<i  title="Expand"id="others-arrow" class="arrow-down"></i></div>
<div  id="others-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">Single Room</a>
<a href="#" class="dropdown-menu">Room & Parlour</li></a>
</div>
</div>


<div id="sale" class = "btn-dropdown" onclick="toggleSidebar('sale','sale-dropdown','sale-arrow')" >FOR SALE<i title="Expand" id="sale-arrow" class="arrow-down"></i></div>
<div  id="sale-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">House</a>
<a href="#" class="dropdown-menu">Land</a>
</div>
</div>
</div>
<?php
switch($status){
	case 1:
	echo "<hr/>
	<div class=\"account-nav-cotainer\">
	<a href=\"$root/logout\" class=\"account-nav-link\">Logout</a>
	</div>
	<hr/>";
	break;
	case 9:
	echo "<hr/>
	<div class=\"account-nav-container\">
	<a href=\"$root/login\" class=\"account-nav-link bottom-nav-cotainer\">Login as agent</a>
	<a href=\"$root/signup\" class=\"account-nav-link\">Sign up as agent</a>
	</div>
	<hr/>";
	break;
}
?>
</div>
</div>
<div id="sidebar-under" class="sidebar"></div>
