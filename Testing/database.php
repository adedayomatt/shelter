
<?php
$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthews';
$db = 'firstdb';
$connect = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $connect ) {
die('Connection not Established: ' . mysql_error());
}
echo '<h2>Connected successfully</h5><br/>';

$sql = "INSERT INTO Names(surname,lastname)VALUES('Matthews',SHA1('Witness'))";
mysql_select_db('firstdb');
$retval = mysql_query( $sql, $connect );
if(! $retval ) {
die('Could not enter data: ' . mysql_error());
}
echo "Entered data successfully\n";
mysql_close($connect);
?>