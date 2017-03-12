<html>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertyedit_styles.css" type="text/css" rel="stylesheet" />
<?php
	$pagetitle = "Change Detail";
	$ref='editproperty';
$getuserName=true;
	require('../require/header.php');
	if($status==0){
		redirect();
		exit();
	}
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
	
	require('../require/db_connect.php');
			if($db_connection){
			mysql_select_db('shelter');
			
			if(isset($_POST['newpm'])){
				$newpm = $_POST['newpm'];
			}else{$newpm='No';}
			if(isset($_POST['newbh'])){
				$newbh = $_POST['newbh'];
			}else{$newbh='No';}
			if(isset($_POST['newwell'])){
				$newwell = $_POST['newwell'];
			}else{$newwell='No';}
			if(isset($_POST['newtiles'])){
				$newtiles = $_POST['newtiles'];
			}else{$newtiles='No';}
			if(isset($_POST['newps'])){
				$newps = $_POST['newps'];
			}else{$newps='No';}
			
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
			$update .= "description='".mysql_real_escape_string($_POST['description'])."' ";
			$update .= "WHERE (property_ID='".$_POST['id']."')";
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
			mysql_close($db_connection);}
}

?>
<?php 
//Here gives the report of the editing. successful or fail
if(isset($changeReport)){
	$generalstyle = "width:20%; height: 35px;  color:white; border-radius:5px; margin-left:5px;";
switch ($case){
	case 1:
	$specialstyle = " background-color: green; ";
	$icon = "background-position:-288px 0px";
	break;
	case 3:
	$specialstyle = " background-color: red;";
	$icon =  "background-position: -312px 0px";
	break;
		default:
	$specialstyle = " background-color: red; ";
	$icon = "background-position:-312px 0px";
	break;
}
echo "<br/><div style=\"".$generalstyle.$specialstyle."\"><i style=\"$icon\" class=\"white-icon\"></i> $changeReport</div>";
}
	?>
	
<?php
//Here handles fetching of the records on page load
	if(isset($_GET['action'])){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			require('../require/db_connect.php');
			if($db_connection){
				mysql_select_db('shelter');
				$getformerdetail = "SELECT * FROM properties WHERE (property_ID = '".$_GET['id']."')";
				$getquery = mysql_query($getformerdetail,$db_connection);
				if($getquery){
					if(mysql_affected_rows($db_connection)==1){
					while($detail = mysql_fetch_array($getquery,MYSQL_ASSOC)){
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
					}
					}else{ $fetchReport = "ID is invalid or the property may have been deleted";}
				}else{$fetchReport = "Couldn't get the property details";}
			mysql_close($db_connection);
			}else{$fetchReport = "There was an error in connection";}
			
		}
		else{
			$fetchReport = "No valid ID to operate on";
		}
	}
	else{
		header('location: index.php');
		exit();
	}
	
	if(isset($fetchReport)){
		echo "<p align=\"center\">$fetchReport</p>";
		exit();
	}
	
	
	
	function checkbox($source,$condition){
		if($source==$condition){
			return "checked=\"checked\"";
		}else{ return null;}
	}
	function checkForImage($imgName){
	$imgDir = "../images/";
	if(file_exists($imgDir.$imgName)){
		$image = "<img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgDir.$imgName."\"/>";
		
		}else
		{
			$image = "<img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgDir.$imgName."\"/>";
		}
		return $image;
	
}
?>
<br/>
<div id="images-area">
<?php 	echo checkForImage($editid."_01.png"); 
		echo checkForImage($editid."_02.png"); 
		echo checkForImage($editid."_03.png"); 
		echo checkForImage($editid."_04.png"); 

?>	
	</div>

<div id="edit-area">
<fieldset>
<legend style="color:#6D0AAA"><strong><?php echo "<a href=\"http://localhost/shelter/detail.php?shid=$editid\">".$editid .": ".$edittype." at ".$editlocation."</a>" ?></strong></legend>

<form action="delete.php" method="POST">
<input name="deleteid" type="hidden" value="<?php echo $editid ?>"/>
 <button name="submitdelete" id="deletebtn"type="submit" value="delete"><i class="white-icon" id="delete-icon"></i> Delete</button>
  </form>
  
