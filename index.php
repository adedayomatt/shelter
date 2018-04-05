<?php 
require('resources/master_script.php'); 
?>

<!DOCTYPE html>
<html>
	<head>
		<?php
		$pagetitle = 'Home';
		$ref="home_page";
		require('resources/global/meta-head.php'); ?>
 
		<link rel="manifest" href="manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="resrc/icons/ms-icon-144x144.png">


		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="application-name" content="Shelter">
		<meta name="apple-mobile-web-app-title" content="Shelter">
		<meta name="theme-color" content=" #20435C">
		<meta name="msapplication-navbutton-color" content=" #20435C">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="msapplication-starturl" content="offline/index.html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<script>
			if ('serviceWorker' in navigator) { 
			window.addEventListener('load', function() {   
				navigator.serviceWorker.register('sw.js').then(
					function(registration) { 
						// Registration was successful
							console.log('ServiceWorker registration successful with scope: ', registration.scope); }, 
								function(err) { 
									// registration failed :( 
										console.log('ServiceWorker registration failed: ', err); 
								}); 
						});
			}
	function front_display(mode){
	var major = new Array();
	var minor = new Array();
	var minor_ = new Array();
	
	var agent_minor_alt = new Array();
	var agent_minor_alt_ = new Array();
	var client_minor_alt = new Array();
	var client_minor_alt_ = new Array();
	
	major[0] = "Need to Sell or Lease Out a Property Quickly <span class=\"question-m\">?</span>";
	minor[0] = "...all you need is the connection with your clients,";
	minor_[0] = "they are here!";
	
	agent_minor_alt[0] = minor[0];
	agent_minor_alt_[0] = minor_[0];
	agent_minor_alt[1] = "...many clients are waiting for your property here,";
	agent_minor_alt_[1] = "showcase there!";
	
	
	major[1] = "Need to Buy or Rent a Property Without Stress <span class=\"question-m\">?</span>";
	minor[1] = "...just make a request, ";
	minor_[1] = "our agents will get back to you ASAP!";
	
	client_minor_alt[0] = minor[1];
	client_minor_alt_[0] = minor_[1];
	client_minor_alt[1] = "...many agents add their property here, ";
	client_minor_alt_[1] = "get ready to explore!";
	
	major[2] = "YES <span class=\"exclaim-m\">!</span> You can live in your dream home";
	minor[2] = "...all you need is the connection with the right agent,";
	minor_[2] = "we provide that!";
	switch (mode){
		case 'agent':
		document.querySelector('#front-text-major').innerHTML = major[0];
		document.querySelector('#front-text-minor').innerHTML = minor[0];
		document.querySelector('#front-text-minor_').innerHTML = minor_[0];
		var z = 1;
		var chg = setInterval(function(){
		document.querySelector('#front-text-minor').innerHTML = agent_minor_alt[z%agent_minor_alt.length];
		document.querySelector('#front-text-minor_').innerHTML = agent_minor_alt_[z%agent_minor_alt_.length];
		z++;
	},7000);
		break;
		case 'client':
		document.querySelector('#front-text-major').innerHTML = major[1];
		document.querySelector('#front-text-minor').innerHTML = minor[1];
		document.querySelector('#front-text-minor_').innerHTML = minor_[1];
		var z = 1;
		var chg = setInterval(function(){
		document.querySelector('#front-text-minor').innerHTML = client_minor_alt[z%client_minor_alt.length];
		document.querySelector('#front-text-minor_').innerHTML = client_minor_alt_[z%client_minor_alt_.length];
		z++;
	},7000);		break;
		default:
		document.querySelector('#front-text-major').innerHTML = major[2];
		document.querySelector('#front-text-minor').innerHTML = minor[2];
		document.querySelector('#front-text-minor_').innerHTML = minor_[2];
		var z = 1;
		var chg = setInterval(function(){
		document.querySelector('#front-text-major').innerHTML = major[z%major.length];
		document.querySelector('#front-text-minor').innerHTML = minor[z%minor.length];
		document.querySelector('#front-text-minor_').innerHTML = minor_[z%minor_.length];
		z++;
	},7000);
			break;
	}
}
		</script>
		<style>
		body{
			overflow-x:hidden;
		}
			div#front{
				background: #20435C url("resources/images/home-front-bg.png") no-repeat center;
				padding-top:130px;/*This is the padding that is suppose to be for container fluid*/
				padding-bottom:20px;
			}
			#front-text-major{
				color:#fff;
				 font-weight:600;
				 font-size:300%;
				 z-index: 99;
				 text-align:center;
			}
			#front-text-minor{
				color:#eee; 
			}
			#front-text-minor_,.exclaim-m,.question-m{
				color:red; 
				font-style:italic;
			}
			.exclaim-m,.question-m{
				font-size:80px;
			}
			#front-inner{
				width:80%;
				margin:auto;
			}
			#front-text-minor-wrapper{
				animation-name: growUp;
				animation-duration: 7s;
				animation-iteration-count: infinite;
				animation-fill-mode: both;
			}
			
