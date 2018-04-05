<?php 
require('../resources/master_script.php'); 
 //confirm if user is still logged in 
if($status != 1){
	$tool->redirect_to('../login?return='.$current_url);
}
	
function checkbox($source,$condition){
		if($source==$condition){
			return "checked=\"checked\"";
		}else
	{ return null;}
	}
//If it is 0, it means it was not changed because the value is 0 by default, therefore, return the old value
function checkRadiochanges($oldvalue,$newvalue){
		if($newvalue==0){
			return $oldvalue;
		}else{
			return $newvalue;
		}
	}
	
//If it is 0, it means it was no changed because the value is 0 by default, therefore, return the old value
	function changefacility($oldvalue,$newvalue){
	if($newvalue==0){
		return $oldvalue;
	}	
	else{
		return $newvalue;
	}
}


if(isset($_POST['change_status'])){
	$newstatus = ($_POST['newStatus']=='nil' ? $_POST['oldStatus'] : $_POST['newStatus']);
	$pid = $_POST['pid'];
	$update_status = $db->query_object("UPDATE properties SET status = '$newstatus',last_reviewed=".time()." WHERE property_ID='$pid'");
	if($db->connection->affected_rows == 1){
		$updateReport = "Property status have been updated successfully<p>This property status is now <b>$newstatus</b></p>";
		$case = 1;
	}
	else{
		$updateReport = "No change was made to the property status, This property is still $newstatus";
		$case = 0;
	}

}

// Here handles updating of record
if(isset($_POST['edit']) && $status==1){


	if(!is_numeric($_POST['rent'])){
$updateReport = "Invalid amount for rent";
				$case = 5;
	}
else{
			$newpm = (isset($_POST['newpm']) ? $_POST['newpm'] : 'No');
			$newbh = (isset($_POST['newbh']) ? $_POST['newbh'] : 'No');
			$newwell = (isset($_POST['newwell']) ? $_POST['newwell'] : 'No');
			$newtiles = (isset($_POST['newtiles']) ? $_POST['newtiles'] : 'No');
			$newps = (isset($_POST['newps']) ? $_POST['newps'] : 'No');

			$update = "UPDATE properties SET 
						rent=".$_POST['rent'].",
						min_payment='".checkRadiochanges($_POST['oldminPay'],$_POST['newminPay'])."',
						pumping_machine='".$newpm."',
						borehole='".$newbh."',
						well='". $newwell."',
						tiles='".$newtiles."',
						parking_space='".$newps."',
						electricity=".changefacility($_POST['oldElectricity'],$_POST['newElectricity']).",
						road=".changefacility($_POST['oldRoad'],$_POST['newRoad']).",
						socialization=".changefacility($_POST['oldSocial'],$_POST['newSocial']).",
						security=".changefacility($_POST['oldSecurity'],$_POST['newSecurity']).",
						description='".$tool->clean_input($_POST['description'])."',
						last_reviewed=".time()." 
						WHERE (property_ID='".$_POST['id']."')";
			//echo $update;
			$updateQuery = $db->query_object($update);
			if(!$db->connection->error){ 
				if($db->connection->affected_rows==1){
					$updateReport = "Changes saved successfully";
					$case = 1;
				}
				else if($connection->affected_rows > 1){
					$updateReport = "Oops!, Something went wrong";
					$case = 2;
				}
				else{
					$updateReport = "No changes were made";
					$case = 3;
				}
			}
			else{
				$updateReport = "Changes could not be saved due to some errors";
				$case = 4;
			}
		}		

}
/**Here handles fetching of the records on page load. the agent token stored in the cookies is verified with the token of
**of agent that uploaded the property**/
	if(isset($_GET['action']) && isset($_GET['agent']) && $_GET['agent'] == $_COOKIE['user_agent']){
		if(isset($_GET['id']) && !empty($_GET['id'])){
				$property = new property($tool->clean_input($_GET['id']));
					if($property->property_exist()){
						$editdir = $property->p_directory;
						$editid = $property->id;
						$edittype = $property->type;
						$editlocation = $property->location;
						$editrent = $property->rent;
						$editmp = $property->min_payment;
						$editbath = $property->bath;
						$edittoilet = $property->loo;
						$editpm = $property->pmachine;
						$editbh = $property->borehole;
						$editwell = $property->well;
						$edittiles = $property->tiles;
						$editps = $property->parking_space;
						$editelectricity = $property->electricity;
						$editroad = $property->road;
						$editsocial = $property->social;
						$editsecurity = $property->security;
						$editdescription = $property->description;
						$views = $property->views;
						$LR = $property->last_reviewed;
						$editstatus= $property->status;
						$display_photo = $property->display_photo;
						$url = $property->url;

//after verifying property, if delete action is invoked and not returning from file uploading or property just updating
if(isset($_GET['img']) && isset($_GET['op']) && !isset($_FILES['photo']) && !isset($_POST['change_status'])){
	//verify the tokens
	$_all_images_ = $tool->get_images("../$url");
//get all the photos in the directory
if(count($_all_images_) != 0){
//loop through all the photos...
	foreach($_all_images_ as $image){
//find the one that matches the target
		if(SHA1($image)==$_GET['img']){
//unlink!
//if deleting
if($_GET['op'] == SHA1('delete'.$editid)){
			if(unlink($image)){
$delete_report = "Photo deleted successfully";
$deleted = true;
			}
			else{
$delete_report = "Photo delete failed";
			}
			}
//if updating the display picture
			else if($_GET['op'] == SHA1('set_display'.$editid) && isset($_GET['dp'])){
				$new_display_image = $tool->clean_input($_GET['dp']);
if($db->query_object("UPDATE properties SET display_photo ='$new_display_image',last_reviewed=".time()." WHERE property_ID='$editid'")){
$display_photo_update_report = "Property display picture changed successfully";
$display_photo = $new_display_image;
$dp_changed = true;
}
else{
$display_photo_update_report = "Property display picture could not be changed";
}
			}
		}
	}
}
else{
	$delete_report = "No image in the directory";
			}

		} //photo deletion ends here

	}
	else{
			$fetchReport = "<div class=\"operation-fail-container fail\">ID is invalid or you do not have authorization to review this property</div>";
			}
		}
		else{
			$fetchReport = "No valid ID to operate on";
		}
	}
	else{
		$tool->redirect_to('../manage');	
	}
	
	
