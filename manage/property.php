<?php 
$connect = true;
require('../require/connexion.php'); 
 //confirm if user is still logged in 
if($status != 1){
	redirect();
}
	
function checkbox($source,$condition){
		if($source==$condition){
			return "checked=\"checked\"";
		}else{ return null;}
	}
	
function checkForImage($dir,$imgName){
	if(file_exists("../properties/$dir/$imgName")){
		$image = "<img alt=\"Not Available\" class=\"property-photo\" src=\"../properties/$dir/$imgName\" />
		";
		}else
		{
			$image = "";
		}
		return $image;
	}
?>

<html>
<?php require('../require/meta-head.html'); ?>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertyedit_styles.css" type="text/css" rel="stylesheet" />
<?php
	$pagetitle = "Change Detail";
	$ref='editproperty';
$getuserName=true;
	require('../require/header.php');
	?>
<script type="text/javascript" src="../js/editscript.js"></script>
	</head>
<body class="pic-background">
<?php
// Here handles editing of record
if(isset($_POST['edit'])){
	//If it is 0, it means it was no changed because the value is ) by default, therefore, return the old value
function checkRadiochanges($oldvalue,$newvalue){
		if($newvalue==0){
			return $oldvalue;
		}else{
			return $newvalue;
		}
	}
//If it is 0, it means it was no changed because the value is ) by default, therefore, return the old value
	function changefacility($oldvalue,$newvalue){
	if($newvalue==0){
		return $oldvalue;
	}	
	else{
		return $newvalue;
	}
	}
			$newpm = (isset($_POST['newpm']) ? $_POST['newpm'] : 'No');
			$newbh = (isset($_POST['newbh']) ? $_POST['newbh'] : 'No');
			$newwell = (isset($_POST['newwell']) ? $_POST['newwell'] : 'No');
			$newtiles = (isset($_POST['newtiles']) ? $_POST['newtiles'] : 'No');
			$newps = (isset($_POST['newps']) ? $_POST['newps'] : 'No');
			
			$update = "UPDATE properties SET "; 
			$update .= "rent=".$_POST['rent'].",";
			$update .= "min_payment='".checkRadiochanges($_POST['oldminPay'],$_POST['newminPay'])."',";
			$update .= "pumping_machine='".$newpm."',";
			$update .= "borehole='".$newbh."',";
			$update .= "well='".$newwell."',";
			$update .= "tiles='".$newtiles."',";
			$update .= "parking_space='".$newps."',";
			$update .= "electricity=".changefacility($_POST['oldElectricity'],$_POST['newElectricity']).",";
			$update .= "road=".changefacility($_POST['oldRoad'],$_POST['newRoad']).",";
			$update .= "socialization=".changefacility($_POST['oldSocial'],$_POST['newSocial']).",";
			$update .= "security=".changefacility($_POST['oldSecurity'],$_POST['newSecurity']).",";
			$update .= "description='".mysql_real_escape_string($_POST['description'])."',";
			$update .= "last_reviewed=$now";
			$update .= " WHERE (property_ID='".$_POST['id']."')";
			//echo $update;
			$updateQuery = mysql_query($update,$db_connection);
			if($updateQuery){ 
				if(mysql_affected_rows($db_connection)==1){
					$changeReport = "Changes saved successfully";
					$case = 1;
				}
				else if(mysql_affected_rows($db_connection)>1){
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
?>
	
<?php
//Here handles fetching of the records on page load
	if(isset($_GET['action'])){
		if(isset($_GET['id']) && !empty($_GET['id'])){
				$getformerdetail = "SELECT * FROM properties WHERE (property_ID = '".$_GET['id']."' AND uploadby = '$profile_name')";
				$getquery = mysql_query($getformerdetail);
				if($getquery){
					if(mysql_affected_rows($db_connection)==1){
					while($detail = mysql_fetch_array($getquery,MYSQL_ASSOC)){
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
					}
					}else{ $fetchReport = "<div color:\" class=\"operation-fail-container\"><span class=\"black-icon warning-icon\"></span>ID is invalid or you do not have authorization to review this property</div>";}
				}else{$fetchReport = "<div class=\"operation-fail-container\"><span class=\"black-icon warning-icon\"></span>Couldn't get the property details</div>";}
			
		}
		else{
			$fetchReport = "No valid ID to operate on";
		}
	}
	else{
		header('location: index.php');
		mysql_close($db_connection);
		exit();
	}
	
if(isset($fetchReport)){
		echo "<p align=\"center\">$fetchReport</p>";
		mysql_close($db_connection);
		exit();
	}

	
//Get all the available images
$lastImage = 0;
$newimage = 1;
$allImages = "";
for($image = 1; $image<=10; $image++){
if(checkForImage($editdir,$editid."_0$image.png") != ""){
	$allImages .= checkForImage($editdir,$editid."_0$image.png");
	$lastImage = $image;
	$newimage = $lastImage+1;
}
}

	//here handles upload of photo
if(isset($_FILES['photo'])){
	$allowed = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
$mb = ($_FILES['photo']['size'])/1000000;
if(in_array(($_FILES['photo']['type']),$allowed)){
	if (move_uploaded_file ($_FILES['photo']['tmp_name'],"../properties/$editdir/$editid"."_0$newimage".".png")) {
	$photoupload_report = " One new Photo added successfully";
	$image_upload_status =1;
	//update the last reviewed
	mysql_query("UPDATE properties SET last_reviewed = $now WHERE property_ID= '$editid'");
	//add the new image 
	$allImages .= checkForImage($editdir,$editid."_0$newimage.png");
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


?>

<div id="all-edit-wrapper">
  <?php 
//Here gives the report of the editing. successful or fail
if(isset($changeReport)){
switch ($case){
	case 1:
	$icon = "tick-icon";
	$class = "operation-report-container";
	break;
	case 3:
	$icon =  "cross-icon";
	$class = "operation-fail-container";
	break;
		default:
	$icon = "cross-icon";
	$class = "operation-fail-container";
	break;
}
echo "<div style=\"font-size:150%\" class=\"$class\"><span class=\"black-icon $icon\"></span> $changeReport</div>";
}
	?>
  
<h3><?php echo "<a id=\"legend\" href=\"$root/properties/$editdir\">".$editid .": ".$edittype."</a>" ?></h3>

<div class="edit-box-container">
<p><span class="black-icon location-icon"></span><?php echo $editlocation ?></p>

  </div>
<div>
<div><span class="black-icon eye-icon"></span><?php echo $views ?> views</div>
<div class="time">Last reviewed : <?php echo (Timestamp($LR)=='sometime ago' ? "<span style=\"color:red\">Not reviewed yet</span>" : Timestamp($LR)) ?></div>
</div>

<div id="images-area">
<?php 
//if there is no any photo
if($allImages == ""){
echo "<div style=\"border:1px solid #e3e3e3; padding:2%;text-align:center\">
<p style=\"color:red\"><span class=\"black-icon warning-icon\"></span>You have not added any photo to this pproperty</p>
<p style=\"color:grey\">Adding photo to your properties impress clients more and give them clue on what the property looks like.</p>
</div>";
}
else{
echo $allImages;
}
?>	
<div>
<?php
//The photo upload report is printed here
if(isset($photoupload_report) && !empty($photoupload_report)){
	if($image_upload_status == 1){
echo "<div style=\" width:60%;color:green; margin:1%; padding:1%; border:1px solid green; text-align:center;\">$photoupload_report</div>";
	}
	else{
echo "<div style=\"width:60%; color:red;  margin:1%; padding:1%; border:1px solid red;text-align:center;\">$photoupload_report</div>";
	}
}
?>
<a id="add-photo-link"><span class="black-icon camera-icon"></span><?php echo ($allImages =="" ? "Add photo" : "Add more photo")?></a>
<div class ="edit-box" id="add-photo-box">

<div class="edit-box-container">
<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
<input type="hidden" name="photoname" value="<?php echo $ID."_0$image";?>" />
<input type="file" name="photo" size="30" style="background-color:#eee;"/>
<input type="submit" value="upload" size="50" class="deepblue-inline-block-link" style="border:none">
</form>
</div>

</div>
</div>

	</div>

<div id="edit-area">
<fieldset>
<form action="<?php $_PHP_SELF ?>" method="POST">
<input name="id" type="hidden" value="<?php echo $editid ?>" />

<div class="edit-box-container">
<p class="stay-on-a-line">Rent: <?php echo number_format($editrent)?> <span id="editrent_link" class="edit-link"><span class="black-icon edit-icon"></span></span></p>
<div class ="edit-box" id="editrent_box"><input placeholder="Rent" name="rent" type="number" value="<?php echo $editrent ?>"/></div>
</div>

<div class="edit-box-container">
<p>Minimum Payment required: <?php echo $editmp?> <span id="editmp_link" class="edit-link"><span class="black-icon edit-icon"></span></span></p>
<div div class ="edit-box" id="editmp_box">
<input name="oldminPay" type="hidden" value="<?php echo $editmp?>"/>
<input class="dumb-input" name="newminPay" checked="true" type="radio" value="0"/>
<input name="newminPay"  type="radio" value="1 Year"/>1 Year
<input name="newminPay"  type="radio" value="1 Year, 6 Months"/>1 Year 6 Months
<input name="newminPay"  type="radio" value="2 Years"/>2 Years
</div>
</div>

<div class="edit-box-container">
<p>Bathroom(s): <?php echo $editbath ?></p>
<p>Toilet(s): <?php echo $edittoilet ?></p>
</div>


<h3 class="headings">Water Supply</h3>
<div class="edit-box-container">
<p style="color:grey">Check if presence or uncheck if absent</p>

<div>
<input name="oldpm" type="hidden" value="<?php echo $editpm?>"/>
<input name="newpm" type="checkbox" value="Yes" <?php echo checkbox($editpm,'Yes') ?>/>  Pumping Machine
</div><br/>

<div> 
<input name="oldbh" type="hidden" value="<?php echo $editbh?>"/>
<input name="newbh" type="checkbox" value="Yes" <?php echo checkbox($editbh,'Yes') ?> />  Borehole
</div><br/>

<div>
<input name="oldwell" type="hidden" value="<?php echo $editwell?>"/>
<input name="newwell" type="checkbox" value="Yes" <?php echo checkbox($editwell,'Yes') ?> />   Well
</div>

</div>

<h3 class="headings">Others</h3>
<div class="edit-box-container">
<p style="color:grey">Check if presence or uncheck if absent</p>

<div>
<input name="oldtiles" type="hidden" value="<?php echo $edittiles?>"/>
<input name="newtiles" type="checkbox" value="Yes" <?php echo checkbox($edittiles,'Yes') ?> />   Tiles
</div><br/>

<div>
<input name="oldps" type="hidden" value="<?php echo $editps?>"/>
<input name="newps" type="checkbox" value="Yes" <?php echo checkbox($editps,'Yes') ?>/>   Parking Space
</div><br/>

</div>

<h3 class="headings">Property Description</h3>
<div class="edit-box-container" id="edit-box-container-description">
<?php echo (empty($editdescription) ? "<span style=\"color:red\"><span class=\"black-icon warning-icon\"></span>No description</span>" : "$editdescription" ) ?> <span id="editdescription_link" class="edit-link"><span class="black-icon edit-icon"></span></span>
<div class ="edit-box" id="editdescription_box"><textarea name="description" placeholder="Give a brief description of the property" id="description-textarea"><?php echo $editdescription ?></textarea></div>
</div>

<h3 class="headings">Property Rating</h3>

<div class="edit-box-container">
<p>Electricity:<input type="hidden" name="oldElectricity" value="<?php echo $editelectricity ?>" />
 <?php echo $editelectricity."%" ?> <span id="editelectricity_link" class="edit-link"><span class="black-icon edit-icon"></span></span></p>
<div class ="edit-box" id="editelectricity_box">Electricity <select name="newElectricity">
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
</select></div>
</div>

<div class="edit-box-container">
<p>Road:<input type="hidden" name="oldRoad" value="<?php echo $editroad ?>" />
 <?php echo $editroad."%" ?> <span id="editroad_link" class="edit-link"><span class="black-icon edit-icon"></span></span></p>
<div class ="edit-box" id="editroad_box">Road <select name="newRoad">
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
</select></div>
</div>

<div class="edit-box-container">
<p>Socialization: <input type="hidden" name="oldSocial" value="<?php echo $editsocial ?>" />
<?php echo $editsocial."%" ?> <span id="editsocial_link" class="edit-link"><span class="black-icon edit-icon"></span></span></p>
<div class ="edit-box" id="editsocial_box">Socialization <select name="newSocial">
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
</select></div>
</div>

<div class="edit-box-container">
<p>Security: <input type="hidden" name="oldSecurity" value="<?php echo $editsecurity ?>" />
<?php echo $editsecurity."%" ?> <span id="editsecurity_link" class="edit-link"><span class="black-icon edit-icon"></span></p>
<div class ="edit-box" id="editsecurity_box">Security <select name="newSecurity">
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
</select></div>
</div>

</fieldset>

<input id="submit-edit-btn" type="submit" name="edit" value="Save changes"/>
</form>
<form style="padding:0px;margin:0px;" action="delete.php" method="POST">
<input name="deleteid" type="hidden" value="<?php echo $editid ?>"/>
 <button name="submitdelete" id="deletebtn" type="submit" value="delete"><span class="white-icon delete-icon"></span> Delete this property</button>
  </form>
 </div>
 
 </div>
<div>
<?php 
mysql_close($db_connection);
require('../require/footer.html'); ?></div>
</body>
</html>