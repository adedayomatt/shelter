<?php 
require('../resources/php/master_script.php'); 
 //confirm if user is still logged in 
if($status != 1){
	$general->redirect('login?return='.$thisPage);
}
	
function checkbox($source,$condition){
		if($source==$condition){
			return "checked=\"checked\"";
		}else
	{ return null;}
	}
	
?>

<html>
<head>
<?php 
$pagetitle = "Edit property";
	$ref='editproperty';
require('../resources/global/meta-head.php'); ?>
<link href="../css/propertyedit_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/editscript.js"></script>

	</head>
<body class="plain-colored-background">
<?php

if(isset($_POST['change_status'])){
	$newstatus = ($_POST['newStatus']=='nil' ? $_POST['oldStatus'] : $_POST['newStatus']);
	$pid = $_POST['pid'];
	$update_status = $db->query_object("UPDATE properties SET status = '$newstatus',last_reviewed=$now WHERE property_ID='$pid'");
	if($connection->affected_rows == 1){
		$changeReport = "Property status have updated successfully<p>This property status is now <b>$newstatus</b></p>";
		$case = 1;
	}
	else{
		$changeReport = "No change was made to the property status, This property is still $newstatus";
		$case = 0;
	}

}

// Here handles editing of record
if(isset($_POST['edit']) && $status==1){
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
	if(!is_numeric($_POST['rent'])){
$changeReport = "Invalid amount for rent";
				$case = 5;
	}
else{			$newpm = (isset($_POST['newpm']) ? $_POST['newpm'] : 'No');
			$newbh = (isset($_POST['newbh']) ? $_POST['newbh'] : 'No');
			$newwell = (isset($_POST['newwell']) ? $_POST['newwell'] : 'No');
			$newtiles = (isset($_POST['newtiles']) ? $_POST['newtiles'] : 'No');
			$newps = (isset($_POST['newps']) ? $_POST['newps'] : 'No');

			$update = "UPDATE properties SET "; 
			$update .= "rent=".$_POST['rent'].",";
			$update .= "min_payment='".checkRadiochanges($_POST['oldminPay'],$_POST['newminPay'])."',";
			$update .= "pumping_machine='".$newpm."',";
			$update .= "borehole='".$newbh."',";
			$update .= "well='". $newwell."',";
			$update .= "tiles='".$newtiles."',";
			$update .= "parking_space='".$newps."',";
			$update .= "electricity=".changefacility($_POST['oldElectricity'],$_POST['newElectricity']).",";
			$update .= "road=".changefacility($_POST['oldRoad'],$_POST['newRoad']).",";
			$update .= "socialization=".changefacility($_POST['oldSocial'],$_POST['newSocial']).",";
			$update .= "security=".changefacility($_POST['oldSecurity'],$_POST['newSecurity']).",";
			$update .= "description='".$connection->real_escape_string($_POST['description'])."',";
			$update .= "last_reviewed=$now";
			$update .= " WHERE (property_ID='".$_POST['id']."')";
			//echo $update;
			$updateQuery = $db->query_object($update);
			if(!$connection->error){ 
				if($connection->affected_rows==1){
					$changeReport = "Changes saved successfully";
					$case = 1;
				}
				else if($connection->affected_rows>1){
					$changeReport = "Oops!, Something went wrong";
					$case = 2;
				}
				else{
					$changeReport = "No changes were made";
					$case = 3;
				}
			}
			else{
				$changeReport = "Changes could not be saved due to some errors";
				$case = 4;
			}
}		

}
?>
	
