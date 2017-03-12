<html>

<form action="register.php" method="post" onsubmit="">

			<fieldset class="company">
			<legend><b>Company Information</b></legend>
			<label>Company's Registered Name: <input name="Company_name" size="60" maxlength="50" type="text" value="<?php if(isset($_POST['Company_Name'])) echo($_POST['Company_Name'])?>"></label><br><br>
			<label>Office Address: <input name="Office_Address" size="100" maxlength="150" type="text" value="<?php if(isset($_POST['Office_Address'])) echo($_POST['Office_Address'])?>"></label><br><br>
			<label>Office Tel No: <input name="Office_No" size="30" maxlength="11" type="text" value="<?php if(isset($_POST['Office_No'])) echo($_POST['Office_No'])?>"></label><br><br>
			<label>Company's e-mail: <input name="Office_mail" size="30" maxlength="30" type="text" value="<?php if(isset($_POST['Office_mail'])) echo($_POST['Office_mail'])?>"></label><br><br>
			</fieldset>
			<fieldset class="personal">
			<legend><b>Personal Information</b></legend>
			<label>CEO Name: <input name="personal_name" size="60" maxlength="50" type="text" value="<?php if(isset($_POST['personal_name'])) echo($_POST['personal_name'])?>"></label><br><br>
			<label>Phone No: <input name="personal_No" size="40" maxlength="11" type="text" value="<?php if(isset($_POST['personal_No'])) echo($_POST['personal_No2'])?>"></label><br><br>
			<label>Alternative Phone No: <input name="personal_No2" size="40" maxlength="11" type="text" value="<?php if(isset($_POST['personal_No2'])) echo($_POST['personal_No2'])?>"></label><br><br>
			<label>e-mail: <input name="personal_mail" size="30" maxlength="30" type="text" value="<?php if(isset($_POST['personal_mail'])) echo($_POST['personal_mail'])?>"></label><br><br>
			</fieldset>
			 <input name="sign" value="sign up"  type="submit" class="signupbutton">
			</form>
			</html>