<form action="<?php $_PHP_SELF ?>" method="POST">
<input name="id" type="hidden" value="<?php echo $editid ?>" />
<p class="stay-on-a-line">Rent: <?php echo number_format($editrent)?> <span id="editrent_link" class="edit-link"><i class="icon"></i> edit</span></p>
<div class ="edit-box" id="editrent_box"><input placeholder="Rent" name="rent" type="number" value="<?php echo $editrent ?>"/></div>

<p>Minimum Payment required: <?php echo $editmp?> <span id="editmp_link" class="edit-link"><i class="icon"></i> edit</span></p>
<div div class ="edit-box" id="editmp_box">
<input name="oldminPay" type="hidden" value="<?php echo $editmp?>"/>
<input class="dumb-input" name="newminPay" checked="true" type="radio" value="0"/>
<input name="newminPay"  type="radio" value="1 Year"/>1 Year
<input name="newminPay"  type="radio" value="1 Year, 6 Months"/>1 Year 6 Months
<input name="newminPay"  type="radio" value="2 Years"/>2 Years
</div>
<p>Bathroom(s): <?php echo $editbath ?></p>
<p>Toilet(s): <?php echo $edittoilet ?></p>
<p><i>check for presence or uncheck if absent</i></p>
<p><strong>Water Supply</strong></p>
<p>Pumping Machine: <span> <input name="oldpm" type="hidden" value="<?php echo $editpm?>"/>
<input name="newpm" type="checkbox" value="Yes" <?php echo checkbox($editpm,'Yes') ?>/></span>

Borehole:<span><input name="oldbh" type="hidden" value="<?php echo $editbh?>"/>
<input name="newbh" type="checkbox" value="Yes" <?php echo checkbox($editbh,'Yes') ?> /></span>

Well:<span><input name="oldwell" type="hidden" value="<?php echo $editwell?>"/>
<input name="newwell" type="checkbox" value="Yes" <?php echo checkbox($editwell,'Yes') ?> /></span>
</p>

<p><strong>Others</strong></p>
<p>Tiles:<span><input name="oldtiles" type="hidden" value="<?php echo $edittiles?>"/>
<input name="newtiles" type="checkbox" value="Yes" <?php echo checkbox($edittiles,'Yes') ?> /></span>

Parking Space: <span><input name="oldps" type="hidden" value="<?php echo $editps?>"/>
<input name="newps" type="checkbox" value="Yes" <?php echo checkbox($editps,'Yes') ?>/></span>
</p>

<p>Description: <i>"<?php echo $editdescription ?>"</i> <span id="editdescription_link" class="edit-link"><i class="icon"></i> edit</span></p>
<div class ="edit-box" id="editdescription_box"><textarea name="description" rows="4" cols="16"><?php echo $editdescription ?></textarea></div>

<h4>Property Rating</h4>

<p>Electricity:<input type="hidden" name="oldElectricity" value="<?php echo $editelectricity ?>" />
 <?php echo $editelectricity."%" ?> <span id="editelectricity_link" class="edit-link"><i class="icon"></i> change</span></p>
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

<p>Road:<input type="hidden" name="oldRoad" value="<?php echo $editroad ?>" />
 <?php echo $editroad."%" ?> <span id="editroad_link" class="edit-link"><i class="icon"></i> change</span></p>
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

<p>Socialization: <input type="hidden" name="oldSocial" value="<?php echo $editsocial ?>" />
<?php echo $editsocial."%" ?> <span id="editsocial_link" class="edit-link"><i class="icon"></i> change</span></p>
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

<p>Security: <input type="hidden" name="oldSecurity" value="<?php echo $editsecurity ?>" />
<?php echo $editsecurity."%" ?> <span id="editsecurity_link" class="edit-link"><i class="icon"></i> change</span></p>
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
</fieldset>
<input id="submit-btn" type="submit" name="edit" value="Save changes"/>
</form>
 </div>
<div>
<?php require('../require/footer.html'); ?></div>
</body>
</html>