//Get all the available images
$lastImage = 0;
$newimage = 1;
$allImages = "";
$allImages_array = $tool->get_images("../$url");
$lastImage = count($allImages_array);
$newimage = $lastImage+1;

	//here handles upload of photo
if(isset($_FILES['photo'])){
$max_upload = 10;

	if($lastImage >= $max_upload){
$photoupload_report = "You have reached the limit of $max_upload photos!";
$image_upload_status =0;
	}
else{
$mb = ($_FILES['photo']['size'])/1000000;
if($tool->is_upload_image(($_FILES['photo']['type']))){
$format = '.'.substr($_FILES['photo']['type'],1+strpos($_FILES['photo']['type'],'/'));
	if (move_uploaded_file ($_FILES['photo']['tmp_name'],"../$url/$editid"."_0$newimage".$format)) {
	$photoupload_report = " One new Photo added successfully";
	$image_upload_status =1;
	//update the last reviewed
	$property->update_last_updated();
	//Rescan and get all the images again so that the new image is included 
	$allImages_array = $tool->get_images("../$url");
}
else{
	$photoupload_report = "upload unsuccesful try again: ".$_FILES['photo']['error'];
	$image_upload_status=0;
}	
}
else{
	$photoupload_report = "Unsupported file format";
	$image_upload_status=0;
}
}
}


?>

<html>
<head>
<?php 
$pagetitle = "Update Property";
	$ref='editproperty';