/******************This is for the fixing of the RHS, the JavaSceipt that controls it is in the header*******************************/						
		
		@media only screen and (min-width: 992px),(min-device-width: 992px){
			[data-fix-rhs='true']{
						left: 50%;
						top:90px;
						padding-top:40px;
				}
			}
			@media only screen and (max-width:992px),(max-device-width: 992px){
			[data-fix-rhs='true']{
					left: 41.66666667%;
						top:90px;
						padding-top:40px;
				}
			}
/*********************************************/

			@media all and (min-width:768px){
			div#front{
				min-height:90vh;
			}
			[data-fix-rhs]{
				background-color:rgb(32, 67, 92);
				color:white;
			}
		.category{
		}
			}
			@media all and (max-width:1000px){
			div#front{
				min-height:60vh;
			}
			}
			@media all and (max-width:768px){
			#front{
				padding-top:80px !important;
			}
			#front-inner{
				width:98%;
				padding:5px;
			}
			#front-text-major,.exclaim-m,.question-m{
				font-size:26px;
			}
			#front-text-minor{
				font-size:16px;
			}
			.exclaim-m,.question-m{
				font-size:40px;
						}
			}
			.subscription-area{
				background:rgba(32, 67, 92, 0.1) url('resources/images/subscription-bg.png') no-repeat center;
				padding:20px 10px;
			}
		</style>

	</head>
	
	<body>
<?php
if($status==1){
?>
	<a class="hidden-lg hidden-md hidden-sm visible-xs" href="upload" id="quick-upload-ball">
		<span class="glyphicon glyphicon-send icon-size-30 red-background white" style="position:fixed;top:80%;left:70%;z-index:99;padding:20px; border-radius:50%; box-shadow: 0px 5px 5px #555"></span>
	</a>
<?php
}
require("resources/global/header.php");
?>

	<div class="container-fluid" style="padding-top:0px">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="all-top-b4-fixing-rhs">
<?php 
if(!isset($_GET['next']) || $_GET['next']==0){
	?>
			<div class="row">
				<div id="front" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div id="front-inner">
							<div id="front-text-major-wrapper">
								<h1 id="front-text-major"><noscript>YES<span class="exclaim"><i>!</i></span> You can live in your dream home</noscript></h1> 
							</div>
							<div id="front-text-minor-wrapper" class="text-right">
								<h4>
									<span id="front-text-minor" ><noscript>..all you need is the connection with the right agent,</noscript></span> 
									<span id="front-text-minor_" ><noscript>we provide that!</noscript></span>
								</h4>
							</div>
							<?php
							if($status == 1){
							?>
							<script>
							front_display('agent');
							</script>
							<?php							
							}
							else if($status == 9){
								?>
								<script>
							front_display('client');
							</script>
								<?php
							}
							else{
								?>
								<script>
							front_display('visitor');
							</script>
								<?php
							}
							?>
							<div class="padding-5 border-radius-5" style="background-color:rgba(0,0,0,0.5)">
								<h3 class="text-left white">Search For Property</h3>
								<?php require("search/searchform.php") ?>
							</div>
							
							<div class="margin-10-0 padding-5 border-radius-5 text-center" style="background-color:rgba(0,0,0,0.7);">
								<div class="row">
									<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<a href="signup" class="btn btn-lg btn-default site-color-background white border-0">Sign up an Agent Account</a>
										</div>
										<a href="login" class="white">Login</a>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<a href="cta/checkin.php?a=create" class="btn btn-lg btn-default red-background white border-0">Create a CTA</a>
										</div>
										<a href="cta/checkin.php?a=create" class="white">Checkin my CTA</a>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
<?php
}
?>				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:rgba(32, 67, 92, 0.4)">
							<div class="padding-10">
								<h3 class="site-color text-left bold">Most Viewed</h3>
								<div class="row">
							 