<?php
/**Here handles fetching of the records on page load. the agent token stored in the cookies is verified with the token of
**of agent that uploaded the property**/
	if(isset($_GET['action']) && isset($_GET['agent']) && isset($_GET['agent']) && $_GET['agent'] == $_COOKIE['user_agent']){
		if(isset($_GET['id']) && !empty($_GET['id'])){
				$getformerdetail = "SELECT * FROM properties WHERE (property_ID = '".$_GET['id']."' AND uploadby = '$profile_name')";
				$getquery = $db->query_object($getformerdetail);
				if(!$connection->error){
					if($connection->affected_rows==1){
					while($detail = $getquery->fetch_array(MYSQLI_ASSOC)){
						$editdir = $detail['directory'];
						$editid = $detail['property_ID'];
						$edittype = $detail['type'];
						$editlocation = $detail['location'];
						$editrent = $detail['rent'];
						$editmp = $detail['min_payment'];
						$editbath = $detail['bath'];
						$edittoilet = $detail['toilet'];
						$editpm = $detail['pumping_machine'];
						$editbh = $detail['borehole'];
						$editwell = $detail['well'];
						$edittiles = $detail['tiles'];
						$editps = $detail['parking_space'];
						$editelectricity = $detail['electricity'];
						$editroad = $detail['road'];
						$editsocial = $detail['socialization'];
						$editsecurity = $detail['security'];
						$editdescription = $detail['description'];
						$views = $detail['views'];
						$LR = $detail['last_reviewed'];
						$editstatus= $detail['status'];
						$display_photo = $detail['display_photo'];
					}

//after verifying property, if delete action is invoked and not returning from file uploading or property just updating
if(isset($_GET['img']) && isset($_GET['op']) && !isset($_FILES['photo']) && !isset($_POST['change_status'])){
	//verify the tokens
	$_all_images_ = $general->get_images("../properties/$editdir");
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
			}
			else{
$delete_report = "Photo delete failed";
			}
			}
//if updating the display picture
			else if($_GET['op'] == SHA1('set_display'.$editid) && isset($_GET['dp'])){
				$new_display_image = htmlentities(trim($_GET['dp']));
if($db->query_object("UPDATE properties SET display_photo ='$new_display_image',last_reviewed=$now WHERE property_ID='$editid'")){
$display_photo_update_report = "Property display picture changed successfully";
$display_photo = $new_display_image;
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

					}else{ $fetchReport = "<div color:\" class=\"operation-fail-container\"><span class=\"black-icon warning-icon\"></span>ID is invalid or you do not have authorization to review this property</div>";}
				}else{$fetchReport = "<div class=\"operation-fail-container\"><span class=\"black-icon warning-icon\"></span>Couldn't get the property details</div>";}
			
		}
		else{
			$fetchReport = "No valid ID to operate on";
		}
	}
	else{
		$general->redirect('manage');	
	}
	
if(isset($fetchReport)){
	?>
	<div class="operation-report-container fail" style="margin-top:10%"><?php echo $fetchReport ?></div>
	<?php
		$general->halt_page();
	}

//Get all the available images
$lastImage = 0;
$newimage = 1;
$allImages = "";
$allImages_array = $general->get_images("../properties/$editdir");
$lastImage = count($allImages_array);
$newimage = $lastImage+1;

	//here handles upload of photo
if(isset($_FILES['photo'])){
$max_upload = upload_config::$max_photo;

	if($lastImage >= $max_upload){
$photoupload_report = "You have reached the limit of $max_upload photos!";
$image_upload_status =0;
	}
else{
$mb = ($_FILES['photo']['size'])/1000000;
if($general->is_upload_image(($_FILES['photo']['type']))=='clean'){
$format = '.'.substr($_FILES['photo']['type'],1+strpos($_FILES['photo']['type'],'/'));
	if (move_uploaded_file ($_FILES['photo']['tmp_name'],"../properties/$editdir/$editid"."_0$newimage".$format)) {
	$photoupload_report = " One new Photo added successfully";
	$image_upload_status =1;
	//update the last reviewed
	$db->query_object("UPDATE properties SET last_reviewed = $now WHERE property_ID= '$editid'");
	//Rescan and get all the images again so that the new image is included 
	$allImages_array = $general->get_images("../properties/$editdir");
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


<?php
$altHeaderContent ="Edit Property";
	require('../resources/global/alt_static_header.php');
	?>
<div class="container-fluid body-content" style="padding-top:60px">
<div class="center-content white-background padding-10 box-shadow-1">
<div class="">
<h4 class="font-18"><a class="red" href="<?php echo "$root/properties/$editdir" ?>"> <?php echo $editid .": ".$edittype ?> </a></h4>
</div>
 <?php 
//Here gives the report of the editing. successful or fail
if(isset($changeReport)){
switch ($case){
	case 1:
	$icon = "tick-icon";
	$class = "success";
	break;
	case 3:
	$icon =  "cross-icon";
	$class = "fail";
	break;
		default:
	$icon = "cross-icon";
	$class = "fail";
	break;
}
echo "<div class=\" operation-report-container $class\" style=\"margin-bottom:20px\">$changeReport</div>";
}
	?>
  
<div class="row">
<form action="<?php $_PHP_SELF ?>" method="POST">
<input type="hidden" name="pid" value="<?php echo $editid ?>"/>
<input type="hidden" name="oldStatus" value="<?php echo $editstatus ?>"/>
<?php
if($editstatus=='Available'){
	$status_ = "<span class=\"padding-10 site-color-background white border-radius-3\" >
	<span class=\"glyphicon glyphicon-ok\"></span>$editstatus</span>";
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
<select class="form-control" name="newStatus">
	<option value="nil" >Change</option>
	<option value="Available">Available</option>
	<option value="Leased out">Leased out</option>
</select>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin-top:10px">
<input type="submit" name="change_status" value="change status" class="btn btn-primary" style="border:none"/>
</div>
</div>
</form>
</div>

<div class="row">
<div class="edit-box-container grey">
<p><span class="glyphicon glyphicon-map-marker"></span><?php echo $editlocation ?></p>
  </div>
  </div>
  
  <div class="row">
<div class="edit-box-container grey">
<p><span class="glyphicon glyphicon-eye-open"></span><?php echo $views ?> views</p>
<p><span class="glyphicon glyphicon-pencil"></span>Last reviewed : <?php echo ($general->since($LR)=='invalid time' ? "<span style=\"color:red\">Not reviewed yet</span>" : $general->since($LR)) ?></p>
</div>
</div>

<?php if(isset($delete_report)){
	?>
	<div class="row">
	<div class="operation-report-container">
	<?php echo $delete_report ?>
	</div>
	</div>
<?php
}
else if(isset($display_photo_update_report)){
	?>
	<div class="row">
	<div class="operation-report-container">
	<?php echo $display_photo_update_report ?>
	</div>
	</div>
<?php	
}
?>

<div class="row" >
<?php 
//if there is no any photo
if(count($allImages_array)==0){
echo "<div class=\"e3-border padding-5 text-center\">
<p class=\"red\"><span class=\"glyphicon glyphicon-picture\"></span>There is no photo available for this property</p>
<p class=\"grey\">Adding photo to your properties impress clients more and give them clue on what the property looks like.</p>
</div>";
}
else{
	foreach($allImages_array as $photo){
	?>
	<div style="display:inline-block">
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
}
?>
	
<div>
<?php
//The photo upload report is printed here
if(isset($photoupload_report) && !empty($photoupload_report)){
	if($image_upload_status == 1){
echo "<div class=\"operation-report-container success\">$photoupload_report</div>";
	}
	else{
echo "<div class=\"operation-report-container fail\">$photoupload_report</div>";
	}
}
?>
<a id="add-photo-link" class="btn btn-primary margin-5"><span class="glyphicon glyphicon-camera"></span><?php echo ($allImages =="" ? "Add photo" : "Add more photo")?></a>
<div class ="edit-box" id="add-photo-box">
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

<div class="row">
<fieldset>
<form name="update-form" action="<?php $_PHP_SELF ?>" method="POST">
<input name="id" type="hidden" value="<?php echo $editid ?>" />

<div class="form-group edit-box-container">
<p class="stay-on-a-line">Rent: <?php echo number_format($editrent)?> <span id="editrent_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>
<div class ="edit-box" id="editrent_box">
<input placeholder="Rent" name="rent" type="number" value="<?php echo $editrent ?>" class="form-control"/></div>
</div>

<div class="form-group edit-box-container">
<p>Minimum Payment required: <?php echo $editmp?> <span id="editmp_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>

<div div class ="edit-box" id="editmp_box">
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

<div class=" form-group edit-box-container grey">
<p>Bathroom(s): <?php echo $editbath ?></p>
<p>Toilet(s): <?php echo $edittoilet ?></p>
</div>


<h3 class="headings">Water Supply</h3>

<div class="form-group edit-box-container">
<p class="help-block">Check if presence or uncheck if absent</p>

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

<h3 class="headings">Others</h3>
<div class="form-group edit-box-container">
<p class="help-block">Check if presence or uncheck if absent</p>

<input name="oldtiles" type="hidden" value="<?php echo $edittiles?>"/>
<div class="checkbox">
<label>
<input name="newtiles" type="checkbox" value="Yes" <?php echo checkbox($edittiles,'Yes') ?> />   Tiles</label>
</div>

<input name="oldps" type="hidden" value="<?php echo $editps?>"/>
<div class="help-block">
<label>
<input name="newps" type="checkbox" value="Yes" <?php echo checkbox($editps,'Yes') ?>/>   Parking Space</label>
</div>

</div>

<div class="form-group">
<h3 class="headings">Property Description</h3>
<div class="edit-box-container" id="edit-box-container-description">
<p><?php echo (empty($editdescription) ? "<span class=\"red\"><span class=\"glyphicon glyphicon-alert\"></span>No description</span>" : "$editdescription" ) ?>
<span id="editdescription_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>
<div class ="edit-box" id="editdescription_box">
<textarea name="description" placeholder="Give a brief description of the property" class="form-control" ><?php echo $editdescription ?></textarea>
</div>
</div>
</div>

<h3 class="headings">Property Rating</h3>

<div class=" form-group edit-box-container">
<p>Electricity:<input type="hidden" name="oldElectricity" value="<?php echo $editelectricity ?>" />
 <?php echo $editelectricity."%" ?> <span id="editelectricity_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>
<div class ="row edit-box" id="editelectricity_box">
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

<div class="edit-box-container">
<p>Road:<input type="hidden" name="oldRoad" value="<?php echo $editroad ?>" />
 <?php echo $editroad."%" ?> <span id="editroad_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>
 
<div class ="row edit-box" id="editroad_box">
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

<div class="edit-box-container">
<p>Socialization: <input type="hidden" name="oldSocial" value="<?php echo $editsocial ?>" />
<?php echo $editsocial."%" ?> <span id="editsocial_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></span></p>

<div class ="row edit-box" id="editsocial_box">
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

<div class="edit-box-container">
<p>Security: <input type="hidden" name="oldSecurity" value="<?php echo $editsecurity ?>" />
<?php echo $editsecurity."%" ?> <span id="editsecurity_link" class="edit-link"><span class="glyphicon glyphicon-pencil"></span></p>

<div class ="row edit-box" id="editsecurity_box">
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

</fieldset>

<input class="btn btn-block site-color-background white" type="submit" name="edit" value="Save changes"/>
</form>

<form class="margin-10 text-right" action="delete.php" method="POST">
<input name="deleteid" type="hidden" value="<?php echo $editid ?>"/>
 <button name="submitdelete" class="btn red" type="submit" value="delete"><span class="glyphicon glyphicon-trash"></span> Delete this property</button>
  </form>
 </div>
 
 </div>
 </div>
<div>
<?php 
require('../resources/global/footer.php'); ?></div>

<script>
$(document).ready(function(){
	    toggleEdit('add-photo-link','add-photo-box');
		toggleEdit('editrent_link','editrent_box');
		toggleEdit('editmp_link','editmp_box');
		toggleEdit('editdescription_link','editdescription_box');
		toggleEdit('editelectricity_link','editelectricity_box');
		toggleEdit('editroad_link','editroad_box');
		toggleEdit('editsocial_link','editsocial_box');
		toggleEdit('editsecurity_link','editsecurity_box');
		
		
	});
	function toggleEdit(link,box){
		$('#'+link).click(function(){
			$('#'+box).toggle();
		});
	}
	function deleteP(){
		alert("you want to delete");
	}
</script>
</body>
</html>