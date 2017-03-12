<?php
$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthews';
$db_connection = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $db_connection ) {
die('There was an error while connecting to the Database<br/>' . mysql_error());
}
mysql_select_db('shelter');

if(isset($_POST['pass'])){
$password = $_POST['pass'];
$query = "INSERT INTO testing (password)VALUES(SHA1('ade'))";
$g = mysql_query($query,$db_connection);
if($g){
	
	echo "password added successfully";
}
else{
	echo "there was an error!!";
}
}
mysql_close($db_connection);
	$alphabets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$i = 0;
	while($i<=25){
		echo $alphabets[$i];
		$i++;
	}
?>

<html>
<header><title>Data Encryption</title></header>
<body>
<form action=<?php $_PHP_SELF ?> method="post">
<label for="pass">input a password:</label>
<input type="password" size="20" name="pass"/><br/>
<input name="sub" type="submit" value="Go!!"/>
</form>
</body>

</html>