<?php
$mostViewed = $loadData->load_most_viewed_properties_id(0,6);
$mv_count = 0;
while($mv_count < count($mostViewed)){
	$mv = new property($mostViewed[$mv_count]);
?>
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
									<div class="margin-2" >
									<div class="row site-color" style="background-color:rgba(255,255,255,0.5);">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 ">
											<div class="padding-5">
												<img class="property-images mini-property-image size-100" src="<?php echo $mv->display_photo_url() ?>" <?php echo $mv->image_attributes($popup = true) ?>/>
												<p class="font-12">
													<span class="glyphicon glyphicon-upload red round"></span> <?php echo $tool->substring($tool->since($mv->upload_timestamp),'abc',10) ?>
												</p>
											</div>
										</div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				
											<h4><a class="site-color text-left" href="<?php echo $mv->url ?>">  <?php echo $tool->substring($mv->type,'abc',25) ?></a></h4>
											<div class="float-right">
											<div  class="animate " >
												<span class="red-background white mv-rent-figure"> N <?php echo number_format($mv->rent) ?></span>
											</div>
											</div>
											<p>
												<span class="glyphicon glyphicon-map-marker red"></span>  <?php echo $tool->substring($mv->location,'xyz',10) ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-eye-open red"></span>  <?php echo $mv->views ?>  views
											</p>
											
											
											
										</div>
									</div>
										
										<!--<div class="contain remove-side-margin-xs">
											<div class="head opac-4-site-color-background">
												<a class="site-color text-left" href="<?php echo $mv->url ?>"><h3><?php echo $tool->substring($mv->type,'abc',25) ?></h3></a>
											</div>
											<div class="body text-center white-background remove-padding-lg remove-padding-md remove-padding-sm remove-padding-xs" onMouseEnter="javascript: this.querySelector('[data-overlay-body-animation]').setAttribute('data-animation','pulse');" onMouseLeave="javascript: this.querySelector('[data-overlay-body-animation]').setAttribute('data-animation','')">
												<div class="absolute" style="width:80%; margin:0px 5%; ">
													<div class="opac-7-site-color-background box-shadow text-center padding-10 border-radius-3" data-overlay-body-animation="true" data-animation="" data-animation-time="2s" data-animation-iteration="infinite" >
														<p class=" font-18 white">
															<span class="glyphicon glyphicon-map-marker red"></span>  <?php echo $tool->substring($mv->location,'abcxyz',25) ?>
														</p>
														<p class="font-16 white">
															<span class="glyphicon glyphicon-eye-open red"></span><?php echo $mv->views ?>  views
														</p>
														<p class="font-14 white">
															<span class="glyphicon glyphicon-upload red round"></span>  <?php echo $tool->since($mv->uploadTimestamp) ?>
														</p>
														<div data-mv-price-animation="true" data-animation="swing" data-animation-time="2s" data-animation-iteration="infinite"  class="" >
															<span class="red-background white mv-rent-figure"> N <?php echo number_format($mv->rent) ?></span>
														</div>
													</div>
												
 <!--<div class="padding-5" >
 <div class="row opac-white-background margin-1 padding-3 e3-border border-radius-3 text-center">
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="font-18 site-color"> <span class="glyphicon glyphicon-briefcase site-color"></span> <a href="<?php //echo $mv_agent_username ?>"><?php //echo $mv_agent_bizname ?> </a></p></div>
 </div>
 </div>
													</div>
													<div>
														 <img class="mv-image property-images" src="<?php echo $mv->display_photo_url() ?>"/>
													</div>
											</div>
										</div> -->
									</div>
									</div>	
<?php
unset($mv);
$mv_count++;
		}
?>
								</div>
								</div>
					</div>
					<div class="text-center e3-background padding-10">
							<img src="<?php echo $root.'/'.ads::$ad005 ?>" alt="Advert will be placed here" class="ads"/>
					</div>
				</div>
