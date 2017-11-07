<?php 
require('../resources/php/master_script.php'); 
if($status != 1){
	$general->redirect('login?return='.$thisPage);
}
?>
<html>
<head>
<?php
 $pagetitle = "Account";
	$ref='editaccount_page';
	require('../resources/global/meta-head.php'); ?>
<?php
// Here handles editing of record
if(isset($_POST['edit'])){

			$update = "UPDATE profiles SET "; 
			$update .= "Office_Address='".($_POST['OfficeAddress'])."', ";
			$update .= "Office_Tel_No=".$_POST['OfficeTelNo'].",";
			$update .= "Business_email='".($_POST['Businessmail'])."', ";
			$update .= "CEO_Name='".($_POST['CEOName'])."', ";
			$update .= "Phone_No=".$_POST['Phone1'].", ";
			$update .= "Alt_Phone_No=".$_POST['Phone2'].", ";
			$update .= "email='".($_POST['email'])."' ";
			$update .= "WHERE (ID=".$_POST['id'].")";
			
			$updateQuery = $db->query_object($update);
			
				if($connection->affected_rows==1){
					$editresult = "Changes saved successfully";
					$case = 1;
				}
				else if($connection->affected_rows > 1){
					$editresult = "Oops!, Something went wrong";
					$case = 2;
				}
				else{
					$editresult = "No changes were made";
					$case = 3;
				}
			
			}

	//Here fetches the account detail on page load
		
				$getformerdetail = "SELECT * FROM profiles WHERE (User_ID = '".$profile_name."')";
				$getquery = $db->query_object($getformerdetail);
					if($getquery->num_rows ==1){
					while($account = $getquery->fetch_array(MYSQLI_ASSOC)){
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
				
	
	?>

</head>
<body class="plain-colored-background">
<?php 
$altHeaderContent ="Edit Account";
require('../resources/global/alt_static_header.php');
?>
<div class="container-fluid body-content" style="padding-top:60px">
<div class="center-content">
<div class="white-background padding-10 e3-border box-shadow-1">
<?php
if(isset($accountreport) && !empty($accountreport)){
	?>
<div class="operation-report-container fail"><?php echo $accountreport ?></div>
	<?php
} 
//Here gives the repoort of the editing. successful or fail
if(isset($editresult)){
	?>
<div class="operation-report-container success"><?php echo $editresult ?></div>
	<?php
}
	?>

<fieldset>
<a href="<?php echo "$root/$editUsername" ?>"><h3 class="major-headings"><?php echo $editBN ?></h3></a>  
<form action="<?php $_PHP_SELF ?>" method="POST">
<input name="id" type="hidden" value="<?php echo $editid ?>" />

<div class="form-group">
<label><span class="glyphicon glyphicon-map-marker red"></span>Office Address</label>
<input class="form-control" placeholder="Office Address" name="OfficeAddress" type="text" size="50" required="required" value="<?php echo $editOfficeAddress ?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Office Tel Number</label>
<input class="form-control" placeholder="office Telephone Number" name="OfficeTelNo" type="text" maxlength="11"  required="required" value="<?php echo $editOfficeTelNo?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>Business email </label>
<input class="form-control" placeholder="Business email address" name="Businessmail" type="email" size="30" value="<?php echo $editBusinessmail ?>"/>
</div>

<h3 class="major-headings">Manager's Profile</h3>

<div class="form-group">
<label>Name</label> 
<input class="form-control" placeholder="CEO's full name" name="CEOName" type="text" required="required" value="<?php echo $editCEO ?>"  />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Phone No</label>
<input class="form-control" placeholder="CEO's active phone number" name="Phone1" type="text" maxlength="11" required="required" value="<?php echo $editPhoneno ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Alternative Phone No</label> 
<input class="form-control" placeholder="CEO's alternative active phone number" name="Phone2" type="text" maxlength="11" value="<?php echo $editAltPhoneno ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>email</label> 
<input class="form-control" placeholder="CEO's working email address" name="email" type="email"  value="<?php echo $editemail ?>" />
</div>

<h3 class="major-headings">Login</h3>

<div class="form-group">
<label><span class="glyphicon bold red"></span>username</label> 
<input class="form-control" placeholder="username" name="" type="email"  value="<?php echo $editUsername ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon bold red"></span>change password</label> 
<input class="form-control" placeholder="old password" name="email" type="password"  />
</div>

<div class="form-group">
<label><span class="glyphicon bold red"></span>new password</label> 
<input class="form-control" placeholder="new password" name="" type="password"  />
</div>
<input class="btn btn-primary" type="submit" name="edit" value="Save changes"/>
</form>
</fieldset>

<form action="delete.php" method="POST">
<input name="deleteid" type="hidden" value="<?php echo $editid ?>"/>
 <button name="submitdelete" class="btn btn-danger" type="submit" value="delete"><span class="glyphicon glyphicon-trash"></span> Deactivate account</button>
  </form>
 </div>
 </div>
 </div>
<?php 
require('../resources/global/footer.php'); ?>
</body>
</html>