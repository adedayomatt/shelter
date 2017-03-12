<?php
//if delete is confirmed by clicking yes, the delete record
if(isset($_POST['delete'])){
require('../require/db_connect.php');
			if($db_connection){
				mysql_select_db('shelter');
				$delete = "DELETE FROM properties WHERE properties.property_ID='".$_POST['finaldeleteid']."'";
				$deletequery = mysql_query($delete,$db_connection);
				if($deletequery){
					if(mysql_affected_rows($db_connection)==1){
					echo "<script>alert(\"Property delete successfully\");window.location=\"index.php\";</script>"; 
					exit();
					}else{echo "<script>alert(\"Something went wrong\");window.location=\"index.php\";</script>";exit();}
				}
				mysql_close($db_connection);
			}else{echo "<script>alert(\"Could not connect to the server\");window.location=\"index.php\";</script>";exit();}
}
?>
<?php 
//if no id is passed on loading this page, redirect to the index
if(!isset($_POST['deleteid'])){
	header('location: index.php');
	exit();
}
?>

<html>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<?php
//Here handles delete
$pagetitle = 'Delete?';
	require('../require/user_header.php');
	?>
<script type="text/javascript" src="../js/editscript.js"></script>
</head>
<body class="pic-background"><p align="center"><br/>Are you sure you want to delete this property with id <strong><?php echo $_POST['deleteid'] ?></strong>
<div style="display:inline-block">
<a href="index.php"><button>No</button></a>
<form action="<?php $_PHP_SELF ?>" method="POST">
<input type="hidden" name="finaldeleteid" value="<?php echo $_POST['deleteid']?>" id="delete-btn"/>
<input type="submit" name="delete" value="Yes" id="delete-btn"/>
</form>
</div>
</body>
</html>