<?php if($status == 0){
?>				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="padding-10 margin-10-0 text-center white-background e3-border" data-loading-content="loading">
							<h1 class="site-color">IN NEED OF AN APARTMENT <span class="animate bounce deepblue"><strong>?</strong></span></h1>
							<h3 >Create a Client Temporary Account (CTA) Today</h3>
							<div class="">
								<button data-action="animate-bgcolor"  class="custom-button">Click here to create a CTA</button>
							</div>
						</div>
					</div>
				</div>
<?php
}
else if($status == 1){
//this returns a multidimensional array
$cta_requests = $loadData->load_cta_requests(0,6);
?>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								
									<div class="padding-10 white-background site-color" style="margin-bottom:2px">
										<h4 class="text-left">
											Client Requests (<?php echo count($cta_requests) ?>)
										</h4>
									</div>
										<div class="scrollable-x white-background">
											<div class="scrollable-x-inner" style="width:<?php echo 170 * count($cta_requests)?>px">
												<?php
												$request_count = 0;
													while($request_count < count($cta_requests)){
														$request = new cta_request($cta_requests[$request_count]);
												?>
												<div class="e3-border-bottom white-background e3-border margin-2" style="width:150px; float:left">
													<div class="f7-background padding-2">
														<h4 class="text-center margin-0"><?php echo $request->ctaname ?></h4>
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
												$request_count++;	
												}
?>											</div>
										</div>
										<div class="text-right margin-10">
											<a href="clients" class="">See all requests</a>
										</div>
							</div>
						</div>
<?php
}

?>			
				</div><!--All top before the fixed area-->
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 e3-background" data-relative-lhs >
							<div class="padding-10 site-color">
								<h3 class="text-left bold">Recently Added</h3>
							</div>
								<div class="row ">
								<?php
								$from = (isset($_GET['next']) ? $_GET['next'] : 0);
								$to = $from + 6;
								$recently_added = $loadData->load_recently_added_properties_id($from,$to);
								$recently_added_count = 0;
								$property_display_blocking = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
								while($recently_added_count < count($recently_added)){
									$property = new property($recently_added[$recently_added_count]);
									require('resources/global/property_display.php');
									$recently_added_count++;
								}
								
								?>	
								</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" data-fix-rhs >
					<div class="row">
						<style>
							.category>ul>li{
								padding:10px;
								/*border-bottom:1px solid #e3e3e3;*/
							}
						</style>
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 category " style="">
					<h4 class="bold padding-10">Categories</h4>
						<ul>
							<?php
								$category = $loadData->load_categories();
							?>
							<li>Flat (<?php echo $category['Flat']?>)</li>
							<li>Bungalow (<?php echo $category['Bungalow']?>)</li>
							<li>Self Contain (<?php echo $category['Self Contain']?>)</li>
							<li>Duplex (<?php echo $category['Duplex']?>)</li>
							<li>Office Space (<?php echo $category['Office Space']?>)</li>
							<li>Shop (<?php echo $category['Shop']?>)</li>
							<li>Land (<?php echo $category['Land']?>)</li>
						</ul>
						<div>
						<img width="100%" height="400px" alt="Another ad would appear here" class="block"/>
						</div>
					</div>			
					<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 black">
						<div class="contain remove-side-margin-xs border-radius-0">
							<div class="head white-background site-color">
								<h4 class="text-left bold">Agents</h4>
							</div>
							<div class="body white-background remove-side-padding-md remove-side-padding-sm remove-side-padding-xs" style="padding-top:0px">
									<?php
									if($status==1){
									$_agents = $loadData->load_agents_id(0,6,$loggedIn_agent->id);
									}
									else{
										?>
														<ul class="padding-0">
									<?php
												$_agents = $loadData->load_agents_id(0,6,null);
									}
									$agents_count = 0;
									while($agents_count < count($_agents)){
										$agent = new agent($_agents[$agents_count]);
											?>
									<li class="no-style-type padding-10 margin-0 white-background border-radius-3 e3-border-bottom">
										<div class="row">
											<span class="col-lg-8 col-md-8 col-sm-7 col-xs-8" style="overflow:hidden">
												<span class="glyphicon glyphicon-briefcase round e3-border"></span>  <a class="site-color" href="<?php echo "agents/".$agent->username ?>"><?php echo $tool->substring($agent->business_name,'abc',22)?></a>
											</span>
											<span class="col-lg-4 col-md-4 col-sm-5 col-xs-4 text-right">
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
											</span>
											<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bold">
												<?php echo count($agent->uploads())?> properties
											</span>
											<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<span class="glyphicon glyphicon-map-marker"></span>  <?php echo $agent->address ?>
											</span>
										</div>
									</li>

<?php
$agents_count++;
}	
?>
								</ul>
								<div class="text-right margin-10">
									<a class="btn btn-primary " href="agents">see more agents</a>
								</div>
							</div>
						</div>
						</div>

						</div>
					</div>
					</div>
					
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						<div class="text-center margin-5-0" data-loading-content="loading" style="width:100%;height:80px">
							<div class="animate bounce"><h1>ADVERTISE WITH US</h1></div>
							<p>Background Image would be here</p>
						</div>
					</div>
				</div>
				
				<div class="row white-background">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="padding-5">
							<div class="text-center">
								<img src="" class="blog-post-image text-center" alt="blog post image missing!"/>
							</div>
							<h4>Top 10 Real Estate You should Consider</h4>
								<p>
