<?php 
require('../resources/master_script.php');
if($status != 9){
	$tool->redirect_to('checkin.php');
}  
?>

<!DOCTYPE html>
<html>
	<head>
		<?php 
			$pagetitle = "CTA";
			$pagetitle .= (($status==9 && (isset($loggedIn_client)) ) ? ' - '.$loggedIn_client->name:'');
			$ref='cta_page';
			require('../resources/global/meta-head.php'); 
		?>
		<style>
/******************This is for the fixing of the RHS, the JavaSceipt that controls it is in the header*******************************/						
		
 
 @media all and (min-width:768px){
 [data-fix-rhs='true']{
	top:130px;
	left:75%;
	}
[data-fix-rhs='true']:hover{
	overflow:auto;
		}
	}
@media all and (max-width: 992px){
 [data-fix-rhs='true']{
	top:130px;
	left:66.66666667%;
	}
[data-fix-rhs='true']:hover{
	overflow:auto;
		}
}
/*********************************************/
 
		</style>
	</head>

	<body>
		<?php
			$req = (isset($_GET['src']) ? $_GET['src'] :'matches');

			$matches = $loggedIn_client->matches();
			$clipped = $loggedIn_client->clips();
			$suggestions = $loggedIn_client->suggestions();

			if($status==9){
				$showStaticHeader = true;
				$staticHead ="<div class=\"hidden-lg hidden-md static-head-primary padding-3\">
									<h5 class=\"site-color\"><span class=\"glyphicon glyphicon-link \"></span>  Matches (". count($matches).")</h5>
								</div>";
				if($req=='clipped'){
					$staticHead ="<div class=\"row hidden-lg hidden-md static-head-primary padding-3\">
									<h5 class=\"site-color\"><span class=\"glyphicon glyphicon-paperclip\"></span>  Clipped (".count($clipped).")</h5>
								</div>";
				}
				if($req=='suggestions'){
					$staticHead ="<div class=\"row hidden-lg hidden-md static-head-primary padding-3\">
										<h5 class=\"site-color\"><span class=\"glyphicon glyphicon-briefcase\"></span>  Agent Suggestions (".count($suggestions).")</h5>
									</div>";
				}
			}
			require('../resources/global/header.php');
		?>
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12" data-relative-lhs>

					<?php 
						if($req=='matches' || $req==""){
					?>
					<div class="white-background e3-border padding-5 site-color">
						<h4 class="" ><span class="glyphicon glyphicon-link"></span>  Matched properties</h4>
					</div>
					<?php
						if(count($matches) != 0){
							?>
							<div class="row e3-background">
							<?php
							$matches_counter = 0;
								while($matches_counter < count($matches)){
									$property = new property($matches[$matches_counter]);
									require('../resources/global/property_display.php');
									$matches_counter++;
									unset($property);
								}
								?>
								</div>
								<?php
						}
						else{
					?>
					<div class="white-background e3-border padding-10-5">
						<div class="center-content operation-report-container fail">There are no matches for your request for now</div>
					</div>
					<?php
							}
						}
				else if($req=='clipped'){
					?>
					<div class="white-background e3-border padding-5 site-color">
						<h4 class="" ><span class="glyphicon glyphicon-paperclip"></span>  Clipped properties</h4>
					</div>
					<?php
					if(count($clipped) != 0){
							?>
							<div class="row e3-background">
							<?php
					$clip_counter = 0;
						while($clip_counter < count($clipped)){
							$property = new property($clipped[$clip_counter]);
							require('../resources/global/property_display.php');
							$clip_counter++;
							unset($property);
						}
							?>
						</div>
						<?php
					}
					else{
						?>
				<div class="white-background e3-border padding-10-5">
					<div class="center-content operation-report-container fail">You have not clipped any property</div>
				</div>
					<?php
						}	
					}
				else if ($req == 'suggestions'){
					?>
							<div class="row e3-background">
							<?php
					?>
					<div class="white-background e3-border padding-5 site-color">
						<h4 class="" ><span class="glyphicon glyphicon-link"></span>  Suggested properties</h4>
					</div>
				<?php
				if(count($suggestions) != 0){
				$suggestion_counter = 0;
					while($suggestion_counter < count($suggestions)){
						$property = new property($suggestions[$suggestion_counter]);
						require('../resources/global/property_display.php');
						$suggestion_counter++;
						unset($property);
					}
					?>
						</div>
						<?php
				}
				else{
					?>
				<div class="white-background e3-border padding-10-5">
					<div class="center-content operation-report-container fail">There is no any suggestion from any agent for now</div>
				</div>
				<?php
							}
				}
				?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" data-fix-rhs>
					<div class="contain remove-side-margin-xs remove-side-border-xs">
						<div class="head f7-background grey">
							<h3>Your Request</h3>
						</div>
						<div class="body white-background">
							<?php
								if($loggedIn_client->request_type != "" && $loggedIn_client->request_maxprice != 0 && $loggedIn_client->request_area != "" && $loggedIn_client->request_city != "" ){
							?>
								<div class="row" style="line-height:40px">
									<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left ">
										<span class="padding-5">Type: <strong><?php echo $loggedIn_client->request_type ?></strong></span> 
									</span>
									<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
										<span class="padding-5"><span class="glyphicon glyphicon-tags"></span> Max Rent: <strong>N <?php echo number_format($loggedIn_client->request_maxprice) ?></strong></span>
									</span>
									<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
									<div class="grey"><span class="glyphicon glyphicon-map-marker"></span>  Location </div>
										<span class="padding-5">  City: <strong><?php echo $loggedIn_client->request_city ?></strong></span>
									</span>
									<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
										<span class="padding-5">  Prefered Area: <strong><?php echo $loggedIn_client->request_area ?></strong></span>
									</span>
									<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right"><a  href="request.php" class="btn btn-default site-color-background white"><span class="glyphicon glyphicon-pencil"></span> change</a></span>
								</div>
								<?php
								}
							else{
								?>
							<div class="white-background e3-border padding-10 text-center">
								You have not specify your request <br/> <a class="btn btn-defaukt site-color-background white" href="request.php">Specify now</a>
							</div>
							<?php	
									}
								?>
								
						</div>
					</div>				
					</div>
			</div><!--parent row ends-->
		<?php
		$feedback_form = true;
		require('../resources/global/footer.php') ?>
		</div><!--container-fluid ends-->
	</body>
</html>