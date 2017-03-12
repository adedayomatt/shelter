<?php
$mes ='this     page name      is '.dirname($_SERVER['PHP_SELF']);
echo $_SERVER['HTTP_HOST'];
//basename(]);
?>

<html>
<head>
<title>File Uploading Form</title>
</head>
<body>
<h3>File Upload:</h3>
Select a file to upload: <br />
<form enctype="multipart/form-data" action="upload.php" method="post">
<input type="file" name="file" size="50" />
<br />
<input type="submit" value="Upload File" />
</form>
</body>
</html>