require('../resources/global/meta-head.php'); ?>
					<style>
						.edit-box{
							padding:3px 8px;
							border:1px solid #e3e3e3;
							border-radius:3px;
							box-shadow:0px 2px 2px rgba(0,0,0,0.1) inset;
							float:right;
							margin-right:20px;
						}
						.edit-box:hover{
							background-color:#f7f7f7;
						}
						[data-toggle-role='main-toggle']{
							position:absolute;
							background-color:#f7f7f7;
							box-shadow:0px 5px 5px #555;
							border-radius:5px;
							padding:20px;
							width:300px;
							z-index:2;
						}
						[data-toggle-role='main-toggle']#description-textarea{
							width:70%;
						}
						
					</style>

	</head>
<body>
<?php
$altHeaderContent ="<span >Update Property   <span class=\"text-right\"><a href=\"../upload\" class=\"btn btn-default margin-5 site-color-background white\"><span class=\"glyphicon glyphicon-upload\"></span>  upload new property</a></span></span>";
	require('../resources/global/alt_static_header.php');
?>
<style>
.container-fluid{
	padding-top:80px;
}
</style>
<div class="container-fluid pad-lg pad-md-pad-sm no-pad-xs">
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="center-content">
			<?php
				if(isset($fetchReport)){
					?>
					<div class="operation-report-container fail"><?php echo $fetchReport ?></div>
					<?php
						$tool->halt_page();
					}
			?>		
		</div>
	</div>


	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<div class="head f7-background">
				<h4 class="text-left ">
					<img src="<?php echo $property->display_photo_url()?>" class="mini-property-image size-50"/>
					<a class="site-color" href="<?php echo "../$url" ?>"> <?php echo $edittype ?><span class="grey font-14">(<?php echo $editid ?>)</span></a>
				</h4>
				<p class="text-left grey"><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $editlocation ?></p>
			</div>
			<div class="body white-background">
				<div style="margin:10px 0px">
					<div class="center-content">
						<?php 
						//Here gives the report of the editing. successful or fail
						if(isset($updateReport)){
						?>
						<div class="operation-report-container <?php echo($case==1 ? "success" : "fail")?>"><?php echo $updateReport ?> </div>
						<?php
						}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="contain">
							<div class="head f7-background">
								<h4 class="text-left">Stats</h4>
								<p class="text-left grey">Activities on this property</p>
							</div>
							<div class="body white-background">
								<p><span class="glyphicon glyphicon-eye-open"></span><?php echo $views ?> views</p>
								<p><span class="glyphicon glyphicon-paperclip"></span>  clipped by 0 clients</p>
								<p><span class="glyphicon glyphicon-share-alt"></span>  suggested to 0 clients</p>
								<p><span class="glyphicon glyphicon-pencil"></span>Last updated : <?php echo ($tool->since($LR)=='invalid time' ? "<span style=\"color:red\">Not reviewed yet</span>" : $tool->since($LR)) ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="contain">
							<div class="head f7-background">
								<h4 class="text-left">Status</h4>
								<p class="text-left grey">Confirm if this property is still <strong><?php echo $editstatus?></strong></p>
							</div>
							<div class="body white-background">
									<form action="<?php $_PHP_SELF ?>" method="POST">
										<input type="hidden" name="pid" value="<?php echo $editid ?>"/>
										<input type="hidden" name="oldStatus" value="<?php echo $editstatus ?>"/>
										<?php
										if($editstatus=='Available'){
											$status_ = "<span class=\"padding-10 site-color-background white border-radius-3\" >
														<span class=\"glyphicon glyphicon-ok\"></span>  $editstatus</span>";
										}
										else if($editstatus=='Leased out'){
											$status_ = "<span class=\"padding-10 red-background white border-radius-3\" >
														<span class=\"glyphicon glyphicon-remove\"></span>$editstatus</span>";
										}
										else{
											$status_ = "<span class=\"padding-10 red-background white border-radius-3\" >
														<span class=\"glyphicon glyphicon-remove\"></span>$editstatus</span>";
										}
										?>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
												<?php echo $status_ ?>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<div class="form-group">
													<select class="form-control" name="newStatus">
														<option value="nil" >Change</option>
														<option value="Available">Available</option>
														<option value="Leased out">Leased out</option>
													</select>
												</div>
											</div>

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
												<div class="form-group">
													<input type="submit" name="change_status" value="change status" class="btn btn-primary" style="border:none"/>
												</div>
											</div>
										</div>
									</form>
							</div>
						</div>
					</div>
					

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="contain">
							<div class="head f7-background">
								<h4 class="text-left">Photos</h4>
								<p class="text-left grey">Photos you uploaded to showcase this property</p>
							</div>
							<div class="body white-background">
								<div style="margin:10px 0px">
									<div class="center-content">
										<?php
										//The photo upload report is printed here
										if(isset($photoupload_report) && !empty($photoupload_report)){
											if($image_upload_status == 1){
												?>
										<div class="operation-report-container success"><?php echo $photoupload_report ?></div>
										<?php
											}
											else{
												?>
											<div class="operation-report-container fail"><?php echo $photoupload_report ?> </div>
											<?php
											}
										}
										
										if(isset($delete_report)){
										?>
										<div class="operation-report-container <?php echo (isset($deleted) ? "success" : "fail") ?>">
											<?php echo $delete_report ?>
										</div>
										<?php
										}
										
										if(isset($display_photo_update_report)){
											?>
											<div class="operation-report-container <?php echo (isset($dp_changed) ? "success" : "fail") ?>" >
												<?php echo $display_photo_update_report ?>
											</div>
										<?php	
										}
										?>
									</div>
								</div>
							<?php
								//if there is no any photo
								if(count($allImages_array)==0){
									?>
								<div class="e3-border padding-10 text-center">
									<p class="red"><span class="glyphicon glyphicon-picture"></span>  You have no added any photo to this property</p>
									<p class="grey">Adding photo to your properties impress clients more and give them clue on what the property looks like.</p>
								</div>
								<?php
								}
								else{
									?>
									<div class="text-center">
										<?php
										foreach($allImages_array as $photo){
										?>			
											<div class="inline-block">
												<img alt="<?php echo $editid.' image' ?>" style="width:250px; height:250px; margin: 2px" src="<?php echo $photo ?>" />
												<?php 
												//strip off the image name
												$image_name = substr($photo,strlen('..properties/'.$editdir.'//'));
												 ?>
												<div class="font-12">
															<a href="<?php echo '?id='.$editid.'&action=change&agent='.$_COOKIE['user_agent'].'&img='.SHA1($photo).'&op='.SHA1('delete'.$editid) ?>"><span title="Delete photo" class="glyphicon glyphicon-trash red float-right"></span></a>
													<?php 
													if($display_photo != $image_name){
														?>
															<a href="<?php echo '?id='.$editid.'&action=change&agent='.$_COOKIE['user_agent'].'&img='.SHA1($photo).'&dp='.$image_name.'&op='.SHA1('set_display'.$editid) ?>"><span title="Use as display photo" class=""></span> set display photo</a>
													<?php
													}
													else{
													echo "<span>current display photo</span>";
													}	
													?>
												</div>
											</div>
										<?php
										}
										?>
									</div>
									<?php
								}
								?>
								<div class="center-content" data-action="toggle">
									<a data-toggle-role="toggle-trigger" data-toggle-on="<span class='glyphicon glyphicon-camera red'></span>  Add photo later"  data-toggle-off="<span class='glyphicon glyphicon-camera'></span>  <?php echo ($allImages =="" ? "Add photo" : "Add more photo")?>" class="btn btn-primary margin-5"></a>
									<div data-toggle-role ="main-toggle" id="add-photo-box">
										<div class="edit-box-container">
										<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
										<input type="hidden" name="photoname" value="<?php echo $editid."_0$newimage";?>" />
										<input class="form-control" type="file" name="photo" />
										<input type="submit" value="upload" class="btn btn-primary margin-5" style="border:none">
										</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<form name="update-form" action="<?php $_PHP_SELF ?>" method="POST">
							<input name="id" type="hidden" value="<?php echo $editid ?>" />
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<div class="form-group padding-5 e3-border" data-action="toggle">
										<p>Rent: <strong><?php echo number_format($editrent)?></strong>
											<span title="edit rent" data-toggle-role="toggle-trigger" class="edit-box"><span class="glyphicon glyphicon-pencil"></span></span>
										</p>
										<div data-toggle-role="main-toggle">
											<input placeholder="Rent" name="rent" type="number" value="<?php echo $editrent ?>" class="form-control"/>
										</div>
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<div class="form-group  padding-5 e3-border" data-action="toggle">
										<p>Minimum Payment required: <?php echo $editmp ?>
											<span title="edit minimum payment reqiured for this property" data-toggle-role="toggle-trigger" class="edit-box"><span class="glyphicon glyphicon-pencil"></span></span>
										</p>

										<div data-toggle-role="main-toggle">
											<input name="oldminPay" type="hidden" value="<?php echo $editmp?>"/>
											<input class="dumb-input" name="newminPay" checked="true" type="radio" value="0"/>
											<div class="radio">
												<label>
												<input name="newminPay"  type="radio" value="1 Year"/>   1 Year</label>
											</div>
											<div class="radio">
												<label>
												<input name="newminPay"  type="radio" value="1 Year, 6 Months"/>   1 Year 6 Months</label>
											</div>
											<div class="radio">
												<label>
												<input name="newminPay"  type="radio" value="2 Years"/>   2 Years</label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
									<div class="form-group  padding-5 e3-border">
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
												<p>Bathroom(s): <?php echo $editbath ?></p>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
												<p>Toilet(s): <?php echo $edittoilet ?></p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<h4>Water Supply</h4>
										<p class="grey">Check if presence or uncheck if absent</p>

										<input name="oldpm" type="hidden" value="<?php echo $editpm?>"/>
										<div class="checkbox">
											<label>
											<input name="newpm" type="checkbox" value="Yes" <?php echo checkbox($editpm,'Yes') ?>/>  Pumping Machine</label>
										</div>

										 
										<input name="oldbh" type="hidden" value="<?php echo $editbh?>"/>
										<div class="checkbox">
											<label>
											<input name="newbh" type="checkbox" value="Yes" <?php echo checkbox($editbh,'Yes') ?> />  Borehole</label>
										</div>


										<input name="oldwell" type="hidden" value="<?php echo $editwell?>"/>
										<div class="checkbox">
											<label>
											<input name="newwell" type="checkbox" value="Yes" <?php echo checkbox($editwell,'Yes') ?> />   Well</label>
										</div>

									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<h4>Other Facilities</h4>
										<p class="grey">Check if presence or uncheck if absent</p>

										<input name="oldtiles" type="hidden" value="<?php echo $edittiles?>"/>
										<div class="checkbox">
											<label>
											<input name="newtiles" type="checkbox" value="Yes" <?php echo checkbox($edittiles,'Yes') ?> />   Tiles</label>
										</div>

										<input name="oldps" type="hidden" value="<?php echo $editps?>"/>
										<div class="help-block">
											<label>
											<input name="newps" type="checkbox" value="Yes" <?php echo checkbox($editps,'Yes') ?> />   Parking Space</label>
										</div>
									</div>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group center-content">
										<div class="contain">
											<div class="head f7-background">
												<h4>Property Description</h4>
											</div>
											<div class="body white-background">
												<div class="form-group" data-action="toggle">
													<p>
														<?php echo ($editdescription == "" ? "<span class=\"red\"><span class=\"glyphicon glyphicon-alert\"></span>No description</span>" : "$editdescription" ) ?>
														<span class="edit-box" data-toggle-role="toggle-trigger"><span class="glyphicon glyphicon-pencil"></span></span>
													</p>
													<div data-toggle-role="main-toggle" id="description-textarea">
														<p class="grey">Edit Description</p>
														<textarea name="description" placeholder="Give a brief description of the property" class="form-control" ><?php echo $editdescription ?></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="contain">
										<div class="head f7-background">
											<h4>Rating</h4>
										</div>
										<div class="body">
											<div class="row">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<div class="form-group e3-border padding-5" data-action="toggle">
														<p>Electricity:<input type="hidden" name="oldElectricity" value="<?php echo $editelectricity ?>" />
														 <?php echo $editelectricity."%" ?> <span class="edit-box" data-toggle-role="toggle-trigger"><span class="glyphicon glyphicon-pencil"></span></span>
														 </p>
														<div class ="row" data-toggle-role="main-toggle">
															<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6">Electricity</label>
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																 <select class="form-control" name="newElectricity">
																	<option value="0">0%</option>
																	<option value="10">10%</option>
																	<option value="15">15%</option>
																	<option value="20">20%</option>
																	<option value="30">30%</option>
																	<option value="40">40%</option>
																	<option value="50">50%</option>
																	<option value="60">60%</option>
																	<option value="70">70%</option>
																	<option value="80">80%</option>
																	<option value="90">90%</option>
																	<option value="100">100%</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<div class="form-group  e3-border padding-5" data-action="toggle">
														<p>Road:<input type="hidden" name="oldRoad" value="<?php echo $editroad ?>" />
														 <?php echo $editroad."%" ?> <span  class="edit-box" data-toggle-role="toggle-trigger"><span class="glyphicon glyphicon-pencil"></span></span></p>
														<div class ="row" data-toggle-role="main-toggle">
															<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6">Road </label>
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																<select class="form-control" name="newRoad">
																	<option value="0">0%</option>
																	<option value="10">10%</option>
																	<option value="15">15%</option>
																	<option value="20">20%</option>
																	<option value="30">30%</option>
																	<option value="40">40%</option>
																	<option value="50">50%</option>
																	<option value="60">60%</option>
																	<option value="70">70%</option>
																	<option value="80">80%</option>
																	<option value="90">90%</option>
																	<option value="100">100%</option>
																</select>
															</div>
														</div>
													</div>												
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<div class="form-group  e3-border padding-5" data-action="toggle">
														<p>Socialization: <input type="hidden" name="oldSocial" value="<?php echo $editsocial ?>" />
															<?php echo $editsocial."%" ?> <span class="edit-box" data-toggle-role="toggle-trigger">
															<span class="glyphicon glyphicon-pencil"></span>
															</span>
														</p>

														<div class ="row" data-toggle-role="main-toggle">
															<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6">Socialization</label>
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																<select class="form-control" name="newSocial">
																	<option value="0">0%</option>
																	<option value="10">10%</option>
																	<option value="15">15%</option>
																	<option value="20">20%</option>
																	<option value="30">30%</option>
																	<option value="40">40%</option>
																	<option value="50">50%</option>
																	<option value="60">60%</option>
																	<option value="70">70%</option>
																	<option value="80">80%</option>
																	<option value="90">90%</option>
																	<option value="100">100%</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<div class="form-group  e3-border padding-5" data-action="toggle">
														<p>Security: <input type="hidden" name="oldSecurity" value="<?php echo $editsecurity ?>" />
															<?php echo $editsecurity."%" ?> <span class="edit-box" data-toggle-role="toggle-trigger"><span class="glyphicon glyphicon-pencil"></span>
														</p>

														<div class ="row" data-toggle-role="main-toggle">
															<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6">Security</label> 
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																<select class="form-control" name="newSecurity">
																	<option value="0">0%</option>
																	<option value="10">10%</option>
																	<option value="15">15%</option>
																	<option value="20">20%</option>
																	<option value="30">30%</option>
																	<option value="40">40%</option>
																	<option value="50">50%</option>
																	<option value="60">60%</option>
																	<option value="70">70%</option>
																	<option value="80">80%</option>
																	<option value="90">90%</option>
																	<option value="100">100%</option>
																</select>
															</div>
														</div>
													</div>												
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group center-content text-right" style="margin-top:100px">
										<input type="submit" class="btn btn-default site-color-background white" name="edit" value="save updated details">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div><!--parent-row-->
 </div><!--container-fluid-->
 
 
<div>
<?php 
require('../resources/global/footer.php'); ?>
</div>

</body>
</html>