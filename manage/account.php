<html>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/management_styles.css" type="text/css" rel="stylesheet" />
<?php 
	$pagetitle = "Account";
	$ref='editaccount';
$getuserName=true;
$connect =true;
require('../require/header.php');
if($status==0 || $status==9){
	mysql_close($db_connection);
	redirect();
}
?>
</head>
<body class="pic-background">
<br/>
<?php
// Here handles editing of record
if(isset($_POST['edit'])){

			$update = "UPDATE profiles SET "; 
			$update .= "Office_Address='".mysql_real_escape_string($_POST['OfficeAddress'])."',";
			$update .= "Office_Tel_No=".$_POST['OfficeTelNo'].",";
			$update .= "Business_email='".mysql_real_escape_string($_POST['Businessmail'])."',";
			$update .= "CEO_Name='".mysql_real_escape_string($_POST['CEOName'])."',";
			$update .= "Phone_No=".$_POST['Phone1'].",";
			$update .= "Alt_Phone_No=".$_POST['Phone2'].",";
			$update .= "email='".mysql_real_escape_string($_POST['email'])."' ";
			$update .= "WHERE (ID=".$_POST['id'].")";
			
			$updateQuery = mysql_query($update);
			if($updateQuery){ 
				if(mysql_affected_rows($db_connection)==1){
					$editresult = "Changes saved successfully";
					$case = 1;
				}
				else if(mysql_affected_rows($db_connection)>1){
					$editresult = "Oops!, Something went wrong";
					$case = 2;
				}
				else{
					$editresult = "No changes were made";
					$case = 3;
				}
			}
			else{
				$editresult = "Changes could not be saved due to some errors";
				$case = 4;
			}
			
			}
?>
<?php 
//Here gives the repoort of the editing. successful or fail
if(isset($editresult)){
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
echo "<div style=\"".$generalstyle.$specialstyle."\"><i style=\"$icon\" class=\"white-icon\"></i>  $editresult</div>";
}
	?>
	<?php
	//Here fetches the account detail on page load
		
				$getformerdetail = "SELECT * FROM profiles WHERE (User_ID = '".$profile_name."')";
				$getquery = mysql_query($getformerdetail);
				if($getquery){
					if(mysql_affected_rows($db_connection)==1){
					while($account = mysql_fetch_array($getquery,MYSQL_ASSOC)){
						$editid = $account['ID'];
						$editBN = $account['Business_Name'];
						$editOfficeAddress = $account['Office_Address'];
						$editOfficeTelNo = $account['Office_Tel_No'];
						$editBusinessmail = $account['Business_email'];
						$editCEO = $account['CEO_Name'];
						$editPhoneno = $account['Phone_No'];
						$editAltPhoneno = $account['Alt_Phone_No'];
						$editemail = $account['email'];
						$editUsername = $account['User_ID'];
					}
					}else{echo $accountreport = "Account is invalid or might have been blocked or deactivated"; }
				}else{$accountreport="Invalid Account";}
		
	
if(isset($accountreport) && !empty($accountreport)){
	echo "<p style=\"color:red\" align=\"center\">  $accountreport</p>";
	echo "<p align=\"center\"><a href=\"#\">Report this</a> or <a href=\"#\">Sign up</a> a new account</p>";
	exit();
}
	?>
<div id="edit-area">
<fieldset>
<legend style="color:#6D0AAA"><strong><?php echo "<a href=\"$root/$editUsername\">".$editBN."</a>" ?></strong></legend>
<form action="delete.php" method="POST">
<input name="deleteid" type="hidden" value="<?php echo $editid ?>"/>
 <button name="submitdelete" id="deactivatebtn"type="submit" value="delete"><i class="icon" id="delete-icon"></i> Deactivate account</button>
  </form>
  
<form action="<?php $_PHP_SELF ?>" method="POST">
<input name="id" type="hidden" value="<?php echo $editid ?>" />
Office Address:
<input placeholder="Office Address" name="OfficeAddress" type="text" size="50" required="required" value="<?php echo $editOfficeAddress ?>"/><br/><br/>

Office Tel Number:
<input placeholder="office Telephone Number" name="OfficeTelNo" type="text" maxlength="11"  required="required" value="<?php echo $editOfficeTelNo?>"/><br/><br/>

Business email: 
<input placeholder="Business email address" name="Businessmail" type="email" size="30" value="<?php echo $editBusinessmail ?>"/><br/><br/>
<p><strong>Manager's Profile</strong></p>
Name: 
<input placeholder="CEO's full name" name="CEOName" type="text" size="40" required="required" value="<?php echo $editCEO ?>"  /><br/><br/>

Phone No: 
<input placeholder="CEO's active phone number" name="Phone1" type="text" maxlength="11" required="required" value="<?php echo $editPhoneno ?>" /><br/><br/>

Alternative Phone No: 
<input placeholder="CEO's alternative active phone number" name="Phone2" type="text" maxlength="11" value="<?php echo $editAltPhoneno ?>" /><br/><br/>

email: 
<input placeholder="CEO's working email address" name="email" type="email" size="30" value="<?php echo $editemail ?>" /><br/><br/>
<input id="submit-btn" type="submit" name="edit" value="Save changes"/>
</form>
</fieldset>
 </div>
 <br/><br/><br/>
<?php 
mysql_close($db_connection);
require('../require/footer.html'); ?>
</body>
</html>