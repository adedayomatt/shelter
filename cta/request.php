
<?php 
require('../resources/master_script.php'); 
if($status != 9){
	$tool->redirect_to('checkin.php');
}

if(isset($_POST['Request'])){
	$placeRequest = $loggedIn_client->new_cta_request($_POST['type'],$_POST['maxprice'],$_POST['area'],$_POST['city']);
	if($placeRequest == 99){
		$requestplacementReport = "Some fields are empty or filled incorrectly";	
		$sent = false;
	}
	else if($placeRequest == 900){
		$requestplacementReport = "Your placement could not be placed, try again later";
		$sent = false;
	}
	if($placeRequest == 100){
		$requestplacementReport = "<b>".$loggedIn_client->name." </b>, Your request has been placed, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
		$sent = true;
	}
}
	
else if(isset($_POST['Change'])){

	$changeRequest = $loggedIn_client->update_cta_request($_POST['type'],$_POST['maxprice'],$_POST['area'],$_POST['city']);
	if($changeRequest == 99){
		$changeReport = "Some fields are empty or filled incorrectly";	
		$change = false;
	}
	else if($changeRequest == 800){
		$changeReport = "No change was made to your request";
		$change = false;
	}
	if($changeRequest == 100){
		$changeReport = "<b>".$loggedIn_client->name." </b>, Your request has been <i>changed</i>, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
		$change = true;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		$pagetitle = "Request";
		$ref='ctarequest_page';
		require('../resources/global/meta-head.php'); 
		?>
	</head>

	<body>
		<?php
			$altHeaderContent ="CTA Request";
			require('../resources/global/alt_static_header.php');
			?>
			<div  class="container-fluid">
			<?php 
			//if no request has been made
			$request_type = $loggedIn_client->request_type;
			$request_maxprice = $loggedIn_client->request_maxprice;
			$request_area = $loggedIn_client->request_area;
			$request_city = $loggedIn_client->request_city;
			
			if($request_type == "" && $request_maxprice==0 && $request_area=="" && $request_city=="" ) {
				$requested = false;
			}
			else{
				$requested = true;
			}
		?>
			<div class="center-content">
				<?php
				if($request_type == "" && $request_maxprice==0 && $request_area=="" && $request_city=="") {
					if(!isset($_POST['request']) && !isset($_POST['change'])){
						?>
					<div class="white-background padding-10 e3-border text-center" style="margin-bottom:5%">
						<span class="glyphicon glyphicon-info-sign  icon-size-30 site-color"></span>
						<p><strong><?php echo $loggedIn_client->name ?></strong>, you have not specified your preferences of your choice of property. Kindly specify now</p>
					</div>
					<?php
					}
				}
				?>
				<div class="contain border-radius-5 e3-border">
					<div class="head f7-background">
						<h3>
						 <?php echo ($requested == true ? "Change Request" : "New CTA Request")?>
						 </h3>
					</div>
					<div class="body white-background">
						<form action="<?php $_PHP_SELF ?>" method="POST">
							<div class="margin-5">
								<?php if(isset($requestplacementReport) && $sent==false){
									echo "<div class=\"operation-report-container fail\"><p>$requestplacementReport</p></div>";
								}
								else if(isset($requestplacementReport) && $sent==true){
									echo "<div class=\"operation-report-container success\"><p>$requestplacementReport<br/><a href=\"index.php\">continue</a></p></div>";
									$tool->halt_page();
								}
								else if(isset($changeReport) && $change==true){
									echo "<div class=\"operation-report-container success\"><p>$changeReport<br/><a href=\"index.php\">continue</a></p></div>";
									$tool->halt_page();
								}
								else if(isset($changeReport) && $change==false){
									echo "<div class=\"operation-report-container fail\"><p>$changeReport</p></div>";
								}
								?>
							</div>
							<script type="text/javascript" >
							function setType(value){
								var typeInput = document.getElementById('type-input');
								typeInput.value = value;
							}
							</script>

							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
											<p>Property type : <span class="site-color bold"><?php echo (isset($_POST['type'])? $_POST['type'] : isset($request_type)? $request_type:'Not specified')?> </span></p>
											<input type="hidden" name="former_type" value="<?php echo $request_type ?>"/>
										</div>
										<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
											<select class="form-control" name="type">
												<option value="nil" ><?php echo ($requested == true ? "Change" : "Select Property type")?></option>
												<option value="Boys Quater" >Boys Quater</option>
												<option value="Bungalow" >Bungalow</option>
												<option value="Duplex">Duplex</option>
												<option value="Flat">Flat</option>
												<option value="Hall">Hall</option>
												<option value="Land">Land</option>
												<option value="Office Space">Office Space</option>
												<option value="Self Contain">Self Contain</option>
												<option value="Semi detached House">Semi detached House</option>
												<option value="Shop">Shop</option>
												<option value="Warehouse">Warehouse</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="maxprice">Maximum rent:</label>
									<input class="form-control more-padding" name="maxprice" type="text" maxlength="10"
									value="<?php echo (isset($_POST['maxprice'])? $_POST['maxprice'] : isset($request_maxprice)? $request_maxprice:'')?>"
									placeholder="Rent should not be more than..."/>
								</div>

								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="location"><span class="glyphicon glyphicon-map-marker"></span>Location:</label>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="padding-10">
												<input class="form-control more-padding" name="city" type="text" 
												value="<?php echo (isset($_POST['city'])? $_POST['city'] : isset($request_city)? $request_city:'')?>"
												placeholder="around where?"/>	
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<div class="padding-10">
												<input class="form-control more-padding" name="area" type="text" 
												value="<?php echo (isset($_POST['area'])? $_POST['area'] : isset($request_area)? $request_area:'')?>"
												placeholder="Area"/>								
											</div>
										</div>
									</div>
									<script>
										var city = document.querySelector("[name='city']");
										var area = document.querySelector("[name='area']");
										city.addEventListener('keyup',function(event){
											if(city.value == ""){
											area.setAttribute('placeholder', 'Area');
											}
											area.setAttribute('placeholder', 'Which area in '+city.value);
										});
										if(city.value == ""){
											area.setAttribute('editable', 'true');
										}else{
											area.setAttribute('editable', 'false');
										}
									</script>


								 </div>

								<div class="form-group">
									 <input class="btn btn-lg btn-block site-color-background white border-radius-0" name="<?php echo ($requested == true ? "Change" : "Request")  ?>"  
									 value="<?php echo ($requested == true ? "Change" : "Request") ?>" type="submit" />
									 
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>