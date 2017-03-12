<?php
require('php_connect.php');

$error = array();
if(isset($_POST['sign']))
{
	
	
	$CN = $_POST['Company_name'];
	$OA = $_POST['Office_Address'];
	$Tel = $_POST['Office_No'];
	$Om = $_POST['Office_mail'];
	$PN =$_POST['personal_name'];
	$N =$_POST['personal_No'];
	$NN =$_POST['personal_No2'];
	$Pm =$_POST['personal_mail'];
	
	if(empty($CN)){
		$error[] = 'Company is missing';
	}
	 if(empty($OA)){
		$error[] = 'Office Asdress is missing';
	}
	 if(empty($Tel)){
		$error[] = 'Office Tel No is missing';
	}
	 if(empty($Om)){
		$error[] = 'Office email is missing';
	}
	 if(empty($PN)){
		$error[] = 'Personal Name is missing';
	}
	 if(empty($N)){
		$error[] = 'Phone Number is missing';
	}
	  if(empty($NN)){
		$error[] = 'Alternative phone Number is missing';
	}
	 if(empty($Pm)){
		$error[] = 'Personal mail is missing';
		}
$data = "INSERT INTO ahents(Company_Name,Office_Address,Office_Num,Office_mail,Personnal_Name,Personal_Num,Personal_Num2,Personal_Mail)VALUES('$CN','$OA',$Tel,'$Om','$PN',$N,$NN,'$Pm')";
		mysql_select_db('firstdb');
	$reg = mysql_query($data,$conn);
	if($reg ) {
		echo('<h2>Data added successfully</h2>');
	}
else{
	echo('Could not enter Information: <br/>ERRORS: ');
	foreach($error as $errormsg){
		echo "<br/>* $errormsg "	;
	}

echo('Technical issue: '.mysql_error().'<br/>Try Again');

}
	
	mysql_close($conn);
	
}

			
?>