<?php
 echo substr("Amongst several constraints several students have to face is financial constraint.
				The maintenance of studentship in a university requires both intellectual effort and financial support. 
				Although Federal University of Agriculture, Abeokuta (FUNAAB) is one of the federal universities in Nigeria
				and that makes her fees more affordable when compared with universities of states and private universities.
				Although the capital involved in the provision of university education is still relatively enormous,
				the governments (Federal and State) subsidize it in order to make it affordable to the citizens. 
				It has been affirmed that university education is capital intensive; and finance is the basis for the
				success or failure of the project (Maduewesi, 2001)....",0,150);
				?>
								</p> 
								<a href="#" >Read more...</a>
							</div>
						</div>
							
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="padding-5">
							<div class="text-center">
								<img src="" class="blog-post-image text-center" alt="blog post image missing!"/>
							</div>
							<h4>5 Top Reasons You Should Consider Using Zoto</h4>
								<p>
<?php
 echo substr("As students, main source of income is either from parent/guardian or personal struggle. If source of income is from parent/guardian,
			several studies have ascertained that sponsor socioeconomic status affect academic performance of respective student. 
			Academic performance of students who engaged in other activities to get resources to fend themselves is also affected.
			Studies of Gose (2004) and Seligo (2003) asserted that the unit expenditure per student in developing countries like Nigeria
			is less than the developed ones. Furthermore, the unit private cost of student education varies according to students’ field and level 
			of study and this is as a result of difference in cost of materials in the different students’ field. ",0,150);
				?>
								</p> 
								<a href="#" >Read more...</a>
							</div>
						</div>

			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="padding-5">
							<div class="text-center">
								<img src="" class="blog-post-image text-center" alt="blog post image missing!"/>
							</div>
							<h4>Top 10 Real Estate You should Consider</h4>
								<p>
<?php
 echo substr("As students, main source of income is either from parent/guardian or personal struggle. If source of income is from parent/guardian,
			several studies have ascertained that sponsor socioeconomic status affect academic performance of respective student. 
			Academic performance of students who engaged in other activities to get resources to fend themselves is also affected.
			Studies of Gose (2004) and Seligo (2003) asserted that the unit expenditure per student in developing countries like Nigeria
			is less than the developed ones. Furthermore, the unit private cost of student education varies according to students’ field and level 
			of study and this is as a result of difference in cost of materials in the different students’ field. ",0,150);
				?>
								</p> 
								<a href="#" >Read more...</a>
							</div>
						</div>	

						

					</div>				
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						<div class="subscription-area text-center">
							<div class="row border-radius-5" style="background-color:rgba(0, 0, 0, 0.5)">
							<div class="col-lg-4 col-lg-offset-8 col-md-4 col-md-offset-8 col-sm-5 col-sm-offset-7 col-xs-12">
							<form action="" class="padding-5">
								<h1 class="white">subscribe to our daily update</h1>
								<div class="form-group">
									<input class="form-control" type="email" required placeholder="Enter your email here"/>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-default btn-lg site-color-background white border-0" value="submit"/>
								</div>
							</form>
							</div>
						</div>
						</div>
					</div>
					
					
				</div>
			</div><!--body-content ends here-->
		</div><!--.row ends here-->
				<?php
				$feedback_form = true;
				require('resources/global/footer.php');
				?>
	</div><!--.container-fluid ends here-->
</body>


</html>