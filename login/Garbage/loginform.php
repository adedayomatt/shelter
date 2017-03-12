


<body class="pic-background">
			<div class="main">
			<div class="sub_main">
			<p align="center"><b><?php echo $msg;?></p></b>
<?php

if(isset($_POST['log'])){
	
require('../agents/fetchprofiles.php');

foreach($user_id as $check){
	if($_POST['username']  == $check){
		$exists = $check;
		}
}
		if(isset($exists)){
	
		$getpass_query = "SELECT password FROM profiles WHERE User_ID =\"".$_POST['username']."\"";
			$inquire_password = mysql_query($getpass_query,$db_connection);
			while($outcome = mysql_fetch_array($inquire_password,MYSQL_ASSOC)){
				//echo "password is: ".$outcome['password'];
				if($_POST['passw']==$outcome['password']){
					if(isset($_POST['cookietime'])){
					setcookie('name',$_POST['username'],time()+2592000,"/","",0);
					}
					else{
						setcookie('name',$_POST['username'],time()+14400,"/","",0);
					}
					header('location: ../../shelter');
					exit();
					
				}
				else{
					echo "<p style=\"color: red\"><b>Incorect password</b></p>";
				}
			}
			
		}
		else{
		echo "<p style=\"color: red\">user Id <b>'".$_POST['username']."'</b> does not exists<br/>check your input or <a href=\"http://localhost/shelter/signup\">create a new account</a></p>";
			
		}
}
?>
			
			<form action="<?php $_PHP_SELF ?>" method="post">
			<fieldset align="center" class="form"><legend>Login details</legend>
			<label class="form">User ID: <input name="username" size="40" maxlength="30" type="text" required="required" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>"></label><br><br>
			<label class="form">Password: <input name="passw" size="30" maxlength="30" type="password" required="required" ></label><br><br>
			<label><input name="cookietime" type="checkbox" value="keepme">keep me logged in</label><br/><br/>
			<input name="log"  type="submit" value="login">
			<p align="right"><a href="#">forgot password?</a></p>
			<p align="left"><a href="../signup">create a new account</a></p>
			</fieldset></form>
			</div>
			<div class="sub_main">
			<p id="q"align="left">Are you Land and Estate agents?, Do you need a place to advertise your properties on the internet?
			<br/><b>GOOD NEWS!!!</b> <a href="index.php">shelter.com</a> is all you need.<br/><a href="signup.php">sign up</a> today.
			</p></div>
			<style>
			#q{
			font-size:20px;}
			</style>
		
			</div>
			</body>
